<?php

namespace App\Models;

use App\Services\ActivityLogService;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ProductGallery extends Model
{
    use Notifiable, HasFactory, LogsActivity, BelongsToTenant;

    protected $fillable = [
        'product_id',
        'file',
        'sorting',
        'active'
    ];

    public function scopeActive($query){
        return $query->where('active', 1);
    }
    public function scopeSorting($query){
        return $query->orderBy('sorting', 'ASC');
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        $activityLogService = new ActivityLogService($this);
        
        return LogOptions::defaults()
            ->logOnly($activityLogService->getLoggableAttributes());
    }
}
