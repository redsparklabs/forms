<?php

namespace App\Actions;

use Illuminate\Support\Facades\Gate;
use Spatie\ValidationRules\Rules\Delimited;
use App\Models\Form;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;


class UpdateForm
{
    use AsObject, WithAttributes;

    public function handle(User $user, Organization $organization, Form $form, array $attributes)
    {
        Gate::forUser($user)->authorize('updateForm', $organization);

        $this->fill($attributes)->validateAttributes();

        $name = Arr::get($attributes, 'name');
        $events = Arr::get($attributes, 'events');
        $description = Arr::get($attributes, 'description');
        $teams = Arr::get($attributes, 'teams');

        $form->update([
            'name' => $name,
            'description' => $description
        ]);

        if($teams) {
            $form->teams()->sync(array_filter($teams));
        }

        if($events) {
            $form->tags()->detach();
            $form->attachTags(array_filter(explode(',', $events)));
        }

        $form->save();
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'events' => [new Delimited('string')],
        ];
    }

    public function getValidationErrorBag(): string
    {
        return 'updateForm';
    }
}
