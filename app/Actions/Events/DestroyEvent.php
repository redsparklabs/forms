<?php

namespace App\Actions\Events;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Event;
use App\Models\Organization;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;

class DestroyEvent
{
    use AsObject, WithAttributes;

    /**
     * @param  User         $user
     * @param  Organization $organization
     * @param  Event         $event
     * @return void
     */
    public function handle(User $user, Organization $organization, Event $event)
    {
        Gate::forUser($user)->authorize('removeEvent', $organization);

        $event->forms()->detach();
        $event->teams()->detach();

        $event->delete();
    }
}
