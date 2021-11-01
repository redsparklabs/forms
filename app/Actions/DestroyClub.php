<?php

namespace App\Actions;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Team;
use App\Models\Club;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;

class DestroyClub
{
    use AsObject, WithAttributes;

    public function handle(User $user, Team $team, Club $club)
    {
        Gate::forUser($user)->authorize('removeClub', $team);

        $team->clubs()->find($club)->first()->delete();
    }
}
