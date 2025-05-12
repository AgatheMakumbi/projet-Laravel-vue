<?php

use App\Http\Controllers\StoryCreationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('storyTemplate');
});

Route::get('/story/{id}', function ($id) {
    return view('storyTemplate', ['id' => $id]);
});

//Routes protegées par une authentification
Route::middleware('auth:sanctum')->group(function () {
Route::get('/create',[StoryCreationController::class,'getCreateStoryForm']);
Route::post('/create',[StoryCreationController::class,'validateStoryCreateForm']);
});
// Instead of using Sanctum (or something similar) for API authentication,
// we are using the built-in Laravel session authentication system.
require_once __DIR__ . '/api.php';