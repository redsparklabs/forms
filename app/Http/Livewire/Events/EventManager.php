<?php

namespace App\Http\Livewire\Events;

use App\Actions\Events\CreateEvent;
use App\Actions\Events\UpdateEvent;
use App\Actions\Events\DestroyEvent;
use App\Models\Organization;
use App\Http\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;

class EventManager extends BaseComponent
{

    /**
     * The organization instance.
     *
     * @var \App\Models\Organization
     */
    public $organization;

    /**
     * The user instance.
     *
     * @var \App\Models\User|null
     */
    public $user;

    /**
     * The component's listeners.
     *
     * @var array
     */
    protected $listeners = [
        'updated' => '$refresh',
        'created' => '$refresh',
        'destroyed' => '$refresh',
    ];

    /**
     * @var string
     */
    public $componentName = 'Event';

    /**
     * @var array
     */
    public $createForm = [
        'name' => '',
        'teams' => [],
        'forms' => [],
    ];

    /**
     * @var array
     */
    public $updateForm = [
        'name' => '',
        'teams' => [],
        'forms' => [],
    ];

    /**
     * Mount the component
     *
     * @param  Organization $organization
     *
     * @return void
     */
    public function mount(Organization $organization)
    {
        $this->user = Auth::user();
        $this->organization = $organization;
    }

    /**
     * Create a new team
     *
     * @return void
     */
    public function createAction()
    {
        CreateEvent::run(
            $this->user,
            $this->organization,
            $this->createForm
        );

        // $this->reset('createForm');

        $this->emit('refresh-navigation-menu');
    }

    /**
     * Confirm the update of a team
     */
    public function confirmUpdateAction()
    {
        $event = $this->organization->events()->find($this->idBeingUpdated);

        $this->updateForm = [
            'name' => $event->name,
            'teams' => array_fill_keys($event->teams->pluck('id')->toArray(), true),
            'forms' => array_fill_keys($event->forms->pluck('id')->toArray(), true),
        ];
    }

    /**
     * Update a team
     *
     * @return void
     */
    public function updateAction()
    {
        $organization  = $this->organization->events()->find($this->idBeingUpdated);

        UpdateEvent::run(
            $this->user,
            $this->organization,
            $organization,
            $this->updateForm
        );

        $this->reset('updateForm');

        $this->emit('refresh-navigation-menu');
    }

    /**
     * Delete a team
     *
     * @return void
     */
    public function destroyAction()
    {
        $organization  = $this->organization->events()->find($this->idBeingDestroyed);

        DestroyEvent::run(
            $this->user,
            $this->organization,
            $organization
        );

        $this->emit('refresh-navigation-menu');
    }

    /**
     * Render the component
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('events.event-manager');
    }
}
