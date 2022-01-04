<?php

namespace App\Actions;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;

class CreateQuestion
{
    use AsObject, WithAttributes;

    public function handle(User $user, Organization $organization, array $attributes)
    {
        Gate::forUser($user)->authorize('addQuestion', $organization);

        $this->fill($attributes)->validateAttributes();

        $question = Arr::get($attributes, 'question');
        $description = Arr::get($attributes, 'description');

        $organization->questions()->create(['question' => $question, 'description' => $description]);
    }

    public function rules(): array
    {
        return [
            'question' => ['required', 'string'],
            'description' => ['required', 'string'],
        ];
    }

    public function getValidationErrorBag(): string
    {
        return 'addQuestion';
    }
}
