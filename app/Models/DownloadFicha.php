<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class DownloadFicha extends Model
{
    use Notifiable, HasFactory, BelongsToTenant;
    
    protected $fillable = [
        'name',
        'cnpj',
        'phone'
    ];
}
