<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonExercise extends Model
{
    protected $fillable = [
        'lesson_id',
        'question_text',
        'prompt_script',
        'options_json',
        'correct_answer',
        'explanation',
        'sort_order'
    ];

    protected $casts = [
        'options_json' => 'array'
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
