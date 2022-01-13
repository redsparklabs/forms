<?php

namespace App\Actions;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Events\AddingOrganization;
use App\Models\Organization;

class CreatesOrganizations
{
    /**
     * Validate and create a new team for the given user.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return mixed
     */
    public function create($user, array $input)
    {
        Gate::forUser($user)->authorize('create', Organization::class);

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
        ])->validateWithBag('createOrganization');

        AddingOrganization::dispatch($user);

        $user->switchOrganization($organization = $user->ownedOrganizations()->create([
            'name' => $input['name'],
            'personal_organization' => false,
        ]));


        return $organization;
    }
}
