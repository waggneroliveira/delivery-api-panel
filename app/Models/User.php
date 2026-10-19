<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\CustomResetPasswordNotification;
use App\Services\ActivityLogService;
use App\Traits\BelongsToTenant;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements CanResetPassword
{
    use Notifiable, HasFactory, HasRoles, LogsActivity, BelongsToTenant;
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'path_image',
        'sorting'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static $recordEvents = ['created', 'deleted']; //OBS: Com isso eu evito que, ao deslogar, o activity log registre o evento de update quando eu deslogar
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function scopeActive($query){
        return $query->where('active', 1);
    }

    public function scopeSorting($query){
        return $query->orderby('sorting', 'ASC');
    }

    public function getActivitylogOptions(): LogOptions
    {
        $activityLogService = new ActivityLogService($this);
        
        return LogOptions::defaults()
            ->logOnly($activityLogService->getLoggableAttributes());
    }

    public function scopeExcludeSuper(Builder $query): Builder
    {
        return $query->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Super');
        });
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }
}
