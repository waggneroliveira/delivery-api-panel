<?php

namespace Tests\Unit;

use App\Models\Tenant;
use App\Models\User;
use App\Support\TenantResolver;
use Tests\TestCase;

class TenantResolverTest extends TestCase
{
    public function test_it_resolves_the_tenant_from_authenticated_user_when_no_current_tenant_exists(): void
    {
        $tenant = new Tenant(['id' => 7, 'name' => 'Tenant A']);
        $user = new User(['tenant_id' => 7]);

        $resolver = new TenantResolver();

        $this->app->instance(TenantResolver::class, $resolver);

        $resolvedTenant = $resolver->resolveFromUser($user, $tenant);

        $this->assertSame($tenant, $resolvedTenant);
    }
}
