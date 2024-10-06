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
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::prefix('skills')->group(function () {
            Route::get('index', [SkillController::class, 'index'])->name('index');
        });
        Route::prefix('questions')->group(function () {
            Route::get('index', [QuestionController::class, 'index'])->name('index');
        });
        Route::prefix('quizzes')->group(function () {
            Route::post('answer', [QuizController::class, 'answer'])->name('answer');
        });
        Route::prefix('results')->group(function () {
            Route::post('ranking', [ResultController::class, 'ranking'])->name('ranking');
        });
    });
});


