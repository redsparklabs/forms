<?php

namespace App\Http\Livewire;

use App\Models\Organization;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Form;
use App\Models\Team;

class ResultsManager extends Component
{

    /**
     * The organization instance.
     *
     * @var \App\Models\Organization
     */
    public $event;

    /**
     * The organization instance.
     *
     * @var \App\Models\Organization
     */
    public $form;

    /**
     * The user instance.
     *
     * @var \App\Models\User|null
     */
    public $user;

    /**
     * Indicates if the a resource should be updated.
     *
     * @var bool
     */
    public $confirmingUpdating = false;

    /**
     * The component's listeners.
     *
     * @var array
     */
    protected $listeners = [
        'updated' => '$refresh',
    ];

    /**
     * @var array
     */
    public $updateForm = [
        'net_projected_value' => '',
        'investment' => '',
    ];


    /**
     * Mount the component
     *
     * @param  Organization $organization
     *
     * @return void
     */
    public function mount(Event $event, Form $form, Team $team, $questions, $sections, $responses, $progressMetricTotal, $sectionTotals, $totalSections)
    {
        $this->event = $event;
        $this->form = $form;
        $this->user = Auth::user();
        $this->questions = $questions;
        $this->sections = $sections;
        $this->team = $team;
        $this->responses = $responses;
        $this->progressMetricTotal = $progressMetricTotal;
        $this->sectionTotals = $sectionTotals;
        $this->totalSections = $totalSections;
    }

    /**
     * Confirm the update of a team
     */
    public function confirmUpdate()
    {
        $this->confirmingUpdating = true;

        $team = $this->organization->teams()->find($this->idBeingUpdated);

        $this->updateForm = [
            'net_projected_value' => $team?->net_projected_value,
            'investment' => $team?->investment,
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

        // UpdateTeam::run(
        //     $this->user,
        //     $this->organization,
        //     $organization,
        //     $this->updateForm
        // );
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
        return view('livewire.results-manager');
    }
}
