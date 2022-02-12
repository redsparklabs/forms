<?php

namespace App\Actions;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;

class CreateForm
{
    use AsObject, WithAttributes;

    /**
     *
     * @param  User         $user
     * @param  Organization $organization
     * @param  array        $attributes
     * @return \App\Models\Form
     */
    public function handle(User $user, Organization $organization, array $attributes)
    {
        Gate::forUser($user)->authorize('addForm', $organization);

        $this->fill($attributes)->validateAttributes();

        $name = Arr::get($attributes, 'name');

        $description = Arr::get($attributes, 'description');

        $form = $organization->forms()->create([
            'name' => $name,
            'description' => $description
        ]);

        return $form;
    }
}
