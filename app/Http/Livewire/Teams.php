<?php

namespace App\Http\Livewire;

use App\Models\Organization;
use App\Actions\Teams\CreateTeam;

use App\Http\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Teams extends BaseComponent
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

    /**
     * @var string
     */
    public $sortByField = 'name';

    /**
     * @var string
     */
    public $keyword = null;

    /**
     * @var string
     */
    public $sortDirection = 'asc';
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

    /**
     * @var array
     */
    protected $messages = [
        'createForm.name.required' => 'Please add a name for this project.',
        'createForm.start_date.required' => 'Please enter a start date for this project.',
        'createForm.start_date.date' => 'Please enter a proper start date.',
    ];

    /**
     * @var array
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
     * @return void
     */
    public function mount()
    {
        $this->user = Auth::user();
        $this->organization = $this->user->currentOrganization;

        if (request()->has('create')) {
            $this->confirmingCreating = true;
        }
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

        $this->emit('refresh');
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
