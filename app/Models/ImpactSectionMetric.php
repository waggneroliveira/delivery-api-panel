<?php

namespace App\Models;

use App\Models\ImpactSection;
use App\Services\ActivityLogService;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ImpactSectionMetric extends Model
{
    use Notifiable, HasFactory, LogsActivity, BelongsToTenant;

    protected $fillable = [
        'impact_section_id',
        'title',
        'value',
        'active',
        'sorting',
    ];

    protected $casts = [
        'value' => 'decimal:2',
    ];

    public function impactSection(): BelongsTo
    {
        return $this->belongsTo(ImpactSection::class);
    }

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
