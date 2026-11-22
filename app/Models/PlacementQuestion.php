<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlacementQuestion extends Model
{
    protected $fillable = [
        'placement_test_id',
        'target_level_id',
        'question_text',
        'prompt_script',
        'audio_text',
        'options_json',
        'correct_answer',
        'explanation',
        'sort_order'
    ];

    protected $casts = [
        'options_json' => 'array'
    ];

    public function placementTest(): BelongsTo
    {
        return $this->belongsTo(PlacementTest::class);
    }

    public function targetLevel(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'target_level_id');
    }
}
