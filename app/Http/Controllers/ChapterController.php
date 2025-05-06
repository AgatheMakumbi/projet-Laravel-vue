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
     * @param int $id
     * @return JsonResponse
     */
    public function getChapter(int $id): JsonResponse
    {
        $chapter = Chapter::with('choices')->findOrFail($id);

        //response()->setStatusCode()//gerer les erreurs ici -> voir HTTP response
        return response()->json($chapter);
    }
}
