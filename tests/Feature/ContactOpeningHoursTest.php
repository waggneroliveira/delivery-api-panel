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
            $table->string('name_one')->nullable();
            $table->text('maps')->nullable();
            $table->unsignedTinyInteger('day_of_week');
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->boolean('is_closed')->default(false);
            $table->timestamps();
        });
    }

    public function test_it_saves_and_updates_one_contact_record_per_weekday(): void
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

        $this->assertSame(7, Contact::count());
        $this->assertDatabaseHas('contacts', [
            'tenant_id' => $tenant->id,
            'day_of_week' => 1,
            'open_time' => '09:00',
            'close_time' => '17:00',
            'is_closed' => false,
        ]);
        $this->assertDatabaseHas('contacts', [
            'tenant_id' => $tenant->id,
            'day_of_week' => 7,
            'open_time' => null,
            'close_time' => null,
            'is_closed' => true,
        ]);

        $updatedOpeningHours = $this->openingHours();
        $updatedOpeningHours[2]['open_time'] = '10:30';
        $updatedOpeningHours[2]['close_time'] = '18:30';
        $contact = Contact::query()->orderBy('day_of_week')->firstOrFail();

        $updateRequest = Request::create('/contacts/' . $contact->id, 'PUT', [
            'name_one' => 'novo-contato@example.com',
            'opening_hours' => $updatedOpeningHours,
        ]);

        app(ContactController::class)->update($updateRequest, $contact);

        $this->assertSame(7, Contact::count());
        $this->assertDatabaseHas('contacts', [
            'tenant_id' => $tenant->id,
            'name_one' => 'novo-contato@example.com',
            'day_of_week' => 2,
            'open_time' => '10:30',
            'close_time' => '18:30',
            'is_closed' => false,
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
