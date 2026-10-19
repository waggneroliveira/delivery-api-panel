<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Services\ActivityLogService;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlanNetwork extends Model
{
    use Notifiable, HasFactory, LogsActivity, BelongsToTenant;

    protected $fillable = [
        'plan_network_category',
        'title',
        'subtitle',
        'bandwidth_limit',
        'bandwidth_unit',
        'description',
        'price',
        'active',
        'sorting',
    ];

    public function category(){
        return $this->belongsTo(PlanNetworkCategory::class, 'plan_network_category');
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
