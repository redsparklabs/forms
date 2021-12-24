<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Organization;

class CreateOrganization extends OrganizationCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Organization $organization)
    {
        $organization->questions()->createMany(config('questions.qualitative-intuitive-scoring-feedback'));
    }
}
