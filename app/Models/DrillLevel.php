<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DrillLevel extends Model
{
    protected $fillable = ['level_id', 'stage_number', 'title', 'description', 'passing_score'];

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(DrillQuestion::class)->orderBy('sort_order');
    }

    public function progresses(): HasMany
    {
        return $this->hasMany(UserDrillProgress::class);
    }
}
