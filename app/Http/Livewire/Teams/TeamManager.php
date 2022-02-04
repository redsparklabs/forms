<?php

namespace App\Http\Livewire\Teams;

use App\Models\Organization;
use App\Actions\Teams\CreateTeam;
use App\Actions\Teams\DestroyTeam;
use App\Http\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class TeamManager extends BaseComponent
{

    use WithPagination;
    /**
     * The component's listeners.
     *
     * @var array
     */
    protected $listeners = [
        'refresh' => 'render',
        'created' => '$refresh',
        'updated' => '$refresh',
        'destroyed' => '$refresh',
    ];

    public $sortByField = 'name';

    public $keyword = null;

    public $sortDirection = 'asc';

    public function updatingSearch()
    {
        $this->resetPage();
    }


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
     * @var array
     */
    public $createForm = [
        'name' => '',
        'priority_level' => '',
        'start_date' => ''
    ];

    public function sortBy($field)
    {
        $this->sortByField = $field;

        $this->sortDirection = ($this->sortDirection == 'desc') ? 'asc': 'desc';

        $this->emit('refresh');
    }

    /**
     * @return array
     */
    protected $messages = [
        'createForm.name.required' => 'Please add a name for this project.',
        'createForm.start_date.required' => 'Please enter a start date for this project.',
        'createForm.start_date.date' => 'Please enter a proper start date.',
    ];

    /**
     * @return array
     */
    protected $rules = [
        'createForm.name' => ['required'],
        'createForm.start_date' => ['required', 'date'],
    ];

    /**
     * @var string
     */
    public $componentName = 'Project';

    /**
     * Mount the component
     *
     * @param  Organization $organization
     *
     * @return void
     */
    public function mount()
    {
        $this->user = Auth::user();
        $this->organization = $this->user->currentOrganization;

        if(request()->has('create')) {
            $this->confirmingCreating = true;
        }
    }

    /**
     * Create a new team
     *
     * @return void
     */
    public function createAction()
    {
        $this->validate();

        CreateTeam::run(
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
        $organization  = $this->organization->teams()->find($this->idBeingDestroyed);

        DestroyTeam::run(
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
        $teams = $this->organization
            ->teams()
            ->search($this->keyword)
            ->orderBy($this->sortByField, $this->sortDirection)
            ->paginate(25);

        return view('teams.index', compact('teams'));
    }
}
