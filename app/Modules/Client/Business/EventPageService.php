<?php

namespace App\Modules\Client\Business;

use App\Models\Contact;
use App\Models\Event;
use App\Models\Holidays;
use App\Models\Report;
use App\Models\Tenant;
use App\Services\ThemeManager;
use Illuminate\Http\Request;

class EventPageService
{
    public function getPageData(Request $request, ThemeManager $themeManager): array
    {
        $tenantTheme = Tenant::current();
        $theme = $themeManager;
        $themeData = $themeManager->theme();

        $report = Report::active()->first();
        $contact = Contact::first();
        $eventId = $request->query('event_id');

        $query = Event::active()->sorting();

        if ($eventId) {
            $query->where('id', $eventId);
        }

        $events = $query->get(['id', 'date', 'title', 'hours', 'description', 'link'])
            ->map(function ($event) {
                $date = $event->date;
                if (is_string($date)) {
                    $date = \Carbon\Carbon::parse($date);
                }

                return [
                    'id' => $event->id,
                    'date' => $date->format('Y-m-d'),
                    'title' => $event->title,
                    'hours' => $event->hours,
                    'description' => $event->description,
                    'link' => $event->link,
                ];
            });

        $holidays = Holidays::get()->map(function ($holiday) {
            $date = $holiday->date;
            if (is_string($date)) {
                $date = \Carbon\Carbon::parse($date);
            }

            return [
                'date' => $date->format('Y-m-d'),
                'name' => $holiday->name,
            ];
        });

        return compact('contact', 'report', 'events', 'holidays', 'eventId');
    }
}
