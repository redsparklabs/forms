<?php

namespace App\Http\Livewire;

use App\Models\Team;
use App\Actions\Teams\CreateTeam;
use App\Models\Organization;
use App\Http\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;
use App\Actions\Teams\UpdateTeam;

class TeamsShow extends BaseComponent
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
    public $componentName = 'Project';

    /**
     * @var array
     */
    public $updateForm = [
        'name' => '',
        'priority_level' => '',
        'start_date' => ''
    ];

    /**
     * @return array
     */
    protected $messages = [
        'updateForm.name.required' => 'Please add a name for this project.',
        'updateForm.start_date.required' => 'Please enter a start date for this project.',
        'updateForm.start_date.date' => 'Please enter a proper start date.',
    ];

    /**
     * @return array
     */
    protected $rules = [
        'updateForm.name' => ['required'],
        'updateForm.start_date' => ['required', 'date'],
    ];

    /**
     * Mount the component
     *
     * @param  Organization $organization
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
            'name' => $team?->name,
            'priority_level' => $team?->priority_level,
            'start_date' => $team->start_date->format('Y-m-d'),
        ];
    }

    /**
     * Update a team
     *
     * @return void
     */
    public function updateAction()
    {
        $team  = $this->organization->teams()->find($this->idBeingUpdated);

        UpdateTeam::run(
            $this->user,
            $this->organization,
            $team,
            $this->updateForm
        );

        $this->emit('refresh-navigation-menu');
    }

    /**
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
        return view('teams.show');
    }
}
