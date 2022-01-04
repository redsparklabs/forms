<?php

namespace App\Actions;

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

        $name = Arr::get($attributes, 'name');

        $team->name = $name;

        $team->save();
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }

    /**
     * @return string
     */
    public function getValidationErrorBag(): string
    {
        return 'updateTeam';
    }
}
