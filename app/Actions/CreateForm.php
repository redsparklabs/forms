<?php

namespace App\Actions;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;

class CreateForm
{
    use AsObject, WithAttributes;

    public function handle(User $user, Team $team, array $attributes)
    {
        Gate::forUser($user)->authorize('addForm', $team);

        $this->fill($attributes)->validateAttributes();

        $name = Arr::get($attributes, 'name');
        $description = Arr::get($attributes, 'description');
        $events = Arr::get($attributes, 'events');
        $clubs = Arr::get($attributes, 'clubs');

        $form = $team->forms()->create([
            'name' => $name,
            'description' => $description
        ]);

        if($clubs) {
            $form->clubs()->sync(array_filter($clubs));
        }

        if($events) {
            $form->attachTags(array_filter(explode(',', $events)));
        }

        return $form;
    }

    public function rules(): array
    {
        return [
            'clubs' => ['required'],
            'name' => ['required', 'string', 'min:4'],
        ];
    }

    public function getValidationErrorBag(): string
    {
        return 'addForm';
    }
}
