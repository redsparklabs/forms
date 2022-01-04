<?php

namespace App\Actions;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Organization;
use App\Models\Question;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;

class DestroyQuestion
{
    use AsObject, WithAttributes;

    /**
     * @param  User         $user
     * @param  Organization $organization
     * @param  Question     $question
     * @return void
     */
    public function handle(User $user, Organization $organization, Question $question)
    {
        Gate::forUser($user)->authorize('removeQuestion', $organization);

        $organization->questions()->find($question)?->first()?->delete();
    }
}
