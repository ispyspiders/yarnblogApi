<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::resource('posts', PostController::class); // Routing för inlägg
Route::post('/register', [AuthController::class, 'register']); // Route för att registrera användare
Route::post('/login', [AuthController::class, 'login']); // Route för att logga in användare

// Route::get('/user/posts', []) // Route för att hämta en användares inlägg

// Protected routes
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum'); // Logga ut användare
