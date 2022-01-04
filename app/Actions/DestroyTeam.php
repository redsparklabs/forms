<?php

namespace App\Actions;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Team;
use App\Models\Organization;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;

class DestroyTeam
{
    use AsObject, WithAttributes;

    public function handle(User $user, Organization $organization, Team $team)
    {
        Gate::forUser($user)->authorize('removeTeam', $organization);

        $organization->teams()->find($team)->first()->delete();
    }
}
