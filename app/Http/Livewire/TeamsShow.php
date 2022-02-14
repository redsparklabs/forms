<?php

namespace App\Http\Livewire;

use App\Models\Team;
use App\Actions\Teams\DestroyTeam;
use App\Models\Organization;
use Livewire\WithPagination;
use App\Actions\Teams\UpdateTeam;
use App\Http\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;

class TeamsShow extends BaseComponent
{
    use WithPagination;

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
        'refresh' => 'render',
        'created' => 'render',
        'updated' => 'render',
    ];

    /**
     * @var string
     */
    public $componentName = 'Project';

    /**
     * @var string
     */
    public $sortByField = 'date';

    /**
     * @var null
     */
    public $keyword = null;

    /**
     * @var string
     */
    public $sortDirection = 'desc';

    /**
     * @var array
     */
    public $updateForm = [
        'name' => '',
        'priority_level' => '',
        'start_date' => '',
        'description' => '',
        'minimum_success_criteria' => '',
        'estimated_launch_date' => '',
        'sponsor' => '',
    ];

    /**
     * @var array
     */
    protected $messages = [
        'updateForm.name.required' => 'Please add a name for this project.',
        'updateForm.description.required' => 'Please enter a description for this project.',
        'updateForm.start_date.required' => 'Please enter a start date for this project.',
        'updateForm.start_date.date' => 'Please enter a proper start date.',
    ];

    /**
     * @var array
     */
    protected $rules = [
        'updateForm.name' => ['required'],
        'updateForm.description' => ['required'],
        'updateForm.start_date' => ['required', 'date'],
    ];

    /**
     * Mount the component
     *
     * @param  Team $team
     *
     * @return void
     */
    public function mount(Team $team)
    {
        $this->team = $team;
        $this->user = Auth::user();
        $this->organization = $this->user->currentOrganization;
    }

    /**
     * Update the search keyword.
     *
     * @return void
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Sort the collection by the given field.
     *
     * @param  string $field
     *
     * @return void
     */
    public function sortBy(string $field)
    {
        $this->sortByField = $field;

        $this->sortDirection = ($this->sortDirection == 'desc') ? 'asc' : 'desc';

        $this->emit('reload_graph');
        $this->emit('refresh');
    }

    /**
     * Create a new team
     *
     * @return void
     */
    public function createAction()
    {
    }

    /**
     * Confirm the update of a team
     */
    public function confirmUpdateAction()
    {
        $team = $this->organization->teams->find($this->idBeingUpdated);

        $this->updateForm = [
            'name' => $team->name,
            'priority_level' => $team->priority_level,
            'start_date' => $team->start_date?->format('Y-m-d'),
            'description' => $team->description,
            'minimum_success_criteria' => $team->minimum_success_criteria,
            'estimated_launch_date' => $team->estimated_launch_date?->format('Y-m-d'),
            'sponsor' => $team->sponsor,
        ];
    }

    /**
     * Update a team
     *
     * @return void
     */
    public function updateAction()
    {
        $this->validate();

        $team  = $this->organization->teams()->find($this->idBeingUpdated);

        UpdateTeam::run(
            $this->user,
            $this->organization,
            $team,
            $this->updateForm
        );

        $this->emit('refresh');
    }

    /**
     * @return void
     */
    public function destroyAction()
    {
        $organization  = $this->organization->teams()->find($this->idBeingDestroyed);

        DestroyTeam::run(
            $this->user,
            $this->organization,
            $organization
        );

        redirect()->route('teams.index');
    }

    /**
     * Render the component
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {

        $events = $this->team
            ->events()
            ->search($this->keyword, ['name', 'date'])
            ->orderBy($this->sortByField, $this->sortDirection)
            ->paginate(25);

        return view('teams.show', compact('events'));
    }
}
