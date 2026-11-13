<?php
namespace App\Repositories;

use App\Models\AuditActivity;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class AuditCountRepository
{
    protected function baseAuditQuery()
    {
        $today = today();
        $userMorphType = (new User())->getMorphClass();

        return AuditActivity::with('causer')
            ->whereNotNull('causer_type')
            ->where(function (Builder $query) use ($userMorphType) {
                $query->where('causer_type', '!=', $userMorphType)
                    ->orWhere(function (Builder $query) use ($userMorphType) {
                        $query->where('causer_type', $userMorphType)
                            ->whereHasMorph(
                                'causer',
                                [User::class],
                                function (Builder $userQuery) {
                                    $userQuery->whereHas('roles', function (Builder $roleQuery) {
                                        $roleQuery->where('name', '!=', 'Super');
                                    });
                                }
                            );
                    });
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