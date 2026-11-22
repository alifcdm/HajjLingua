<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlacementController;
use App\Http\Controllers\LearnController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\AlphabetController;
use App\Http\Controllers\DrillController;

// Dashboard & Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Complete Alphabet & Master Syllabary Explorer (Zero to Hero)
Route::get('/alphabet/{langCode?}', [AlphabetController::class, 'index'])->name('alphabet.index');

// 100-Stage Memory Drill Arena (Penguat Ingatan - 15 Soal per Stage)
Route::get('/drills/{level_id}', [DrillController::class, 'index'])->name('drill.index');
Route::get('/drills/stage/{stage_id}', [DrillController::class, 'showStage'])->name('drill.stage');
Route::post('/drills/stage/{stage_id}/submit', [DrillController::class, 'submitStage'])->name('drill.submit');

// Placement Test
Route::get('/placement/{slug}', [PlacementController::class, 'show'])->name('placement.show');
Route::post('/placement/{slug}/submit', [PlacementController::class, 'submit'])->name('placement.submit');

// Learn & Curriculum Roadmap
Route::get('/learn/{slug}', [LearnController::class, 'index'])->name('learn.index');
Route::get('/lesson/{id}', [LearnController::class, 'showLesson'])->name('lesson.show');
Route::post('/lesson/{id}/complete', [LearnController::class, 'completeLesson'])->name('lesson.complete');

// Level Exams & Certification
Route::get('/exam/{level_id}', [ExamController::class, 'show'])->name('exam.show');
Route::post('/exam/{level_id}/submit', [ExamController::class, 'submit'])->name('exam.submit');

// Certificate View & Verification
Route::get('/certificate/{uuid}', [CertificateController::class, 'show'])->name('certificate.show');
Route::get('/verify/{uuid}', [CertificateController::class, 'verify'])->name('certificate.verify');
