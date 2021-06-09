<?php

namespace App\Events;

use App\Organisation;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrganisationCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Organisation
     */
    protected $organisation;

    /**
     * @var User
     */
    protected $user;

    /**
     * OrganisationCreated constructor.
     * @param Organisation $organisation
     * @param User $user
     */
    public function __construct(Organisation $organisation, User $user)
    {
        $this->organisation = $organisation;
        $this->user = $user;
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

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Organisation
     */
    public function getOrganisation(): Organisation
    {
        return $this->organisation;
    }
}
