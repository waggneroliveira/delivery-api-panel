<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogSubcategory extends Model
{
    protected $fillable = [
        'blog_category_id',
        'name',
        'slug',
        'description',
        'active',
        'order',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function blogs(){
        return $this->hasMany(Blog::class, 'blog_category_id');
    }

    public function scopeActive($query){
        return $query->where('active', 1);
    }
}