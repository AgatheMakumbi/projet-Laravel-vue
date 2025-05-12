<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChapterController extends Controller
{
   /**
     * Récupère un chapitre avec ses choix associés.
     *
     * @return JsonResponse
     */
    public function getChapter($id): JsonResponse
{
    

    if (!$id) {
        return response()->json(['error' => 'Missing chapter ID'], 400);
    }

    $chapter = Chapter::with('choices')->findOrFail($id);
    return response()->json($chapter);
}
}
