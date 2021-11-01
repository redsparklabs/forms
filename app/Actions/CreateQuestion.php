<?php

namespace App\Actions;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;

class CreateQuestion
{
    use AsObject, WithAttributes;

    public function handle(User $user, Team $team, array $attributes)
    {
        Gate::forUser($user)->authorize('addQuestion', $team);

        $this->fill($attributes)->validateAttributes();

        $question = Arr::get($attributes, 'question');
        $description = Arr::get($attributes, 'description');

        $team->questions()->create(['question' => $question, 'description' => $description]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }

    public function getValidationErrorBag(): string
    {
        return 'addQuestion';
    }
}
