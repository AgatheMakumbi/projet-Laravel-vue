<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChapterRequest;
use App\Http\Requests\ChoicesRequest;
use App\Models\Story;
use Illuminate\Http\Request;
use App\Http\Requests\StoryRequest;

class StoryCreationController extends Controller
{
    public function getCreateStoryForm()
    {
        return view('create_story_form');
    }

    public function validateStoryCreateForm(StoryRequest $storyRequest, ChapterRequest $chapterRequest, ChoicesRequest $choicesRequest )
    {
        // Validate the story creation form
        return view('creation_confirmation');
    }
}
