<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\AdSlot;
use App\Models\Announcement;
use App\Models\AuditActivity;
use App\Models\Slide;
use App\Models\Tenant;
use App\Models\TemplateTheme;
use App\Repositories\AuditCountRepository;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
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
            $table->unsignedBigInteger('template_theme_id')->nullable();
            $table->string('primary_color')->nullable();
            $table->string('secondary_color')->nullable();
            $table->string('text_color')->nullable();
            $table->string('bg_header')->nullable();
            $table->string('path_image_logo_header')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('template_themes', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->string('layout_type')->nullable();
            $table->string('template_variation')->nullable();
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

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->nullable();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('guard_name');
        });

        Schema::create('model_has_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
        });

        Schema::create('activity_log', function (Blueprint $table) {
            $table->id();
            $table->string('log_name')->nullable();
            $table->text('description');
            $table->nullableMorphs('subject');
            $table->nullableMorphs('causer');
            $table->json('properties')->nullable();
            $table->string('event')->nullable();
            $table->uuid('batch_uuid')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id');
            $table->string('path_image')->nullable();
            $table->boolean('active')->default(false);
            $table->integer('sorting')->default(0);
            $table->timestamps();
        });

        Schema::create('ad_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('template_theme_id');
            $table->string('name');
            $table->string('slug');
            $table->string('exhibition');
            $table->boolean('active')->default(true);
            $table->unsignedInteger('sorting')->default(0);
            $table->timestamps();
        });

        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->text('link')->nullable();
            $table->string('path_image')->nullable();
            $table->string('path_image_mobile')->nullable();
            $table->string('path_image_vertical')->nullable();
            $table->boolean('active')->default(false);
            $table->integer('sorting')->default(0);
            $table->string('target')->default('all');
            $table->string('display_location')->default('web');
            $table->string('type')->default('general');
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->text('text')->nullable();
            $table->timestamps();
        });

        Schema::create('announcement_ad_slots', function (Blueprint $table) {
            $table->unsignedBigInteger('announcement_id');
            $table->unsignedBigInteger('ad_slot_id');
            $table->timestamps();
        });

        Schema::create('announcement_tenants', function (Blueprint $table) {
            $table->unsignedBigInteger('announcement_id');
            $table->unsignedBigInteger('tenant_id');
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

    public function test_client_api_updates_are_audited_with_the_authenticated_client_as_causer(): void
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

        activity()->enableLogging();

        try {
            $this->withToken($client->createToken('delivery')->plainTextToken)
                ->patchJson('/api/client/me', ['name' => 'Ana Silva'])
                ->assertOk();

            $activity = AuditActivity::query()
                ->where('subject_type', Client::class)
                ->where('subject_id', $client->id)
                ->firstOrFail();

            $this->assertSame(Client::class, $activity->causer_type);
            $this->assertSame($client->id, $activity->causer_id);
            $this->assertSame('Ana Silva', $activity->causer->name);
            $this->assertSame(1, (new AuditCountRepository())->auditCount());
            $this->assertCount(1, (new AuditCountRepository())->allAudit());
        } finally {
            activity()->disableLogging();
        }
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

    public function test_appearance_api_returns_tenant_branding_with_a_short_public_cache(): void
    {
        $tenant = Tenant::create([
            'name' => 'Delivery',
            'slug' => 'delivery',
            'domain' => 'localhost',
            'primary_color' => '#123456',
            'secondary_color' => null,
            'text_color' => '#222222',
            'bg_header' => '#fef3e5',
            'path_image_logo_header' => 'uploads/logo.avif',
            'active' => true,
        ]);
        $tenant->makeCurrent();

        $this->getJson('/api/appearance')
            ->assertOk()
            ->assertHeader('Cache-Control', 'max-age=60, public')
            ->assertJsonPath('name', 'Delivery')
            ->assertJsonPath('logo', Storage::disk('public')->url('uploads/logo.avif'))
            ->assertJsonPath('colors.primary', '#123456')
            ->assertJsonPath('colors.secondary', '#24211f')
            ->assertJsonPath('colors.background', '#fef3e5')
            ->assertJsonPath('colors.text', '#222222');
    }

    public function test_slides_api_returns_only_the_image_of_the_first_active_slide(): void
    {
        $tenant = Tenant::create([
            'name' => 'Delivery',
            'slug' => 'delivery',
            'domain' => 'localhost',
            'active' => true,
        ]);
        $tenant->makeCurrent();

        Slide::create([
            'path_image' => 'slides/inactive.avif',
            'active' => false,
            'sorting' => 0,
        ]);
        Slide::create([
            'path_image' => 'slides/second.avif',
            'active' => true,
            'sorting' => 2,
        ]);
        Slide::create([
            'path_image' => 'slides/first.avif',
            'active' => true,
            'sorting' => 1,
        ]);

        $this->getJson('/api/slides')
            ->assertOk()
            ->assertExactJson([
                'data' => ['path_image' => 'slides/first.avif'],
            ]);
    }

    public function test_announcements_api_returns_public_announcements_by_ad_slot(): void
    {
        $theme = TemplateTheme::create([
            'slug' => 'delivery',
            'name' => 'Delivery',
            'layout_type' => 'onepage',
            'template_variation' => 'tp-01',
        ]);
        $tenant = Tenant::create([
            'name' => 'Delivery',
            'slug' => 'delivery',
            'domain' => 'localhost',
            'template_theme_id' => $theme->id,
            'active' => true,
        ]);
        $tenant->makeCurrent();

        $adSlot = AdSlot::create([
            'template_theme_id' => $theme->id,
            'name' => 'Banner delivery',
            'slug' => 'banner-delivery',
            'exhibition' => 'horizontal',
            'active' => true,
            'sorting' => 1,
        ]);

        $eligible = Announcement::create([
            'link' => 'https://example.com/oferta',
            'path_image' => 'announcements/oferta.webp',
            'active' => true,
            'target' => 'all',
            'display_location' => 'web',
            'type' => 'general',
        ]);
        $eligible->adSlots()->attach($adSlot->id);

        $panelOnly = Announcement::create([
            'path_image' => 'announcements/panel.webp',
            'active' => true,
            'target' => 'all',
            'display_location' => 'panel',
            'type' => 'general',
        ]);
        $panelOnly->adSlots()->attach($adSlot->id);

        $this->getJson('/api/announcements')
            ->assertOk()
            ->assertJsonPath('data.banner-delivery.0.path_image', 'announcements/oferta.webp')
            ->assertJsonPath('data.banner-delivery.0.link', 'https://example.com/oferta')
            ->assertJsonMissing(['path_image' => 'announcements/panel.webp'])
            ->assertJsonMissingPath('data.banner-delivery.0.pivot');
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
