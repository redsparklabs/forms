<?php

namespace App\Actions\Teams;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Team;
use App\Models\Organization;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;

class DestroyTeam
{
    use AsObject, WithAttributes;

    /**
     * @param  User         $user
     * @param  Organization $organization
     * @param  Team         $team
     * @return void
     */
    public function handle(User $user, Organization $organization, Team $team)
    {
        Gate::forUser($user)->authorize('removeTeam', $organization);

        $team->delete();
    }
}
