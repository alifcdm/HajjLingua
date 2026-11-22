<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPlacementResult extends Model
{
    protected $fillable = ['user_id', 'language_pair_id', 'total_score', 'recommended_level_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function languagePair(): BelongsTo
    {
        return $this->belongsTo(LanguagePair::class);
    }

    public function recommendedLevel(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'recommended_level_id');
    }
}
