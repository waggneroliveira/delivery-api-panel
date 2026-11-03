<?php
namespace App\Repositories;

use App\Models\SettingTheme;
use Illuminate\Support\Facades\Auth;

class SettingThemeRepository
{
    public function settingTheme(){
        $currentUser = Auth::user();
        if ($currentUser) {
            $settingTheme = SettingTheme::where('user_id', $currentUser->id)->first();
        } else {
            $settingTheme = new SettingTheme();
        }

        return $settingTheme;
    }
}