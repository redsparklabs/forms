<?php

namespace App\Actions;

use Illuminate\Support\Facades\Gate;
use App\Models\Club;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;


class UpdateClub
{
    use AsObject, WithAttributes;

    public function handle(User $user, Team $team, Club $club, array $attributes)
    {
        Gate::forUser($user)->authorize('updateClub', $team);

        $this->fill($attributes)->validateAttributes();

        $name = Arr::get($attributes, 'name');

        $club->name = $name;

        $club->save();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }

    public function getValidationErrorBag(): string
    {
        return 'updateClub';
    }
}
