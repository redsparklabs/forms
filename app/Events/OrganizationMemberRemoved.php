<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class OrganizationMemberRemoved
{
    use Dispatchable;

    /**
     * Create a new event instance.
     *
     * @param  mixed  $organization
     * @param  mixed  $user
     * @return void
     */
    public function __construct(public $organization, public $user)
    {
        $this->organization = $organization;
        $this->user = $user;
    }
}
