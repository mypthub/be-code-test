<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrgnisationCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var object
     */
    public $user;

    /**
     * @var object
     */
    public $organisation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user,$organisation)
    {
        $this->user = $user;
        $this->organisation = $organisation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
