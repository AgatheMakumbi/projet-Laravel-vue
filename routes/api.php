<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\ChapterController;

//Route::middleware('auth:sanctum')->group(function () {});
Route::prefix('v1/')->group(function () {
    Route::get('/stories', [StoryController::class, 'getStories']);
    Route::get('/stories/{id}', [StoryController::class, 'getStoryDetails']);

    Route::get('/chapters/{id}', [ChapterController::class, 'getChapter']);

    Route::get('/chapters/{id}/choices', [ChoiceController::class, 'getChoicesByChapter']);

});