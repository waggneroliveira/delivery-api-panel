<?php

namespace App\Models;

use App\Models\Product;
use App\Services\ActivityLogService;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ProductCategory extends Model
{
    use Notifiable, HasFactory, LogsActivity, BelongsToTenant;
    
    protected $fillable = [
        'title',
        'slug',
        'active',
        'highlight',
        'path_image',
        'sorting',
    ];

    public function products(){
        return $this->hasMany(Product::class, 'product_category_id');
    }

    public function scopeActive($query){
        return $query->where('active', 1);
    }

    public function scopeHighlightOnly($query)
    {
        return $query->where('highlight', 1);
    }
    public function scopeSorting($query){
        return $query->orderby('sorting', 'ASC');
    }

    public function getActivitylogOptions(): LogOptions
    {
        $activityLogService = new ActivityLogService($this);
        
        return LogOptions::defaults()
            ->logOnly($activityLogService->getLoggableAttributes());
    }
}
