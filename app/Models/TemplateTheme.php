<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class TemplateTheme extends Model
{
    use Notifiable, HasFactory;
    
    protected $fillable = [
        'slug',
        'name',
        'preview',
        'layout_type',
        'active',
        'template_variation',
        'highlights',
        'technology',
        'title',
        'description',
    ];

    protected $casts = [
        'preview' => 'array',
        'active' => 'boolean',
    ];
    public function scopeActive($query){
        return $query->where('active', 1);
    }

    public function adSlots(): HasMany
    {
        return $this->hasMany(AdSlot::class);
    }
}
