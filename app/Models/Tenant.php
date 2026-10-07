<?php

namespace App\Models;

use App\Models\AdSlot;
use App\Models\TenantGoogleSearchConsole;
use App\Models\TenantModuleLimit;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Multitenancy\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant
{
    protected $fillable = [
        'name',
        'slug',
        'domain',
        'database',
        'template_theme_id',
        'plan_id',

        // Cores
        'primary_color',
        'secondary_color',
        'accent_color',
        'text_color',

        // Logos
        'path_image_logo_header',
        'path_image_logo_footer',

        // Botão 1
        'text_button_one',
        'color_button_one',
        'bg_button_one',

        // Botão 2
        'text_button_two',
        'color_button_two',
        'bg_button_two',

        // Header
        'text_color_header',
        'bg_header',
        'bg_scroll',
        'btn_title_header',
        'link_header',

        // Rodapé
        'privacy_policy',
        'terms_of_use',
        'btn_title',
        'description',
        'link',
        'bg_footer',
        'text_color_footer',
        'cnpj',
        'copyright',
        'active',
    ];

    public function templateTheme()
    {
        return $this->belongsTo(TemplateTheme::class);
    }

    public function moduleLimits(): HasMany
    {
        return $this->hasMany(TenantModuleLimit::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function announcements()
    {
        return $this->belongsToMany(Announcement::class, 'announcement_tenants');
    }
    
    public function googleSearchConsole(): HasOne
    {
        return $this->hasOne(TenantGoogleSearchConsole::class);
    }

    public function adSlots()
    {
        return $this->belongsToMany(
            AdSlot::class,
            'tenant_ad_slot'
        );
    }
}