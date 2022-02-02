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
        $this->validate();

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
