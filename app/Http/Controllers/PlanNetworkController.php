<?php

namespace App\Http\Controllers;

use App\Models\PlanNetwork;
use App\Models\PlanNetworkCategory;
use App\Models\ServiceSection;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class PlanNetworkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // 'planNetwork' → é o módulo definido no template_modules.php.
        // 'plano.visualizar' → é a permissão definida no module_permissions.php.
        $check = checkPermission('planNetwork', 'plano.visualizar', $settingTheme);
        
        if ($check !== true) {
            return $check;
        }

        $categories = PlanNetworkCategory::with('plans')->active()->sorting()->get();
        $plans = PlanNetwork::sorting()->get();

        $serviceSection = ServiceSection::whereIn('section', ['planNetwork'])
        ->get()
        ->keyBy('section');

        $planNetworkCategory = [];

        $theme = $themeManager;
        $themeData = $themeManager->theme();
        $planLimit = $themeManager->getLimit('planNetwork', 0);

        foreach ($categories as $category) {
            $planNetworkCategory[$category->id] = $category->title;
        }
        
        return view('admin.blades.planNetwork.index', compact('serviceSection', 'theme', 'themeData', 'planLimit', 'plans', 'categories', 'planNetworkCategory'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // Formata o campo 'price'
        $valorFormatado = $request->price;
        $valorNumerico = str_replace(['R$', ' ', ' ', "\u{A0}"], '', $valorFormatado);
        $valorNumerico = str_replace(',', '.', $valorNumerico);
        $data['price'] = floatval($valorNumerico);
        $data['active'] = $request->active ? 1 : 0;
  
        try {
            DB::beginTransaction();
                PlanNetwork::create($data);
            DB::commit();
            session()->flash('success', __('dashboard.response_item_create'));
            } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', __('dashboard.response_item_error_create'));
        }
        return redirect()->back();
    }

    public function update(Request $request, PlanNetwork $planNetwork)
    {
        $data = $request->all();
        // Formata o campo 'price'
        $valorFormatado = $request->price;
        $valorNumerico = str_replace(['R$', ' ', ' ', "\u{A0}"], '', $valorFormatado);
        $valorNumerico = str_replace(',', '.', $valorNumerico);
        $data['price'] = floatval($valorNumerico);
        $data['active'] = $request->active ? 1 : 0;
        
        try {
            DB::beginTransaction();
                $planNetwork->fill($data)->save();
            DB::commit();
            session()->flash('success', __('dashboard.response_item_create'));
            } catch (\Exception $e) {
                DB::rollback();
                session()->flash('success', __('dashboard.response_item_error_create'));
        }

        return redirect()->back();
    }

    public function destroy(PlanNetwork $planNetwork)
    {
        $planNetwork->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }

        public function destroySelected(Request $request)
    {    
        foreach ($request->deleteAll as $planId) {
            $planNetwork = PlanNetwork::find($planId);
    
            if ($planNetwork) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($planNetwork)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $planId,
                            'title' => $planNetwork->title,
                            'subtitle' => $planNetwork->subtitle,
                            'bandwidth_limit' => $planNetwork->bandwidth_limit,
                            'bandwidth_unit' => $planNetwork->bandwidth_unit,
                            'description' => $planNetwork->description,
                            'price' => $planNetwork->price,
                            'sorting' => $planNetwork->sorting,
                            'active' => $planNetwork->active,
                            'event' => 'multiple_deleted',
                        ]
                    ])
                    ->log('multiple_deleted');
            } else {
                \Log::warning("Item com ID $planId não encontrado.");
            }
        }
    
        $deleted = PlanNetwork::whereIn('id', $request->deleteAll)->delete();
    
        if ($deleted) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' '.__('dashboard.response_item_delete')]);
        }
    
        return Response::json(['status' => 'error', 'message' => 'Nenhum item foi deletado.'], 500);
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id) {
            $planNetwork = PlanNetwork::find($id);
    
            if ($planNetwork) {
                $planNetwork->sorting = $sorting;
                $planNetwork->save();
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }

            if($planNetwork) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($planNetwork)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'title' => $planNetwork->title,
                            'subtitle' => $planNetwork->subtitle,
                            'bandwidth_limit' => $planNetwork->bandwidth_limit,
                            'bandwidth_unit' => $planNetwork->bandwidth_unit,
                            'description' => $planNetwork->description,
                            'price' => $planNetwork->price,
                            'sorting' => $planNetwork->sorting,
                            'active' => $planNetwork->active,
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
