<?php

namespace App\Models;

use App\Models\ComboItem;
use App\Models\Tenant;
use App\Services\ActivityLogService;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Option extends Model
{
    use Notifiable, HasFactory, LogsActivity, BelongsToTenant;

    protected $fillable = [
        'product_id',
        'combo_item_id',
        'type',
        'title',
        'required',
        'max_selections',
        'choices',
        'active',
        'sorting',
    ];

    protected function casts(): array
    {
        return [
            'required' => 'boolean',
            'max_selections' => 'integer',
            'choices' => 'array',
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

    public function comboItem(): BelongsTo
    {
        return $this->belongsTo(ComboItem::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        $activityLogService = new ActivityLogService($this);
        
        return LogOptions::defaults()
            ->logOnly($activityLogService->getLoggableAttributes());
    }

}