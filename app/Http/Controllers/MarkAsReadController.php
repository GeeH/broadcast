<?php

namespace App\Http\Controllers;

use App\Events\NewsWasUpdatedEvent;
use App\Models\News;
use Illuminate\Http\JsonResponse;

class MarkAsReadController extends Controller
{
    public function __invoke(int $id): JsonResponse
    {
        try {
            $newsRecord = News::findOrFail($id);
            $newsRecord->read = true;
            $newsRecord->save();

            // Leave this here as a reminder of the time that Gary was right and chat was wrong
            // News::where('id', $id)->updateOrFail(['read' => true]);

            NewsWasUpdatedEvent::broadcast();

            return new JsonResponse(['yay']);
        } catch (\Throwable $e) {
            return new JsonResponse($e->getMessage());
        }
    }
}
