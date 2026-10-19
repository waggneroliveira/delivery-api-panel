<?php

namespace App\Models;

use App\Models\BlogSubcategory;
use App\Services\ActivityLogService;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class BlogCategory extends Model
{
    use Notifiable, HasFactory, LogsActivity, BelongsToTenant;
    
    protected $fillable = [
        'title',
        'slug',
        'active',
        'path_image',
        'sorting',
        'color',
        'highlight',
        'show_in_header',
    ];

    public function blogs(){
        return $this->hasMany(Blog::class, 'blog_category_id');
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(BlogSubcategory::class, 'blog_category_id');
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
}
