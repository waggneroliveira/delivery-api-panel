<?php

namespace App\Models;

use App\Services\ActivityLogService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Announcement extends Model
{
    use Notifiable, HasFactory, LogsActivity;
    
    protected $fillable = [
        'link',
        'path_image',
        'path_image_mobile',
        'path_image_vertical',
        'active',
        'sorting',
        'target',
        'text',
        'display_location',
        'type',
        'starts_at',
        'ends_at',
        'created_by'
    ];
    
    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'active' => 'boolean',
    ];
    public function scopeActive($query)
    {
        return $query->where('active', 1);
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

    public function tenants()
    {
        return $this->belongsToMany(
            Tenant::class,
            'announcement_tenants'
        );
    }
    public function adSlots(): BelongsToMany
    {
        return $this->belongsToMany(
            AdSlot::class,
            'announcement_ad_slots'
        );
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
