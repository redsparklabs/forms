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

        $event = $organization->events()->create([
            'name' => Arr::get($attributes, 'name'),
            'date' => Arr::get($attributes, 'date'),
            'department' => Arr::get($attributes, 'department')
        ]);

        $event->teams()->sync(Arr::get($attributes, 'teams'));
        $event->forms()->sync(Arr::get($attributes, 'forms'));
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'teams' => ['required'],
            'date' => ['required', 'date'],
            'forms' => ['required'],
            'department' => [],
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
