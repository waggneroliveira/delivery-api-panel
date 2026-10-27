<?php

namespace App\Models;

use App\Services\ActivityLogService;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class PlanNetworkCategory extends Model
{
    use Notifiable, HasFactory, LogsActivity, BelongsToTenant;
    
    protected $fillable = [
        'title',
        'slug',
        'active',
        'sorting',
        'path_image',
    ];
    public function plans(){
        return $this->hasMany(PlanNetwork::class, 'plan_network_category');
    }
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'asc');
    }
    public function getActivitylogOptions(): LogOptions
    {
        $activityLogService = new ActivityLogService($this);
        
        return LogOptions::defaults()
            ->logOnly($activityLogService->getLoggableAttributes());
    }
}
