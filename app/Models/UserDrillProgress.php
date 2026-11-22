<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDrillProgress extends Model
{
    protected $fillable = ['user_id', 'drill_level_id', 'is_completed', 'score', 'stars', 'completed_at'];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function drillLevel(): BelongsTo
    {
        return $this->belongsTo(DrillLevel::class);
    }
}
