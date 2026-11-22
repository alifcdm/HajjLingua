<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('drill_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_id')->constrained('levels')->cascadeOnDelete();
            $table->integer('stage_number'); // 1 to 100
            $table->string('title', 150);
            $table->text('description')->nullable();
            $table->integer('passing_score')->default(80);
            $table->timestamps();

            $table->unique(['level_id', 'stage_number']);
        });

        Schema::create('drill_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('drill_level_id')->constrained('drill_levels')->cascadeOnDelete();
            $table->text('question_text');
            $table->text('prompt_script')->nullable(); // Aksara asli
            $table->text('audio_text')->nullable(); // TTS
            $table->json('options_json'); // 4 pilihan
            $table->string('correct_answer', 150);
            $table->text('explanation'); // Penjelasan detail kenapa benar/salah
            $table->string('question_type', 30)->default('multiple_choice'); // multiple_choice, vocab, grammar, listening
            $table->integer('sort_order')->default(1);
            $table->timestamps();
        });

        Schema::create('user_drill_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('drill_level_id')->constrained('drill_levels')->cascadeOnDelete();
            $table->boolean('is_completed')->default(false);
            $table->integer('score')->default(0);
            $table->integer('stars')->default(0); // 1, 2, or 3 stars
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_drill_progress');
        Schema::dropIfExists('drill_questions');
        Schema::dropIfExists('drill_levels');
    }
};
