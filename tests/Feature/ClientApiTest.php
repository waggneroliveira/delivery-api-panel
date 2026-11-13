<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Tenant;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ClientApiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);

        DB::purge('sqlite');

        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('domain')->unique();
            $table->string('primary_color')->nullable();
            $table->string('path_image_logo_header')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->string('name');
            $table->string('phone', 15);
            $table->string('email')->unique();
            $table->boolean('active')->default(false);
            $table->string('password');
            $table->string('path_image')->nullable();
            $table->timestamps();
        });

        $migration = require database_path('migrations/2026_11_12_114000_allow_delivery_client_self_registration.php');
        $migration->up();

        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->text('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable()->index();
            $table->timestamps();
        });

        activity()->disableLogging();
    }

    public function test_delivery_client_can_login_update_and_delete_their_account(): void
    {
        $tenant = Tenant::create([
            'name' => 'Delivery',
            'slug' => 'delivery',
            'domain' => 'localhost',
            'active' => true,
        ]);
        $tenant->makeCurrent();

        $client = Client::create([
            'tenant_id' => $tenant->id,
            'name' => 'Ana Cliente',
            'phone' => '11999999999',
            'email' => 'ana@example.com',
            'password' => Hash::make('not-used-by-delivery-api'),
            'active' => true,
        ]);

        $login = $this->postJson('/api/client/login', [
            'name' => 'Ana Cliente',
            'phone' => '11999999999',
        ])->assertOk()
            ->assertJsonPath('data.client.name', 'Ana Cliente');

        $login->assertJsonMissingPath('data.client.password');
        $token = $login->json('data.token');

        $otherClient = Client::create([
            'tenant_id' => $tenant->id,
            'name' => 'Outro Cliente',
            'phone' => '11777777777',
            'email' => 'outro@example.com',
            'password' => Hash::make('not-used-by-delivery-api'),
            'active' => true,
        ]);

        $this->withToken($otherClient->createToken('delivery')->plainTextToken)
            ->patchJson('/api/client/me', ['phone' => '11999999999'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['phone']);
        Auth::forgetGuards();

        $this->withToken($token)
            ->patchJson('/api/client/me', [
                'name' => 'Ana Silva',
                'phone' => '11988887777',
                'email' => 'ana.nova@example.com',
                'password' => 'new-password-123',
            ])
            ->assertOk()
            ->assertJsonPath('data.name', 'Ana Silva')
            ->assertJsonPath('data.phone', '11988887777')
            ->assertJsonPath('data.email', 'ana.nova@example.com');

        $this->assertDatabaseHas('clients', ['email' => 'ana.nova@example.com']);
        $this->assertTrue(Hash::check('new-password-123', $client->fresh()->password));

        $this->withToken($token)
            ->deleteJson('/api/client/me')
            ->assertOk()
            ->assertJsonPath('message', 'Conta excluída com sucesso.');

        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $client->id,
        ]);
    }

    public function test_delivery_api_rejects_invalid_login_and_unauthenticated_profile_requests(): void
    {
        $tenant = Tenant::create([
            'name' => 'Delivery',
            'slug' => 'delivery',
            'domain' => 'localhost',
            'active' => true,
        ]);
        $tenant->makeCurrent();

        Client::create([
            'tenant_id' => $tenant->id,
            'name' => 'Conta inativa',
            'phone' => '11911111111',
            'email' => 'inactive@example.com',
            'password' => Hash::make('not-used-by-delivery-api'),
            'active' => false,
        ]);

        $this->postJson('/api/client/login', ['name' => 'Ana Cliente'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['phone']);

        $this->postJson('/api/client/login', [
            'name' => 'Conta inativa',
            'phone' => '11911111111',
        ])->assertForbidden();

        $this->get('/api/client/me')
            ->assertUnauthorized()
            ->assertHeader('content-type', 'application/json')
            ->assertJson(['message' => 'Não autenticado.']);
    }

    public function test_tenant_api_returns_public_branding_and_theme_configuration(): void
    {
        $tenant = Tenant::create([
            'name' => 'Delivery',
            'slug' => 'delivery',
            'domain' => 'localhost',
            'primary_color' => '#123456',
            'path_image_logo_header' => 'uploads/logo.avif',
            'active' => true,
        ]);
        $tenant->makeCurrent();

        $this->getJson('/api/tenant')
            ->assertOk()
            ->assertJsonPath('data.tenant.name', 'Delivery')
            ->assertJsonPath('data.tenant.primary_color', '#123456')
            ->assertJsonPath('data.tenant.path_image_logo_header', 'uploads/logo.avif')
            ->assertJsonPath('data.theme', null)
            ->assertJsonMissingPath('data.tenant.database')
            ->assertJsonMissingPath('data.tenant.plan_id');
    }

    public function test_login_creates_new_account_and_rejects_a_phone_with_a_different_name(): void
    {
        $tenant = Tenant::create([
            'name' => 'Delivery',
            'slug' => 'delivery',
            'domain' => 'localhost',
            'active' => true,
        ]);
        $tenant->makeCurrent();

        $this->postJson('/api/client/login', [
            'name' => 'Ana Cliente',
            'phone' => '11999999999',
        ])->assertCreated()
            ->assertJsonPath('message', 'Conta criada e login realizado com sucesso.')
            ->assertJsonPath('data.client.email', null);

        $this->postJson('/api/client/login', [
            'name' => 'Ana Cliente',
            'phone' => '11999999999',
        ])->assertOk()
            ->assertJsonPath('message', 'Login realizado com sucesso.');

        $this->postJson('/api/client/login', [
            'name' => 'Outro Nome',
            'phone' => '11999999999',
        ])->assertStatus(409)
            ->assertJsonPath('message', 'O telefone informado já está associado a outro nome.');

        $this->assertDatabaseCount('clients', 1);
        $this->assertDatabaseHas('clients', [
            'name' => 'Ana Cliente',
            'phone' => '11999999999',
            'email' => null,
            'password' => null,
            'active' => true,
        ]);
    }
}
