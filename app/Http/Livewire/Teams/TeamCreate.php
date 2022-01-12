<?php

namespace App\Http\Livewire\Teams;

use App\Actions\Teams\CreateTeam;
use App\Models\Organization;
use App\Http\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;

class TeamCreate extends BaseComponent
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
    public $componentName = 'Team';

    /**
     * @var array
     */
    public $createForm = [
        'name' => '',
        'priority_level' => '',
        'start_date' => ''
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

        $this->emit('refresh-navigation-menu');

        return redirect()->to(route('teams.index'));
    }

    /**
     * @return void
     */
    public function confirmUpdateAction()
    {
    }

    /**
     * @return void
     */
    public function updateAction()
    {
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
        return view('teams.team-create');
    }
}
