<?php

namespace App\Http\Livewire\Teams;

use App\Actions\CreateTeam;
use App\Actions\UpdateTeam;
use App\Actions\DestroyTeam;
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
        'created' => '$refresh',
        'destroyed' => '$refresh',
    ];

    /**
     * @var string
     */
    public $componentName = 'Team';

    /**
     * @var array
     */
    public $createForm = [
        'name' => ''
    ];

    /**
     * @var array
     */
    public $updateForm = [
        'name' => ''
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
        CreateTeam::run(
            $this->user,
            $this->organization,
            $this->createForm
        );
    }

    /**
     * Confirm the update of a team
     */
    public function confirmUpdateAction()
    {
        $form = $this->organization->teams()->find($this->idBeingUpdated);

         $this->updateForm = [
            'name' => $form?->name
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
        return view('teams.team-manager');
    }
}
