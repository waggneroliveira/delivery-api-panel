<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class TenantModuleLimit extends Model
{
    use Notifiable, HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'module',
        'limit',
    ];

    protected $casts = [
        'limit' => 'integer',
    ];
}