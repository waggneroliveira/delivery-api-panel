<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingThemeSeeder extends Seeder
{
    public function run(): void
    {   
        DB::table('setting_themes')->insert([
            'user_id' => User::first()->id,
            'data_bs_theme' => 'light',
            'data_layout_width' => 'default',
            'data_layout_mode' => 'detached',
            'data_topbar_color' => 'dark',
            'data_menu_color' => 'dark',
            'data_two_column_color' => 'dark',
            'data_menu_icon' => 'default',
            'data_sidenav_size' => 'default',
            'created_at' => now()
        ]);
    }
}
