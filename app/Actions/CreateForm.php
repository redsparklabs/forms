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

    public function handle(User $user, Organization $organization, array $attributes)
    {
        Gate::forUser($user)->authorize('addForm', $organization);

        $this->fill($attributes)->validateAttributes();

        $name = Arr::get($attributes, 'name');
        $description = Arr::get($attributes, 'description');
        $events = Arr::get($attributes, 'events');
        $teams = Arr::get($attributes, 'teams');

        $form = $organization->forms()->create([
            'name' => $name,
            'description' => $description
        ]);

        if($teams) {
            $form->teams()->sync(array_filter($teams));
        }

        if($events) {
            $form->attachTags(array_filter(explode(',', $events)));
        }

        return $form;
    }

    public function rules(): array
    {
        return [
            'teams' => ['required'],
            'name' => ['required', 'string', 'min:4'],
        ];
    }

    public function getValidationErrorBag(): string
    {
        return 'addForm';
    }
}
