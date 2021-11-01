<?php

namespace App\Actions;

use Illuminate\Support\Facades\Gate;
use App\Models\Question;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;


class UpdateQuestion
{
    use AsObject, WithAttributes;

    public function handle(User $user, Team $team, Question $question, array $attributes)
    {
        Gate::forUser($user)->authorize('updateQuestion', $team);

        $this->fill($attributes)->validateAttributes();

        $newQuestion = Arr::get($attributes, 'question');
        $description = Arr::get($attributes, 'description');

        $question->question = $newQuestion;

        $question->description = $description;

        $question->save();
    }

    public function rules(): array
    {
        return [
            'newQuestion' => ['required'],
            'events' => [new Delimited('string')],
        ];
    }

    public function getValidationErrorBag(): string
    {
        return 'updateQuestion';
    }
}
