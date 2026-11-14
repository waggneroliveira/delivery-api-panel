<?php

namespace Tests\Feature;

use App\Http\Controllers\ContactController;
use App\Models\Contact;
use App\Models\Tenant;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ContactOpeningHoursTest extends TestCase
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

        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id');
            $table->string('name_section')->nullable();
            $table->string('name_section_social_media')->nullable();
            $table->string('mention')->nullable();
            $table->string('text')->nullable();
            $table->string('name_two')->nullable();
            $table->string('name_three')->nullable();
            $table->string('name_one')->nullable();
            $table->string('address_one')->nullable();
            $table->string('address_two')->nullable();
            $table->string('address_three')->nullable();
            $table->string('opening_hours_one')->nullable();
            $table->string('opening_hours_two')->nullable();
            $table->string('opening_hours_three')->nullable();
            $table->string('phone_one')->nullable();
            $table->string('phone_two')->nullable();
            $table->string('phone_three')->nullable();
            $table->string('whatsapp')->nullable();
            $table->text('maps')->nullable();
            $table->string('link_insta')->nullable();
            $table->string('link_x')->nullable();
            $table->string('link_youtube')->nullable();
            $table->string('link_face')->nullable();
            $table->string('link_tik_tok')->nullable();
            $table->json('opening_hours')->nullable();
            $table->timestamps();
        });
    }

    public function test_it_saves_and_updates_all_weekday_hours_in_one_contact_record(): void
    {
        $tenant = Tenant::create([
            'name' => 'Delivery',
            'slug' => 'delivery',
            'domain' => 'localhost',
            'active' => true,
        ]);
        $tenant->makeCurrent();

        $storeRequest = Request::create('/contacts', 'POST', [
            'name_one' => 'contato@example.com',
            'opening_hours' => $this->openingHours(),
        ]);

        app(ContactController::class)->store($storeRequest);

        $this->assertSame(1, Contact::count());
        $contact = Contact::firstOrFail();
        $this->assertCount(7, $contact->opening_hours);
        $this->assertSame(1, $contact->opening_hours[0]['day_of_week']);
        $this->assertSame('09:00', $contact->opening_hours[0]['open_time']);
        $this->assertTrue($contact->opening_hours[6]['is_closed']);
        $this->assertNull($contact->opening_hours[6]['open_time']);

        $updatedOpeningHours = $this->openingHours();
        $updatedOpeningHours[2]['open_time'] = '10:30';
        $updatedOpeningHours[2]['close_time'] = '18:30';

        $updateRequest = Request::create('/contacts/' . $contact->id, 'PUT', [
            'name_one' => 'novo-contato@example.com',
            'opening_hours' => $updatedOpeningHours,
        ]);

        app(ContactController::class)->update($updateRequest, $contact);

        $this->assertSame(1, Contact::count());
        $contact->refresh();
        $this->assertSame('novo-contato@example.com', $contact->name_one);
        $this->assertSame('10:30', $contact->opening_hours[1]['open_time']);
        $this->assertSame('18:30', $contact->opening_hours[1]['close_time']);
    }

    public function test_contacts_api_returns_individual_hours_for_the_current_tenant(): void
    {
        $tenant = Tenant::create([
            'name' => 'Delivery',
            'slug' => 'delivery',
            'domain' => 'localhost',
            'active' => true,
        ]);
        $otherTenant = Tenant::create([
            'name' => 'Other Delivery',
            'slug' => 'other-delivery',
            'domain' => 'other.localhost',
            'active' => true,
        ]);
        $tenant->makeCurrent();

        DB::table('contacts')->insert([
            [
                'tenant_id' => $tenant->id,
                'name_one' => 'contato@example.com',
                'maps' => null,
                'opening_hours' => json_encode([
                    ['day_of_week' => 1, 'open_time' => '09:00', 'close_time' => '17:00', 'is_closed' => false],
                    ['day_of_week' => 2, 'open_time' => '10:00', 'close_time' => '18:00', 'is_closed' => false],
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => $otherTenant->id,
                'name_one' => 'outro@example.com',
                'maps' => null,
                'opening_hours' => json_encode([
                    ['day_of_week' => 1, 'open_time' => '08:00', 'close_time' => '16:00', 'is_closed' => false],
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->getJson('/api/contacts')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.opening_hours.0.day_of_week', 1)
            ->assertJsonPath('data.0.opening_hours.0.open_time', '09:00')
            ->assertJsonPath('data.0.opening_hours.1.day_of_week', 2)
            ->assertJsonPath('data.0.opening_hours.1.close_time', '18:00');
    }

    public function test_json_migration_consolidates_contact_rows_and_can_restore_them(): void
    {
        $tenant = Tenant::create([
            'name' => 'Migration tenant',
            'slug' => 'migration-tenant',
            'domain' => 'migration.localhost',
            'active' => true,
        ]);

        Schema::drop('contacts');
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->string('name_one')->nullable();
            $table->text('maps')->nullable();
            $table->unsignedTinyInteger('day_of_week');
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->boolean('is_closed')->default(false);
            $table->timestamps();
        });

        DB::table('contacts')->insert([
            [
                'tenant_id' => $tenant->id,
                'name_one' => 'contato@example.com',
                'day_of_week' => 1,
                'open_time' => '09:00',
                'close_time' => '17:00',
                'is_closed' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tenant_id' => $tenant->id,
                'name_one' => 'contato@example.com',
                'day_of_week' => 2,
                'open_time' => '10:00',
                'close_time' => '18:00',
                'is_closed' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $migration = require base_path('database/migrations/2026_11_14_124900_store_contact_opening_hours_as_json.php');
        $migration->up();

        $this->assertSame(1, DB::table('contacts')->count());
        $this->assertFalse(Schema::hasColumn('contacts', 'day_of_week'));
        $openingHours = json_decode(DB::table('contacts')->value('opening_hours'), true);
        $this->assertSame('09:00', $openingHours[0]['open_time']);
        $this->assertSame('10:00', $openingHours[1]['open_time']);
        $this->assertTrue($openingHours[2]['is_closed']);

        $migration->down();

        $this->assertSame(7, DB::table('contacts')->count());
        $this->assertDatabaseHas('contacts', [
            'tenant_id' => $tenant->id,
            'day_of_week' => 2,
            'open_time' => '10:00',
            'close_time' => '18:00',
        ]);
    }

    private function openingHours(): array
    {
        $openingHours = [];

        foreach (range(1, 7) as $dayOfWeek) {
            $openingHours[$dayOfWeek] = [
                'day_of_week' => $dayOfWeek,
                'open_time' => $dayOfWeek === 7 ? null : '09:00',
                'close_time' => $dayOfWeek === 7 ? null : '17:00',
                'is_closed' => $dayOfWeek === 7 ? '1' : '0',
            ];
        }

        return $openingHours;
    }
}
