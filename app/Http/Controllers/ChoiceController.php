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
    public function getChoicesByChapter(int $chapterId): JsonResponse
    {
        $chapter = Chapter::findOrFail($chapterId);

        return response()->json(
            $chapter->choices()->select('id', 'label', 'target_chapter_id')->get()
        );
    }
}