<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Laravel\Jetstream\Events\TeamCreated;
use App\Models\Team;

class CreateTeam extends TeamCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $team;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Team $team)
    {
        $team->questions()->createMany(config('questions.qualitative-intuitive-scoring-feedback'));
    }

}
