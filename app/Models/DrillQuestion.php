<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DrillQuestion extends Model
{
    protected $fillable = [
        'drill_level_id',
        'question_text',
        'prompt_script',
        'audio_text',
        'options_json',
        'correct_answer',
        'explanation',
        'question_type',
        'sort_order'
    ];

    protected $casts = [
        'options_json' => 'array'
    ];

    public function drillLevel(): BelongsTo
    {
        return $this->belongsTo(DrillLevel::class);
    }
}
