<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('register', [UserController::class, 'register'])->name('register');
Route::middleware('auth:api')->get('getMessages', [MessageController::class, 'index'])->name('getMessages');
Route::middleware('auth:api')->post('send', [MessageController::class, 'store'])->name('send');
