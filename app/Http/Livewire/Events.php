<?php

namespace App\Http\Livewire;

use App\Actions\Events\CreateEvent;
use App\Actions\Events\UpdateEvent;
use App\Actions\Events\DestroyEvent;
use App\Models\Organization;
use App\Http\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;

class Events extends BaseComponent
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
     * @var string
     */
    public $sortByField = 'name';

    /**
     * @var null
     */
    public $keyword = null;

    /**
     * @var string
     */
    public $sortDirection = 'asc';

    /**
     * @var string
     */
    public $componentName = 'Event';

    /**
     * The component's listeners.
     *
     * @var array
     */
    protected $listeners = [
        'refresh' => 'render',
        'updated' => 'render',
        'created' => 'render',
        'destroyed' => 'render',
    ];

    /**
     * @var array
     */
    public $createForm = [
        'name' => '',
        'date' => '',
        'teams' => [],
        'forms' => '',
    ];

    /**
     * @var array
     */
    public $updateForm = [
        'name' => '',
        'date' => '',
        'teams' => [],
        'forms' => '',
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
        $this->organization = $this->user->currentOrganization;

        if(request()->has('create')) {
            $this->confirmingCreating = true;
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        $this->sortByField = $field;

        $this->sortDirection = ($this->sortDirection == 'desc') ? 'asc': 'desc';

        $this->emit('refresh');
    }
    /**
     * Create a new team
     *
     * @return void
     */
    public function createAction()
    {
        $this->validate([
            'createForm.name' => 'required',
            'createForm.teams' => 'required',
            'createForm.date' => ['required', 'date'],
            'createForm.forms' => 'required'
        ],[
            'createForm.name.required' => 'Please enter a name.',
            'createForm.teams.required' => 'Please choose a team.',
            'createForm.forms.required' => 'Please choose a form.',
            'createForm.date.required' => 'Please enter a proper date.',
        ]);

        CreateEvent::run(
            $this->user,
            $this->organization,
            $this->createForm
        );

        $this->confirmingCreating = false;
    }

    /**
     * Confirm the update of a team
     */
    public function confirmUpdateAction()
    {
        $event = $this->organization->events()->find($this->idBeingUpdated);
        $this->updateForm = [
            'name' => $event?->name,
            'date' => $event?->date->format('Y-m-d'),
            'teams' => $event->teams->pluck('id')->mapWithkeys(fn($item) => [$item => $item]),
            'forms' => $event->forms->first()->id
        ];
    }

    /**
     * Update a team
     *
     * @return void
     */
    public function updateAction()
    {
        $this->updateForm['teams'] = array_filter($this->updateForm['teams']);

        $this->validate([
            'updateForm.name' => 'required',
            'updateForm.teams' => 'required',
            'updateForm.date' => ['required', 'date'],
            'updateForm.forms' => 'required'
        ],[
            'updateForm.name.required' => 'Please enter a name.',
            'updateForm.teams.required' => 'Please choose a team.',
            'updateForm.forms.required' => 'Please choose a form.',
            'updateForm.date.required' => 'Please enter a proper date.',
        ]);

        $organization  = $this->organization->events()->find($this->idBeingUpdated);

        UpdateEvent::run(
            $this->user,
            $this->organization,
            $organization,
            $this->updateForm
        );
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
    }

    /**
     * Render the component
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $events = $this->organization
            ->events()
            ->search($this->keyword)
            ->orderBy($this->sortByField, $this->sortDirection)
            ->paginate(25);

        return view('events.index', compact('events'));
    }
}
