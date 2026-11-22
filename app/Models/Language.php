<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    protected $fillable = ['code', 'name', 'native_name', 'script_type', 'direction'];

    public function levels(): HasMany
    {
        return $this->hasMany(Level::class)->orderBy('sort_order');
    }

    public function basePairs(): HasMany
    {
        return $this->hasMany(LanguagePair::class, 'base_language_id');
    }

    public function targetPairs(): HasMany
    {
        return $this->hasMany(LanguagePair::class, 'target_language_id');
    }
}
