<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price',
        'monthly_price',
        'description',
        'text',
        'active',
        'popular',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'active' => 'boolean',
        'popular' => 'boolean',
    ];

    public function scopeActive($query){
        return $query->where('active', 1);
    }
    
    public function moduleLimits(): HasMany
    {
        return $this->hasMany(
            PlanModuleLimit::class
        );
    }

    public function tenants(): HasMany
    {
        return $this->hasMany(
            Tenant::class
        );
    }
}