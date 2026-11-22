<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LanguagePair extends Model
{
    protected $fillable = ['base_language_id', 'target_language_id', 'name', 'slug', 'is_active'];

    public function baseLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'base_language_id');
    }

    public function targetLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'target_language_id');
    }

    public function placementTest(): HasOne
    {
        return $this->hasOne(PlacementTest::class);
    }
}
