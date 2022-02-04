<?php

namespace App\Http\Livewire\Teams;

use App\Models\Organization;
use App\Actions\Teams\CreateTeam;
use App\Actions\Teams\DestroyTeam;
use App\Http\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;

class TeamManager extends BaseComponent
{

    /**
     * The component's listeners.
     *
     * @var array
     */
    protected $listeners = [
        'created' => '$refresh',
        'updated' => '$refresh',
        'destroyed' => '$refresh',
    ];

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
        return view('teams.index');
    }
}
