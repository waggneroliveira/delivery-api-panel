<?php

namespace App\Models;

use App\Notifications\ClientResetPasswordNotification;
use App\Services\ActivityLogService;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Client extends Authenticatable
{
    use Notifiable, HasFactory, LogsActivity, BelongsToTenant;
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'path_image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static $recordEvents = ['created', 'deleted']; //OBS: Com isso eu evito que, ao deslogar, o activity log registre o evento de update quando eu deslogar

    public function scopeActive($query){
        return $query->where('active', 1);
    }

    public function getActivitylogOptions(): LogOptions
    {
        $activityLogService = new ActivityLogService($this);
        
        return LogOptions::defaults()
            ->logOnly($activityLogService->getLoggableAttributes());
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ClientResetPasswordNotification($token));
    }
}
