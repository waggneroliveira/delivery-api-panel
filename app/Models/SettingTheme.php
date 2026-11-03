<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingTheme extends Model
{
    protected $fillable = [
        'user_id',
        'data_bs_theme',
        'data_layout_width',
        'data_layout_mode',
        'data_topbar_color',
        'data_menu_color',
        'data_two_column_color',
        'data_menu_icon',
        'data_sidenav_size',
    ];
}
