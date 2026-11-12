<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Tenant;
use Illuminate\Database\Schema\Blueprint;
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

        $this->withToken($token)
            ->patchJson('/api/client/me', [
                'name' => 'Ana Silva',
                'phone' => '11988887777',
            ])
            ->assertOk()
            ->assertJsonPath('data.name', 'Ana Silva')
            ->assertJsonPath('data.phone', '11988887777');

        $this->withToken($token)
            ->deleteJson('/api/client/me')
            ->assertOk()
            ->assertJsonPath('message', 'Conta excluída com sucesso.');

        $this->assertDatabaseMissing('clients', ['email' => 'ana@example.com']);
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
        ])->assertUnauthorized();

        $this->get('/api/client/me')
            ->assertUnauthorized()
            ->assertHeader('content-type', 'application/json')
            ->assertJson(['message' => 'Não autenticado.']);
    }
}
