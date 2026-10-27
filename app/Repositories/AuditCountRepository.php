<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class AuditCountRepository
{
    protected function baseAuditQuery()
    {
        $today = today();

        return Activity::with('causer')
        ->whereHas('causer.roles', function ($query) {
            $query->where('name', '!=', 'Super');
        })
        ->whereDate('created_at', '=', $today)
        ->where('is_read', 0)
        ->orderBy('created_at', 'DESC');
    }

    public function allAudit()
    {
        $query = $this->baseAuditQuery();
        return $query ? $query->get() : collect();
    }

    public function auditCount()
    {
        $query = $this->baseAuditQuery();
        return $query ? $query->count() : 0;
    }

}