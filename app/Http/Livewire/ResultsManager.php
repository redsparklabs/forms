<?php

namespace App\Http\Livewire;

use App\Models\Organization;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Form;
use App\Models\Team;
use WireUi\Traits\Actions;

class ResultsManager extends Component
{

    use Actions;

    public $event;
    public $form;
    public $user;
    public $questions;
    public $sections;
    public $team;
    public $responses;
    public $progressMetricTotal;
    public $sectionTotals;
    public $totalSections;


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

        $pivot = $this->event->teams->find($this->team)->pivot;

        $this->updateForm = [
            'net_projected_value' => $pivot?->net_projected_value,
            'investment' => $pivot?->investment,
        ];
    }

    public function update()
    {
        $this->event->teams()->updateExistingPivot($this->team, [
            'net_projected_value' => $this->updateForm['net_projected_value'],
            'investment' => $this->updateForm['investment'],
        ]);
        $this->notification()->success(
            'Data Updated',
            'Your data was successfully updated.'
        );

        $this->reset('updateForm');

        $this->emit('updated');

        $this->confirmingUpdating = false;
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
