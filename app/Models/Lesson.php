<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $fillable = [
        'unit_id',
        'title',
        'content_type',
        'content_body',
        'audio_script',
        'sort_order'
    ];

    protected $casts = [
        'content_body' => 'array'
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function exercises(): HasMany
    {
        return $this->hasMany(LessonExercise::class)->orderBy('sort_order');
    }

    public function progresses(): HasMany
    {
        return $this->hasMany(UserLessonProgress::class);
    }
}
