<?php

namespace App\Http\Livewire\Teams;

use App\Actions\Teams\CreateTeam;
use App\Actions\Teams\UpdateTeam;
use App\Actions\Teams\DestroyTeam;
use App\Models\Organization;
use App\Http\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;

class TeamManager extends BaseComponent
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
        'destroyed' => '$refresh',
    ];

    /**
     * @var string
     */
    public $componentName = 'Team';

    /**
     * @var array
     */
    public $updateForm = [
        'name' => '',
        'priority_level' => '',
        'start_date' => ''
    ];

    public function createAction()
    {
    }
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
     * Confirm the update of a team
     */
    public function confirmUpdateAction()
    {
        $team = $this->organization->teams()->find($this->idBeingUpdated);

        $this->updateForm = [
            'name' => $team?->name,
            'priority_level' => $team?->priority_level,
            'start_date' => $team?->priority_level,
        ];
    }


    /**
     * Update a team
     *
     * @return void
     */
    public function updateAction()
    {
        $organization  = $this->organization->teams()->find($this->idBeingUpdated);

        UpdateTeam::run(
            $this->user,
            $this->organization,
            $organization,
            $this->updateForm
        );

        $this->emit('refresh-navigation-menu');
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

        $this->emit('refresh-navigation-menu');
    }

    /**
     * Render the component
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('teams.team-manager');
    }
}
