<?php

use Illuminate\Support\Facades\Route;

// API Routes go here!
Route::get('/posts', [\App\Http\Controllers\Api\PostController::class, 'index']);

