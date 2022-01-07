<?php

namespace App\Actions\Events;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;

class CreateEvent
{
    use AsObject, WithAttributes;

    /**
     * @param  User         $user
     * @param  Organization $organization
     * @param  array        $attributes
     * @return void
     */
    public function handle(User $user, Organization $organization, array $attributes)
    {
        Gate::forUser($user)->authorize('addEvent', $organization);

        $this->fill($attributes)->validateAttributes();

        $name = Arr::get($attributes, 'name');
        $teams = Arr::get($attributes, 'teams');
        $forms = Arr::get($attributes, 'forms');

        $event = $organization->events()->create(['name' => $name]);
        $event->teams()->sync($teams);
        $event->forms()->sync($forms);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }

    /**
     * @return string
     */
    public function getValidationErrorBag(): string
    {
        return 'addEvent';
    }
}
