<?php

namespace App\Http\Livewire\Events;

use App\Actions\Events\CreateEvent;
use App\Models\Organization;
use App\Http\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;

class EventCreate extends BaseComponent
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
        'created' => '$refresh',
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

        return redirect()->to(route('events.index'));
    }

    /**
     * Confirm the update of a team
     */
    public function confirmUpdateAction()
    {
    }

    /**
     * Update a team
     *
     * @return void
     */
    public function updateAction()
    {
    }

    /**
     * Delete a team
     *
     * @return void
     */
    public function destroyAction()
    {
    }

    /**
     * Render the component
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('events.event-create');
    }
}
