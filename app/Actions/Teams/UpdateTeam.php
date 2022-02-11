<?php

namespace App\Actions\Teams;

use Illuminate\Support\Facades\Gate;
use App\Models\Organization;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;


class UpdateTeam
{
    use AsObject, WithAttributes;

    /**
     * @param  User         $user
     * @param  Organization $organization
     * @param  Team         $team
     * @param  array        $attributes
     * @return void
     */
    public function handle(User $user, Organization $organization, Team $team,  array $attributes)
    {
        Gate::forUser($user)->authorize('updateTeam', $organization);

        $this->fill($attributes)->validateAttributes();

        tap($team)->update([
            'name' => Arr::get($attributes, 'name'),
            'priority_level' => Arr::get($attributes, 'priority_level'),
            'start_date' => Arr::get($attributes, 'start_date'),
            'description' =>  Arr::get($attributes, 'description'),
            'minimum_success_criteria' =>  Arr::get($attributes, 'minimum_success_criteria'),
            'estimated_launch_date' =>  Arr::get($attributes, 'estimated_launch_date'),
            'sponsor' =>  Arr::get($attributes, 'sponsor'),
        ]);
    }
}
