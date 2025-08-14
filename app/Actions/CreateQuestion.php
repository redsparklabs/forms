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

    /**
     * @param  User         $user
     * @param  Organization $organization
     * @param  array        $attributes
     *
     * @return void
     */
    public function handle(User $user, Organization $organization, array $attributes)
    {
        Gate::forUser($user)->authorize('addQuestion', $organization);

        $this->fill($attributes)->validateAttributes();

        $question = Arr::get($attributes, 'question');

        $description = Arr::get($attributes, 'description');

        $section = Arr::get($attributes, 'section', 'General');

        $organization->questions()->create([
            'question' => $question,
            'description' => $description,
            'section' => $section,
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'question' => ['required', 'string'],
            'description' => ['required', 'string'],
        ];
    }

    /**
     * @return string
     */
    public function getValidationErrorBag(): string
    {
        return 'addQuestion';
    }
}
