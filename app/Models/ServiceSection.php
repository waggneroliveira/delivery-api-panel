<?php

namespace App\Models;

use App\Services\ActivityLogService;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ServiceSection extends Model
{
    use Notifiable, HasFactory, LogsActivity, BelongsToTenant;
    
    protected $fillable = [
        'title',
        'subtitle',
        'tag',
        'section',
        'link',
        'description_first_image',
        'title_first_image',
        'btn_title',
        'path_image',
        'description',
        'active',
    ];

    public function scopeActive($query){
        return $query->where('active', 1);
    }

    public function getActivitylogOptions(): LogOptions
    {
        $activityLogService = new ActivityLogService($this);
        
        return LogOptions::defaults()
            ->logOnly($activityLogService->getLoggableAttributes());
    }
}
