<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\AdSlot;
use App\Models\Announcement;
use App\Models\Tenant;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Intervention\Image\ImageManager;
use RealRashid\SweetAlert\Facades\Alert;

class AnnouncementController extends Controller
{
    protected $pathUpload = 'admin/uploads/images/anuncio/';

    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        $check = checkPermission(
            'announcement',
            'anuncio.visualizar',
            $settingTheme
        );

        if ($check !== true) {
            return $check;
        }

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Permissões
        |--------------------------------------------------------------------------
        */

        $isSuper = $user?->hasRole('Super') ?? false;

        $isUsuarioMaster = $user?->can('usuario.tornar usuario master') ?? false;

        $canManageAllAnnouncements = $isSuper || $isUsuarioMaster;

        /*
        |--------------------------------------------------------------------------
        | Tema
        |--------------------------------------------------------------------------
        */

        $theme = $themeManager;

        $themeData = $themeManager->theme();

        /*
        |--------------------------------------------------------------------------
        | Tenant atual
        |--------------------------------------------------------------------------
        */

        $currentTenant = null;

        if (!$canManageAllAnnouncements) {
            $currentTenant = Tenant::current();
        }

        /*
        |--------------------------------------------------------------------------
        | Anúncios
        |--------------------------------------------------------------------------
        |
        | Super/Master:
        | - Visualizam todos os anúncios.
        |
        | Usuário comum:
        | - Visualiza anúncios destinados a todos.
        | - Visualiza anúncios específicos do tenant atual.
        |
        */

        $announcementsQuery = Announcement::with([
            'creator',
            'tenants',
            'adSlots',
        ]);

        if (!$canManageAllAnnouncements) {
            $announcementsQuery->where(function ($query) use ($currentTenant) {
                $query->where('target', 'all')
                    ->orWhereHas('tenants', function ($tenantQuery) use ($currentTenant) {
                        $tenantQuery->where(
                            'tenants.id',
                            $currentTenant->id
                        );
                    });
            });
        }

        $announcements = $announcementsQuery
            ->orderByDesc('created_at')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Clientes
        |--------------------------------------------------------------------------
        */

        if ($canManageAllAnnouncements) {
            $tenants = Tenant::orderBy('name')->get();
        } else {
            $tenants = collect([
                $currentTenant,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | AdSlots
        |--------------------------------------------------------------------------
        |
        | O acesso ao AdSlot é definido exclusivamente pelo
        | relacionamento tenant_ad_slot.
        |
        | Super/Master:
        | - Todos os AdSlots ativos.
        |
        | Usuário comum:
        | - Somente AdSlots autorizados para o Tenant atual.
        |
        */

        $adSlotsQuery = AdSlot::where('active', true);

        if (!$canManageAllAnnouncements) {
            $adSlotsQuery->whereHas('tenants', function ($query) use ($currentTenant) {
                $query->where(
                    'tenants.id',
                    $currentTenant->id
                );
            });
        }

        $adSlots = $adSlotsQuery
            ->orderBy('sorting')
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Limites
        |--------------------------------------------------------------------------
        */

        $aboutLimit = $themeManager->getLimit('about', 0);

        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.blades.announcement.index',
            compact(
                'tenants',
                'announcements',
                'adSlots',
                'theme',
                'themeData',
                'aboutLimit',
                'canManageAllAnnouncements'
            )
        );
    }

    public function store(Request $request)
    {
        $data = $request->except([
            'starts_at',
            'ends_at',
            'tenant_id',
            'ad_slot_ids',
        ]);

        $tenantIds = $request->input('tenant_id', []);
        $adSlotIds = $request->input('ad_slot_ids', []);

        $data['starts_at'] = $request->filled('starts_at')
            ? Carbon::createFromFormat('Y-m-d\TH:i', $request->starts_at)
            : null;

        $data['ends_at'] = $request->filled('ends_at')
            ? Carbon::createFromFormat('Y-m-d\TH:i', $request->ends_at)
            : null;

        /*
        |--------------------------------------------------------------------------
        | Validação dos AdSlots
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();

        $isSuper = $user->hasRole('Super');
        $isMaster = $user->can('usuario.tornar usuario master');

        if (!$isSuper && !$isMaster) {
            $tenant = Tenant::current();

            $allowedAdSlotIds = $tenant
                ->adSlots()
                ->whereIn('ad_slots.id', $adSlotIds)
                ->pluck('ad_slots.id')
                ->toArray();

            if (count($allowedAdSlotIds) !== count($adSlotIds)) {
                abort(403);
            }

            $adSlotIds = $allowedAdSlotIds;
        }

        /*
        |--------------------------------------------------------------------------
        | Imagens
        |--------------------------------------------------------------------------
        */

        $manager = new ImageManager(new ImagickDriver());

        // Anúncio horizontal
        if ($request->hasFile('path_image')) {
            $file = $request->file('path_image');
            $mime = $file->getMimeType();

            $filename = pathinfo(
                $file->getClientOriginalName(),
                PATHINFO_FILENAME
            ) . '_horizontal.webp';

            if ($mime === 'image/svg+xml') {
                Storage::putFileAs($this->pathUpload, $file, $filename);
            } else {
                $image = $manager->read($file)
                    ->resize(null, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(quality: 95)
                    ->toString();

                Storage::put(
                    $this->pathUpload . $filename,
                    $image
                );
            }

            $data['path_image'] = $this->pathUpload . $filename;
        }

        // Anúncio horizontal mobile
        if ($request->hasFile('path_image_mobile')) {
            $file = $request->file('path_image_mobile');
            $mime = $file->getMimeType();

            $filename = pathinfo(
                $file->getClientOriginalName(),
                PATHINFO_FILENAME
            ) . '_horizontal_mobile.webp';

            if ($mime === 'image/svg+xml') {
                Storage::putFileAs($this->pathUpload, $file, $filename);
            } else {
                $image = $manager->read($file)
                    ->resize(null, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(quality: 95)
                    ->toString();

                Storage::put(
                    $this->pathUpload . $filename,
                    $image
                );
            }

            $data['path_image_mobile'] = $this->pathUpload . $filename;
        }

        // Anúncio vertical
        if ($request->hasFile('path_image_vertical')) {
            $file = $request->file('path_image_vertical');
            $mime = $file->getMimeType();

            $filename = pathinfo(
                $file->getClientOriginalName(),
                PATHINFO_FILENAME
            ) . '_vertical.webp';

            if ($mime === 'image/svg+xml') {
                Storage::putFileAs($this->pathUpload, $file, $filename);
            } else {
                $image = $manager->read($file)
                    ->resize(null, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(quality: 95)
                    ->toString();

                Storage::put(
                    $this->pathUpload . $filename,
                    $image
                );
            }

            $data['path_image_vertical'] = $this->pathUpload . $filename;
        }

        $data['active'] = $request->boolean('active');
        $data['created_by'] = Auth::id();

        try {
            DB::beginTransaction();

            $announcement = Announcement::create($data);

            // Vincula os slots autorizados ao anúncio.
            $announcement->adSlots()->sync($adSlotIds);

            // Se for para clientes específicos, salva na tabela pivot.
            // Se for para todos, remove qualquer vínculo específico.
            if ($announcement->target === 'specific') {
                $announcement->tenants()->sync($tenantIds);
            } else {
                $announcement->tenants()->sync([]);
            }

            DB::commit();

            session()->flash(
                'success',
                __('dashboard.response_item_create')
            );
        } catch (Exception $e) {
            DB::rollBack();

            session()->flash(
                'error',
                __('dashboard.response_item_error_create')
            );
        }

        return redirect()->back();
    }

    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->except([
            'starts_at',
            'ends_at',
            'tenant_id',
            'ad_slot_ids',
        ]);

        $tenantIds = $request->input('tenant_id', []);
        $adSlotIds = $request->input('ad_slot_ids', []);

        $data['starts_at'] = $request->filled('starts_at')
            ? Carbon::createFromFormat('Y-m-d\TH:i', $request->starts_at)
            : null;

        $data['ends_at'] = $request->filled('ends_at')
            ? Carbon::createFromFormat('Y-m-d\TH:i', $request->ends_at)
            : null;

        /*
        |--------------------------------------------------------------------------
        | Validação dos AdSlots
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();

        $isSuper = $user->hasRole('Super');
        $isMaster = $user->can('usuario.tornar usuario master');

        if (!$isSuper && !$isMaster) {
            $tenant = Tenant::current();

            $allowedAdSlotIds = $tenant
                ->adSlots()
                ->whereIn('ad_slots.id', $adSlotIds)
                ->pluck('ad_slots.id')
                ->toArray();

            if (count($allowedAdSlotIds) !== count($adSlotIds)) {
                abort(403);
            }

            $adSlotIds = $allowedAdSlotIds;
        }

        /*
        |--------------------------------------------------------------------------
        | Imagens
        |--------------------------------------------------------------------------
        */

        $manager = new ImageManager(new ImagickDriver());

        // Anúncio horizontal
        if ($request->hasFile('path_image')) {
            $file = $request->file('path_image');
            $mime = $file->getMimeType();

            $filename = pathinfo(
                $file->getClientOriginalName(),
                PATHINFO_FILENAME
            ) . '_horizontal.webp';

            if ($mime === 'image/svg+xml') {
                Storage::putFileAs($this->pathUpload, $file, $filename);
            } else {
                $image = $manager->read($file)
                    ->resize(null, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(quality: 95)
                    ->toString();

                Storage::put(
                    $this->pathUpload . $filename,
                    $image
                );
            }

            if (!empty($announcement->path_image)) {
                Storage::delete($announcement->path_image);
            }

            $data['path_image'] = $this->pathUpload . $filename;
        }

        // Anúncio horizontal mobile
        if ($request->hasFile('path_image_mobile')) {
            $file = $request->file('path_image_mobile');
            $mime = $file->getMimeType();

            $filename = pathinfo(
                $file->getClientOriginalName(),
                PATHINFO_FILENAME
            ) . '_horizontal_mobile.webp';

            if ($mime === 'image/svg+xml') {
                Storage::putFileAs($this->pathUpload, $file, $filename);
            } else {
                $image = $manager->read($file)
                    ->resize(null, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(quality: 95)
                    ->toString();

                Storage::put(
                    $this->pathUpload . $filename,
                    $image
                );
            }

            if (!empty($announcement->path_image_mobile)) {
                Storage::delete($announcement->path_image_mobile);
            }

            $data['path_image_mobile'] = $this->pathUpload . $filename;
        }

        // Excluir anúncio horizontal
        if ($request->boolean('delete_path_image')) {
            if (!empty($announcement->path_image)) {
                Storage::delete($announcement->path_image);
            }

            $data['path_image'] = null;
        }

        // Anúncio vertical
        if ($request->hasFile('path_image_vertical')) {
            $file = $request->file('path_image_vertical');
            $mime = $file->getMimeType();

            $filename = pathinfo(
                $file->getClientOriginalName(),
                PATHINFO_FILENAME
            ) . '_vertical.webp';

            if ($mime === 'image/svg+xml') {
                Storage::putFileAs($this->pathUpload, $file, $filename);
            } else {
                $image = $manager->read($file)
                    ->resize(null, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(quality: 95)
                    ->toString();

                Storage::put(
                    $this->pathUpload . $filename,
                    $image
                );
            }

            if (!empty($announcement->path_image_vertical)) {
                Storage::delete($announcement->path_image_vertical);
            }

            $data['path_image_vertical'] = $this->pathUpload . $filename;
        }

        // Excluir anúncio vertical
        if ($request->boolean('delete_path_image_vertical')) {
            if (!empty($announcement->path_image_vertical)) {
                Storage::delete($announcement->path_image_vertical);
            }

            $data['path_image_vertical'] = null;
        }

        $data['active'] = $request->boolean('active');

        try {
            DB::beginTransaction();

            $announcement->fill($data)->save();

            // Atualiza os slots vinculados ao anúncio.
            $announcement->adSlots()->sync($adSlotIds);

            // Atualiza os tenants relacionados.
            if ($announcement->target === 'specific') {
                $announcement->tenants()->sync($tenantIds);
            } else {
                $announcement->tenants()->sync([]);
            }

            DB::commit();

            session()->flash(
                'success',
                __('dashboard.response_item_update')
            );
        } catch (Exception $e) {
            DB::rollBack();

            session()->flash(
                'error',
                __('dashboard.response_item_error_update')
            );
        }

        return redirect()->back();
    }

    public function destroy(Announcement $announcement)
    {
        Storage::delete(isset($announcement->path_image)??$announcement->path_image);
        Storage::delete(isset($announcement->path_image_mobile)??$announcement->path_image_mobile);
        Storage::delete(isset($announcement->path_image_vertical)??$announcement->path_image_vertical);
        $announcement->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }

    public function destroySelected(Request $request)
    {    
        foreach ($request->deleteAll as $announcementId) {
            $announcement = Announcement::find($announcementId);
    
            if ($announcement) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($announcement)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $announcementId,
                            'link' => $announcement->link,
                            'path_image' => $announcement->path_image,
                            'path_image_mobile' => $announcement->path_image_mobile,
                            'path_image_vertical' => $announcement->path_image_vertical,
                            'sorting' => $announcement->sorting,
                            'active' => $announcement->active,
                            'event' => 'multiple_deleted',
                        ]
                    ])
                    ->log('multiple_deleted');
            } else {
                \Log::warning("Item com ID $announcementId não encontrado.");
            }
        }
    
        $deleted = Announcement::whereIn('id', $request->deleteAll)->delete();
    
        if ($deleted) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' '.__('dashboard.response_item_delete')]);
        }
    
        return Response::json(['status' => 'error', 'message' => 'Nenhum item foi deletado.'], 500);
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id) {
            $announcement = Announcement::find($id);
    
            if ($announcement) {
                $announcement->sorting = $sorting;
                $announcement->save();
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }

            if($announcement) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($announcement)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'link' => $announcement->link,
                            'path_image' => $announcement->path_image,
                            'path_image_mobile' => $announcement->path_image_mobile,
                            'path_image_vertical' => $announcement->path_image_vertical,
                            'sorting' => $announcement->sorting,
                            'active' => $announcement->active,
                            'event' => 'order_updated',
                        ]
                    ])
                    ->log('order_updated');
            } else {
                \Log::warning("Item com ID $id não encontrado.");
            }
        }
    
        return Response::json(['status' => 'success']);
    }
}
