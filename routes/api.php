<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\ChapterController;

//Route::middleware('auth:sanctum')->group(function () {});
Route::prefix('v1/')->group(function () {
    Route::get('/stories', [StoryController::class, 'getStories']);
    Route::get('/stories/get', [StoryController::class, 'getStoryDetails']);
    Route::get('/chapters/get', [ChapterController::class, 'getChapter']);
    Route::get('/chapters/get/choices', [ChoiceController::class, 'getChoicesByChapter']);

});