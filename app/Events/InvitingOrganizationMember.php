<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class InvitingOrganizationMember
{
    use Dispatchable;

    /**
     * Create a new event instance.
     *
     * @param  mixed  $organization
     * @param  mixed  $email
     * @param  mixed  $role
     * @return void
     */
    public function __construct(public $organization, public $email, public $role)
    {
        $this->organization = $organization;
        $this->email = $email;
        $this->role = $role;
    }
}
