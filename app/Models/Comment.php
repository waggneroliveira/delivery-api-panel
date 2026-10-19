<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Comment extends Model
{
    use Notifiable, HasFactory, BelongsToTenant;

    protected $fillable =[
        'comment',
        'active',
        'blog_id',
        'client_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function scopeActive($query){
        return $query->where('active', 1);
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
