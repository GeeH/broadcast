<?php

namespace App\Events;

use App\Models\News;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class NewsWasUpdatedEvent implements ShouldBroadcast
{
    use Dispatchable;

    public array $news;

    public function __construct()
    {
        $this->news = News::query()
            ->where('read', '=', false)
            ->get()
            ->toArray();
    }

    public function broadcastOn(): Channel
    {
        return new Channel('lyfee');
    }

}
