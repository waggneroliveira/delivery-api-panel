<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{

    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        // 'contact' → é o módulo definido no template_modules.php.
        // 'contato.visualizar' → é a permissão definida no module_permissions.php.
        $check = checkPermission('contact', 'contato.visualizar', $settingTheme);

        if ($check !== true) {
            return $check; // retorna view 403
        }
        $contact = Contact::first();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        return view('admin.blades.contact.index', compact('contact', 'theme', 'themeData'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $maps = $request->input('maps');

        // Se o usuário colar o iframe inteiro
        if (Str::contains($maps, '<iframe')) {
            preg_match('/src="([^"]+)"/', $maps, $matches);
            $maps = $matches[1] ?? null;
        }
        $data['maps'] = $maps;

        try {
            DB::beginTransaction();
                Contact::create($data);
            DB::commit();
            session()->flash('success', __('dashboard.response_item_create'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Erro', __('dashboard.response_item_error_create'));
            return redirect()->back();
        }
    }

    public function update(Request $request, Contact $contact)
    {
        $data = $request->all();
        $maps = $request->input('maps');

        // Se o usuário colar o iframe inteiro
        if (Str::contains($maps, '<iframe')) {
            preg_match('/src="([^"]+)"/', $maps, $matches);
            $maps = $matches[1] ?? null;
        }
        $data['maps'] = $maps;
        
        try {
            DB::beginTransaction();
                $contact->fill($data)->save();
            DB::commit();
            session()->flash('success', __('dashboard.response_item_create'));
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Erro', __('dashboard.response_item_error_create'));
            return redirect()->back();
        }
    }


    public function destroy(Contact $contact)
    {
        $contact->delete();
        session()->flash('success', __('dashboard.response_item_delete'));
        return redirect()->back();
    }
}
