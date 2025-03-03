<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user/posts', []) // Route för att hämta en användares inlägg

// Protected routes
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum'); // Logga ut användare

// Route::resource('/posts', PostController::class)->middleware('auth:sanctum'); // Routing för inlägg
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
});

Route::post('/posts/{id}/comments', [CommentController::class, 'store'])->middleware('auth:sanctum'); // Routing för att lägga till kommentar på inlägg
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->middleware('auth:sanctum'); // Routing för att ta bort en kommentar med valt id


// Public routes
Route::get('/posts', [PostController::class, 'index']);  // Routing för att läsa in alla inlägg
Route::get('/posts/{id}', [PostController::class, 'show']); // Routing för att läsa in inlägg med valt id
Route::get('/users/{userId}/posts', [PostController::class, 'index']); // Routing för att läsa in alla inlägg från användare
Route::get('/posts/{id}/comments', [CommentController::class, 'index']); // Routing för att läsa in kommentarer för valt inlägg
Route::post('/register', [AuthController::class, 'register']); // Route för att registrera användare
Route::post('/login', [AuthController::class, 'login']); // Route för att logga in användare