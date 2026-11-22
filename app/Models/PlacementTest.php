<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlacementTest extends Model
{
    protected $fillable = ['language_pair_id', 'title', 'description', 'total_questions'];

    public function languagePair(): BelongsTo
    {
        return $this->belongsTo(LanguagePair::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(PlacementQuestion::class)->orderBy('sort_order');
    }
}
