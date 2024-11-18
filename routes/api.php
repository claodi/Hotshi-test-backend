<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\MessageController;
use App\Http\Controllers\api\ConversationController;



Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/signup', [AuthController::class, 'signup'])->name('api.signup');

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('message', MessageController::class)->except(['create', 'edit']);
});
