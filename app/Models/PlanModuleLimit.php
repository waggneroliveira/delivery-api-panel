<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanModuleLimit extends Model
{
    protected $fillable = [
        'plan_id',
        'module',
        'limit',
    ];

    protected $casts = [
        'limit' => 'integer',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(
            Plan::class
        );
    }
}