<?php

namespace App\Modules\Admin\Business;

use App\Models\TenantModuleLimit;
use Spatie\Multitenancy\Models\Tenant;

class ContentLimitService
{
    public function getLimit(
        string $module,
        string $templateSlug,
        ?int $default = null
    ): ?int {
        $tenant = Tenant::current();

        if ($tenant) {
            $customLimit = TenantModuleLimit::query()
                ->where('tenant_id', $tenant->id)
                ->where('module', $module)
                ->value('limit');

            if ($customLimit !== null) {
                return (int) $customLimit;
            }
        }

        return config(
            "template_modules.{$templateSlug}.limits.{$module}",
            $default
        );
    }
}