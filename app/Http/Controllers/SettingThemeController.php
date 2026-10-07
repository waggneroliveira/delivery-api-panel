<?php

namespace App\Http\Controllers;

use App\Models\SettingTheme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingThemeController extends Controller
{
    
    public function setting(Request $request)
    {   
        $user = Auth::user();
        $settingTheme = SettingTheme::where('user_id', $user->id)->first();
        
        if (!$settingTheme) {
            $settingTheme = new SettingTheme();
            $settingTheme->user_id = $user->id; 
        }

        $settingTheme->data_bs_theme = $request->data_bs_theme;
        $settingTheme->data_layout_width = $request->data_layout_width;
        $settingTheme->data_layout_mode = $request->data_layout_mode;
        $settingTheme->data_topbar_color = $request->data_topbar_color;
        $settingTheme->data_menu_color = $request->data_menu_color;
        $settingTheme->data_two_column_color = $request->data_two_column_color;
        $settingTheme->data_menu_icon = $request->data_menu_icon;
        $settingTheme->data_sidenav_size = $request->data_sidenav_size;

        $settingTheme->save();

        return response()->json([
            'status' => true,
            'data_bs_theme' => $settingTheme->data_bs_theme,
            'data_layout_width' => $settingTheme->data_layout_width,
            'data_layout_mode' => $settingTheme->data_layout_mode,
            'data_topbar_color' => $settingTheme->data_topbar_color,
            'data_menu_color' => $settingTheme->data_menu_color,
            'data_two_column_color' => $settingTheme->data_two_column_color,
            'data_menu_icon' => $settingTheme->data_menu_icon,
            'data_sidenav_size' => $settingTheme->data_sidenav_size,
        ]);
    }
    
    public function settingUpdate(Request $request){
        $user = Auth::user();
        $settingTheme = SettingTheme::where('user_id', $user->id)->first();
        
        if (!$settingTheme) {
            $settingTheme = new SettingTheme();
            $settingTheme->user_id = $user->id; 
        }

        $settingTheme->data_bs_theme = $request->input('data-bs-theme');
        $settingTheme->data_layout_width = $request->input('data-layout-width');
        $settingTheme->data_layout_mode = $request->input('data-layout-mode');
        $settingTheme->data_topbar_color = $request->input('data-topbar-color');
        $settingTheme->data_menu_color = $request->input('data-menu-color');
        $settingTheme->data_two_column_color = $request->input('data-two-column-color');
        $settingTheme->data_menu_icon = $request->input('data-menu-icon');
        $settingTheme->data_sidenav_size = $request->input('data-sidenav-size');

        $settingTheme->save();

        return response()->json([
            'status' => true,
            'data_bs_theme' => $settingTheme->data_bs_theme,
            'data_layout_width' => $settingTheme->data_layout_width,
            'data_layout_mode' => $settingTheme->data_layout_mode,
            'data_topbar_color' => $settingTheme->data_topbar_color,
            'data_menu_color' => $settingTheme->data_menu_color,
            'data_two_column_color' => $settingTheme->data_two_column_color,
            'data_menu_icon' => $settingTheme->data_menu_icon,
            'data_sidenav_size' => $settingTheme->data_sidenav_size,
        ]);
    }
}
