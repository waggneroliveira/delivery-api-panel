<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class FaqController extends Controller
{

    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // 'slides' → é o módulo definido no template_modules.php.
        // 'slide.visualizar' → é a permissão definida no module_permissions.php.
        $check = checkPermission('faq', 'perguntas e respostas.visualizar', $settingTheme);

        if ($check !== true) {
            return $check; // retorna view 403
        }

        $faqs = Faq::sorting()->get();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        return view('admin.blades.faq.index', compact('faqs', 'theme', 'themeData'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;

        try {
            DB::beginTransaction();
                Faq::create($data);
            DB::commit();
            session()->flash('success', __('dashboard.response_item_create'));
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            Alert::error('error', __('dashboard.response_item_error_create'));
            return redirect()->back();
        }
    }

    public function update(Request $request, Faq $faq)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;

        try {
            DB::beginTransaction();
                $faq->fill($data)->save();
            DB::commit();
            session()->flash('success', __('dashboard.response_item_create'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('error', __('dashboard.response_item_error_create'));
            return redirect()->back();
        }
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }

    public function destroySelected(Request $request)
    {    
        foreach ($request->deleteAll as $faqId) {
            $faq = Faq::find($faqId);
    
            if ($faq) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($faq)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $faqId,
                            'question' => $faq->question,
                            'answer' => $faq->answer,
                            'sorting' => $faq->sorting,
                            'active' => $faq->active,
                            'event' => 'multiple_deleted',
                        ]
                    ])
                    ->log('multiple_deleted');
            } else {
                \Log::warning("Item com ID $faqId não encontrado.");
            }
        }
    
        $deleted = Faq::whereIn('id', $request->deleteAll)->delete();
    
        if ($deleted) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' '.__('dashboard.response_item_delete')]);
        }
    
        return Response::json(['status' => 'error', 'message' => 'Nenhum item foi deletado.'], 500);
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id) {
            $faq = Faq::find($id);
    
            if ($faq) {
                $faq->sorting = $sorting;
                $faq->save();
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }

            if($faq) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($faq)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'question' => $faq->question,
                            'answer' => $faq->answer,
                            'sorting' => $faq->sorting,
                            'active' => $faq->active,
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
