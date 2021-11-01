<?php

namespace App\Actions;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Team;
use App\Models\Question;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;

class DestroyQuestion
{
    use AsObject, WithAttributes;

    public function handle(User $user, Team $team, Question $question)
    {
        Gate::forUser($user)->authorize('removeQuestion', $team);

        $team->questions()->find($question)->first()->delete();
    }
}
