<?php

namespace App\Actions;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;

class CreateTeam
{
    use AsObject, WithAttributes;

    public function handle(User $user, Organization $organization, array $attributes)
    {
        Gate::forUser($user)->authorize('addTeam', $organization);

        $this->fill($attributes)->validateAttributes();

        $name = Arr::get($attributes, 'name');

        $organization->teams()->create(['name' => $name]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }

    public function getValidationErrorBag(): string
    {
        return 'addTeam';
    }
}
