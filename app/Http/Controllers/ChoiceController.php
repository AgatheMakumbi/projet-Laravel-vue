<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChoiceController extends Controller
{
    /**
     * Récupère tous les choix associés à un chapitre.
     *
     * @param int $chapterId
     * @return JsonResponse
     */
    public function getChoicesByChapter($chapterId): JsonResponse
    {
        $chapterId = request()->get('id');
    
        if (!$chapterId) {
            return response()->json(['error' => 'Missing chapter ID'], 400);
        }
    
        $chapter = Chapter::findOrFail($chapterId);
        return response()->json(
            $chapter->choices()->select('id', 'label', 'target_chapter_id')->get()
        );
    }
}