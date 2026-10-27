<?php

namespace App\Models;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AdSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_theme_id',
        'name',
        'slug',
        'exhibition',
        'active',
        'sorting',
    ];

    protected $casts = [
        'active' => 'boolean',
        'sorting' => 'integer',
    ];

    public function templateTheme(): BelongsTo
    {
        return $this->belongsTo(TemplateTheme::class);
    }

    public function announcements(): BelongsToMany
    {
        return $this->belongsToMany(
            Announcement::class,
            'announcement_ad_slots'
        );
    }

    public function tenants()
    {
        return $this->belongsToMany(
            Tenant::class,
            'tenant_ad_slot'
        );
    }
}