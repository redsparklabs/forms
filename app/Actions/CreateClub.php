<?php

namespace App\Actions;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;

class CreateClub
{
    use AsObject, WithAttributes;

    public function handle(User $user, Team $team, array $attributes)
    {
        Gate::forUser($user)->authorize('addClub', $team);

        $this->fill($attributes)->validateAttributes();

        $name = Arr::get($attributes, 'name');

        $team->clubs()->create(['name' => $name]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }

    public function getValidationErrorBag(): string
    {
        return 'addClub';
    }
}
