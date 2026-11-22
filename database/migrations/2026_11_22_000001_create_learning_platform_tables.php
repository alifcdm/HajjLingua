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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique(); // en, ja, ko, ar, id
            $table->string('name', 50);
            $table->string('native_name', 50);
            $table->string('script_type', 20)->default('latin'); // latin, kanji_kana, hangeul, arabic
            $table->enum('direction', ['ltr', 'rtl'])->default('ltr');
            $table->timestamps();
        });

        Schema::create('language_pairs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('base_language_id')->constrained('languages')->cascadeOnDelete();
            $table->foreignId('target_language_id')->constrained('languages')->cascadeOnDelete();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->constrained('languages')->cascadeOnDelete();
            $table->string('code', 20); // A1, N5, TOPIK 1, Mubtadi', etc.
            $table->string('name', 100);
            $table->string('stage_category', 50); // Mubtadi', Mutawassith, Mutaqaddim, Beginner, Intermediate, Advanced
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(1);
            $table->timestamps();
        });

        Schema::create('placement_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_pair_id')->constrained('language_pairs')->cascadeOnDelete();
            $table->string('title', 150);
            $table->text('description')->nullable();
            $table->integer('total_questions')->default(15);
            $table->timestamps();
        });

        Schema::create('placement_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('placement_test_id')->constrained('placement_tests')->cascadeOnDelete();
            $table->foreignId('target_level_id')->nullable()->constrained('levels')->nullOnDelete();
            $table->text('question_text');
            $table->text('prompt_script')->nullable(); // Aksara Arab/Kanji/Hangeul
            $table->text('audio_text')->nullable(); // Teks untuk Web Speech API
            $table->json('options_json'); // Opsi A, B, C, D
            $table->string('correct_answer', 100);
            $table->text('explanation')->nullable();
            $table->integer('sort_order')->default(1);
            $table->timestamps();
        });

        Schema::create('user_placement_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('language_pair_id')->constrained('language_pairs')->cascadeOnDelete();
            $table->integer('total_score');
            $table->foreignId('recommended_level_id')->nullable()->constrained('levels')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_id')->constrained('levels')->cascadeOnDelete();
            $table->string('title', 150);
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(1);
            $table->timestamps();
        });

        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('units')->cascadeOnDelete();
            $table->string('title', 150);
            $table->enum('content_type', ['alphabet', 'vocabulary', 'grammar', 'conversation', 'business', 'exam'])->default('vocabulary');
            $table->longText('content_body'); // JSON data materi: items, romaji, arti, contoh
            $table->text('audio_script')->nullable();
            $table->integer('sort_order')->default(1);
            $table->timestamps();
        });

        Schema::create('lesson_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('lessons')->cascadeOnDelete();
            $table->text('question_text');
            $table->text('prompt_script')->nullable();
            $table->json('options_json');
            $table->string('correct_answer', 100);
            $table->text('explanation')->nullable();
            $table->integer('sort_order')->default(1);
            $table->timestamps();
        });

        Schema::create('user_lesson_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('lesson_id')->constrained('lessons')->cascadeOnDelete();
            $table->boolean('is_completed')->default(false);
            $table->integer('score')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->char('uuid', 36)->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('recipient_name', 150);
            $table->foreignId('language_id')->constrained('languages')->cascadeOnDelete();
            $table->foreignId('level_id')->constrained('levels')->cascadeOnDelete();
            $table->decimal('final_score', 5, 2);
            $table->timestamp('issued_at');
            $table->string('verification_hash', 64);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('user_lesson_progress');
        Schema::dropIfExists('lesson_exercises');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('units');
        Schema::dropIfExists('user_placement_results');
        Schema::dropIfExists('placement_questions');
        Schema::dropIfExists('placement_tests');
        Schema::dropIfExists('levels');
        Schema::dropIfExists('language_pairs');
        Schema::dropIfExists('languages');
    }
};
