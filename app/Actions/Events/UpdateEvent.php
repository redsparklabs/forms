<?php

namespace App\Actions\Events;

use Illuminate\Support\Facades\Gate;
use App\Models\Organization;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;


class UpdateEvent
{
    use AsObject, WithAttributes;

    /**
     * @param  User         $user
     * @param  Organization $organization
     * @param  Event         $event
     * @param  array        $attributes
     * @return void
     */
    public function handle(User $user, Organization $organization, Event $event,  array $attributes)
    {
        Gate::forUser($user)->authorize('updateEvent', $organization);

        $this->fill($attributes)->validateAttributes();

        $name = Arr::get($attributes, 'name');

        $event->name = $name;

        $event->save();
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
        return 'updateEvent';
    }
}
