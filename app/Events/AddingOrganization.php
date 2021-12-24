<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class AddingOrganization
{
    use Dispatchable;

    /**
     * Create a new event instance.
     *
     * @param  mixed  $owner
     * @return void
     */
    public function __construct(public $owner)
    {
        $this->owner = $owner;
    }
}
