<?php

namespace App\Events;

use App\Models\Peeps;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class SomethingCoolHappened implements ShouldBroadcast
{

    use Dispatchable;

    public function broadcastOn(): Channel
    {
        return new Channel('Kobatawaka');
    }

    public function broadcastWith(): array
    {
        $peeps = Peeps::all()->pluck('name');

        return [
            'peeps_whos_spoked_today' => $peeps->toArray(),
        ];
    }
}
