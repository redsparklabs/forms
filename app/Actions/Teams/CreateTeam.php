<?php

namespace App\Actions\Teams;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;

class CreateTeam
{
    use AsObject, WithAttributes;

    /**
     * @param  User         $user
     * @param  Organization $organization
     * @param  array        $attributes
     * @return void
     */
    public function handle(User $user, Organization $organization, array $attributes)
    {
        Gate::forUser($user)->authorize('addTeam', $organization);

        $this->fill($attributes)->validateAttributes();

        $organization->teams()->create($attributes);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'start_date' => ['required','date'],
        ];
    }

    /**
     * @return string
     */
    public function getValidationErrorBag(): string
    {
        return 'addTeam';
    }
}
