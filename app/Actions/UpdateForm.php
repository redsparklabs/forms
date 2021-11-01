<?php

namespace App\Actions;

use Illuminate\Support\Facades\Gate;
use Spatie\ValidationRules\Rules\Delimited;
use App\Models\Form;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;


class UpdateForm
{
    use AsObject, WithAttributes;

    public function handle(User $user, Team $team, Form $form, array $attributes)
    {
        Gate::forUser($user)->authorize('updateForm', $team);

        $this->fill($attributes)->validateAttributes();

        $name = Arr::get($attributes, 'name');
        $events = Arr::get($attributes, 'events');
        $description = Arr::get($attributes, 'description');
        $clubs = Arr::get($attributes, 'clubs');

        $form->update([
            'name' => $name,
            'description' => $description
        ]);

        if($clubs) {
            $form->clubs()->sync(array_filter($clubs));
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
