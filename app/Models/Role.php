<?php

namespace App\Models;


use Spatie\Activitylog\LogOptions;
use App\Services\ActivityLogService;
use App\Models\Scopes\SuperAdminScope;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory, LogsActivity;
    protected static function booted(): void
    {
        static::addGlobalScope(new SuperAdminScope);
    }

    public function getActivitylogOptions(): LogOptions
    {
        $activityLogService = new ActivityLogService($this);
        
        return LogOptions::defaults()
            ->logOnly($activityLogService->getLoggableAttributes());
    }
}
