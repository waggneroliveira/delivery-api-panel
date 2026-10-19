<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\TenantGoogleSearchConsole;
use App\Repositories\SettingThemeRepository;
use App\Services\ThemeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TenantGoogleSearchConsoleController extends Controller
{
    public function index(ThemeManager $themeManager)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        $tenantGoogle = TenantGoogleSearchConsole::with('tenant')->first();        
        $tenant = Tenant::current();
        $theme = $themeManager;
        $themeData = $themeManager->theme();
        
        return view('admin.blades.google.tenant-google.index', compact('tenant', 'tenantGoogle', 'theme', 'themeData', 'settingTheme'));
    }


    public function store(Request $request){
        $tenant = Tenant::current();
        $data = $request->all();
        $data['active'] = $request->active?1:0;
        $data['tenant_id'] = $tenant->id;
       
        try {

            DB::beginTransaction();

                TenantGoogleSearchConsole::create($data);

            DB::commit();

            session()->flash(
                'success',
                __('dashboard.response_item_create')
            );

        } catch (\Exception $e) {

            DB::rollBack();

            session()->flash(
                'error',
                __('dashboard.response_item_error_create')
            );
        }

        return redirect()->back();
    }

    public function update(Request $request, TenantGoogleSearchConsole $tenantGoogleSearchConsole){
        $data = $request->all();
        $data['active'] = $request->active?1:0;
       
        try {

            DB::beginTransaction();

                $tenantGoogleSearchConsole->fill($data)->save();

            DB::commit();

            session()->flash(
                'success',
                __('dashboard.response_item_update')
            );

        } catch (\Exception $e) {

            DB::rollBack();

            session()->flash(
                'error',
                __('dashboard.response_item_error_update')
            );
        }

        return redirect()->back();
    }

    public function destroy(TenantGoogleSearchConsole $tenantGoogleSearchConsole){
        $tenantGoogleSearchConsole->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }
}
