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
        return response()->json(
            Story::select('id', 'title', 'description')->get()
        );
    }

     /**
     * Récupère une histoire et ses chapitres associés.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getStoryDetails($id)
    {
        $story = Story::with('chapters')->findOrFail($id);
        return response()->json($story);
    }
}
