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
     * @return JsonResponse
     */
    public function getStoryDetails(): JsonResponse
    {
        $id = request()->get('id');

        if (!$id) {
            return response()->json(['error' => 'Missing story ID'], 400);
        }

        $story = Story::with('chapters')->findOrFail($id);
        return response()->json($story);
    }
}
