<?php

namespace App\Actions;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Team;
use App\Models\Form;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;

class DestroyForm
{
    use AsObject, WithAttributes;

    public function handle(User $user, Team $team, Form $form)
    {
        Gate::forUser($user)->authorize('removeForm', $team);

        $team->forms()->find($form)->first()->delete();
    }
}
