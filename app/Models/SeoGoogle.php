<?php

namespace App\Models;


use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class SeoGoogle extends Model
{
    use Notifiable, HasFactory, BelongsToTenant;

    protected $table = 'seo_googles';

    protected $fillable = [
        'tenant_id',

        'title',
        'description',
        'keywords',

        'social_image',
        'favicon',

        'organization_name',
        'legal_name',
        'organization_url',
        'organization_logo',
        'organization_description',
        'founding_date',

        'email',
        'telephone',

        'street_address',
        'address_locality',
        'address_region',
        'postal_code',
        'address_country',

        'contact_type',
        'area_served',
        'available_languages',

        'opening_hours',

        'slogan',
        'organization_keywords',

        'search_console',
        'google_tag_manager',
        'google_ads',
        'meta_pixel',
    ];

    protected $casts = [
        'founding_date' => 'date',
        'available_languages' => 'array',
        'opening_hours' => 'array',
    ];

}