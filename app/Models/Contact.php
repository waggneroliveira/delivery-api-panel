<?php

namespace App\Models;

use App\Services\ActivityLogService;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Contact extends Model
{
    use Notifiable, HasFactory, LogsActivity, BelongsToTenant;

    protected $fillable = [
        'mention',
        'name_section_social_media',
        'name_section',
        'whatsapp',
        'text',
        'name_one',
        'name_two',
        'name_three',
        'address_one',
        'address_two',
        'address_three',
        'opening_hours_one',
        'opening_hours_two',
        'opening_hours_three',
        'phone_one',
        'phone_two',
        'phone_three',
        'maps',
        'link_insta',
        'link_x',
        'link_youtube',
        'link_face',
        'link_tik_tok',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        $activityLogService = new ActivityLogService($this);
        
        return LogOptions::defaults()
            ->logOnly($activityLogService->getLoggableAttributes());
    }
}
