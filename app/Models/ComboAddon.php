<?php

namespace App\Models;

use App\Models\Tenant;
use App\Services\ActivityLogService;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ComboAddon extends Model
{
    use Notifiable, HasFactory, LogsActivity, BelongsToTenant;
    
    protected $fillable = [
        'product_id',
        'name',
        'price',
        'max_quantity',
        'active',
        'sorting',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'max_quantity' => 'integer',
            'active' => 'boolean',
            'sorting' => 'integer',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function getActivitylogOptions(): LogOptions
    {
        $activityLogService = new ActivityLogService($this);
        
        return LogOptions::defaults()
            ->logOnly($activityLogService->getLoggableAttributes());
    }
}