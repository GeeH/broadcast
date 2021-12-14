<?php

namespace App\Http\Controllers;

use App\Events\NewsWasUpdatedEvent;
use Illuminate\Http\JsonResponse;

class StateController extends Controller
{
    public function __invoke(): JsonResponse
    {
        NewsWasUpdatedEvent::broadcast();
        return new JsonResponse(['yay']);
    }
}
