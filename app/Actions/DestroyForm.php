<?php

namespace App\Actions;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Form;
use App\Models\Organization;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;

class DestroyForm
{
    use AsObject, WithAttributes;

    /**
     * @param  User $user
     * @param  Organization $organization
     * @param  Form $form
     * @return void
     */
    public function handle(User $user, Organization $organization, Form $form)
    {
        Gate::forUser($user)->authorize('removeForm', $organization);

        $organization->forms()->find($form)?->first()?->delete();
    }
}
