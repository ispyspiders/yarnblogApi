<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user/posts', []) // Route för att hämta en användares inlägg

// Protected routes
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum'); // Logga ut användare
Route::resource('/posts', PostController::class)->middleware('auth:sanctum'); // Routing för inlägg

// Public routes
Route::get('/posts', [PostController::class, 'index']);  // Routing för att läsa in alla inlägg
Route::get('/posts/{id}', [PostController::class, 'show']); // Routing för att läsa in inlägg med valt id
Route::post('/register', [AuthController::class, 'register']); // Route för att registrera användare
Route::post('/login', [AuthController::class, 'login']); // Route för att logga in användare