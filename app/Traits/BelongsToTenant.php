<?php

namespace App\Traits;

use App\Models\Scopes\TenantScope;
use Spatie\Multitenancy\Models\Tenant;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant()
    {
        static::addGlobalScope(new TenantScope);
        
        static::creating(function ($model) {
            $tenant = Tenant::current();
            
            if ($tenant) {
                $model->tenant_id = $tenant->id;
            }
        });
    }
}