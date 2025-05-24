<?php

namespace Modules\Order\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DriverOrder implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $activity;

    public function __construct($activity)
    {
        $this->activity = $activity;
    }

    public function broadcastOn()
    {
        return ['driver-daweny-channel'];
    }

    public function broadcastAs()
    {
        return 'driver-log';
    }
}
