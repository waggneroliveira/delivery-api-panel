<?php

namespace App\Models;

use App\Services\ActivityLogService;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SessaoFaq extends Model
{
    use Notifiable, HasFactory, LogsActivity, BelongsToTenant;
    
    protected $fillable = [
        'title',
        'subtitle',
        'btn_title',
        'btn_number',
        'description',
        'path_file',
        'active',
        'tag',
        'title_box',
        'description_box',
        'link',
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
