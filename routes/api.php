<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\QuestionController;
use App\Http\Controllers\Api\v1\QuizController;
use App\Http\Controllers\Api\v1\ResultController;
use App\Http\Controllers\Api\v1\SkillController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('skills')->group(function () {
            Route::get('/', [SkillController::class, 'index'])->name('index');
            Route::get('/questions', [SkillController::class, 'questions'])->name('questions');
        });
        Route::prefix('quizzes')->group(function () {
            Route::post('answer', [QuizController::class, 'answer'])->name('answer');
        });
        Route::prefix('results')->group(function () {
            Route::post('ranking', [ResultController::class, 'ranking'])->name('ranking');
        });

        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});


