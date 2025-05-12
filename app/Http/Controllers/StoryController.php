<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StoryController extends Controller
{
    /**
     * Récupère toutes les histoires (id, titre, description).
     *
     * @return JsonResponse
     */
    public function getStories()
    {
         $stories = story::all();
        //Récupérer le chapitre is_start parmi les chapitres associés à chaque livre 
        foreach ($stories as $story) {
            $story->chapters = $story->chapters()->where('is_start', true)->first();
        }
        return response()->json(

            $stories
        );
    }

    /**
     * Récupère une histoire et ses chapitres associés.
     *
     * @return JsonResponse
     */
    public function getStoryDetails($id)
    {
        if (!$id) {
            return response()->json(['error' => 'Missing story ID'], 400);
        }

        $story = Story::with('chapters')->findOrFail($id);
        return response()->json($story);
    }
}
