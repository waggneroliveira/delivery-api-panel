<?php

namespace App\Models;

use App\Services\ActivityLogService;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use Notifiable, HasFactory, LogsActivity, BelongsToTenant;
    
    protected $casts = [
        'sizes' => 'array',
        'tags' => 'array',
        'specifications' => 'array',
        'stock' => 'array',
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'cashback' => 'decimal:2',
        'featured' => 'boolean',
        'active' => 'boolean',
    ];
    
    protected $fillable = [
        'name',
        'function',
        'brand_id',
        'product_category_id',
        'title',
        'slug',
        'sizes',
        'description',
        'text',
        'path_image',
        'path_file',
        
        'link',
        'btn_title',
        'active',
        'sorting',
        'link_type',

        'price',
        'old_price',
        'cashback',
        'product_type',
        'cuisine_type',
        'tags',
        'specifications',
        'stock',
        'featured',
    ];

    public function category(){
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function galleries(){
        return $this->hasMany(ProductGallery::class);
    }
    public function comboItems(): HasMany
    {
        return $this->hasMany(ComboItem::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    public function comboAddons(): HasMany
    {
        return $this->hasMany(ComboAddon::class);
    }
    public function scopeActive($query){
        return $query->where('active', 1);
    }

    public function scopeSorting($query){
        return $query->orderby('sorting', 'asc');
    }

    public function getActivitylogOptions(): LogOptions
    {
        $activityLogService = new ActivityLogService($this);
        
        return LogOptions::defaults()
            ->logOnly($activityLogService->getLoggableAttributes());
    }
}
