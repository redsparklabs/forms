<?php

namespace App\Actions;

use App\Models\Organization;
use Illuminate\Support\Facades\Gate;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;
use Spatie\ValidationRules\Rules\Delimited;

class UpdateQuestion
{
    use AsObject, WithAttributes;

    public function handle(User $user, Organization $organization, Question $question, array $attributes)
    {

        Gate::forUser($user)->authorize('updateQuestion', $organization);

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
            'question' => ['required'],
            'description' => ['required'],
        ];
    }

    public function getValidationErrorBag(): string
    {
        return 'updateQuestion';
    }
}
