<?php

namespace App\Actions;

use Illuminate\Support\Facades\Gate;
use App\Models\Organization;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;


class UpdateClub
{
    use AsObject, WithAttributes;

    public function handle(User $user, Organization $organization, Team $team,  array $attributes)
    {
        Gate::forUser($user)->authorize('updateTeam', $team);

        $this->fill($attributes)->validateAttributes();

        $name = Arr::get($attributes, 'name');

        $organization->name = $name;

        $organization->save();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }

    public function getValidationErrorBag(): string
    {
        return 'updateTeam';
    }
}
