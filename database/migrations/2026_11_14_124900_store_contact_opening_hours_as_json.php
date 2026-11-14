<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->json('opening_hours')->nullable();
        });

        DB::table('contacts')
            ->orderBy('tenant_id')
            ->orderBy('id')
            ->get()
            ->groupBy('tenant_id')
            ->each(function ($contacts) {
                $openingHours = [];

                foreach (range(1, 7) as $dayOfWeek) {
                    $openingHours[$dayOfWeek] = [
                        'day_of_week' => $dayOfWeek,
                        'open_time' => null,
                        'close_time' => null,
                        'is_closed' => true,
                    ];
                }

                foreach ($contacts as $contact) {
                    $dayOfWeek = (int) $contact->day_of_week;

                    if ($dayOfWeek < 1 || $dayOfWeek > 7) {
                        continue;
                    }

                    $openingHours[$dayOfWeek] = [
                        'day_of_week' => $dayOfWeek,
                        'open_time' => $contact->open_time
                            ? substr((string) $contact->open_time, 0, 5)
                            : null,
                        'close_time' => $contact->close_time
                            ? substr((string) $contact->close_time, 0, 5)
                            : null,
                        'is_closed' => (bool) $contact->is_closed,
                    ];
                }

                $primaryContact = $contacts->first();

                DB::table('contacts')
                    ->where('id', $primaryContact->id)
                    ->update([
                        'opening_hours' => json_encode(array_values($openingHours), JSON_THROW_ON_ERROR),
                    ]);

                DB::table('contacts')
                    ->whereIn('id', $contacts->skip(1)->pluck('id'))
                    ->delete();
            });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn([
                'day_of_week',
                'open_time',
                'close_time',
                'is_closed',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->unsignedTinyInteger('day_of_week')->default(1);
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->boolean('is_closed')->default(false);
        });

        DB::table('contacts')
            ->orderBy('tenant_id')
            ->orderBy('id')
            ->get()
            ->each(function ($contact) {
                $openingHours = json_decode($contact->opening_hours ?? '[]', true);
                if (!is_array($openingHours) || $openingHours === []) {
                    return;
                }

                usort(
                    $openingHours,
                    fn (array $first, array $second) => $first['day_of_week'] <=> $second['day_of_week']
                );

                foreach ($openingHours as $index => $openingHour) {
                    $schedule = [
                        'day_of_week' => $openingHour['day_of_week'],
                        'open_time' => $openingHour['open_time'],
                        'close_time' => $openingHour['close_time'],
                        'is_closed' => $openingHour['is_closed'],
                    ];

                    if ($index === 0) {
                        DB::table('contacts')
                            ->where('id', $contact->id)
                            ->update($schedule);

                        continue;
                    }

                    $copy = (array) $contact;
                    unset($copy['id']);
                    DB::table('contacts')->insert(array_merge($copy, $schedule));
                }
            });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('opening_hours');
        });
    }
};
