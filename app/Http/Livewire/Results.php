<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Form;
use App\Models\Team;
use App\Models\User;
use WireUi\Traits\Actions;

class Results extends Component
{

    use Actions;

    /**
     * @var Event
     */
    public $event;

    /**
     * @var Form
     */
    public $form;

    /**
     * @var array
     */
    public $questions;

    /**
     * @var array
     */
    public $feedback_questions;

    /**
     * @var array
     */
    public $sections;

    /**
     * @var array
     */
    public $team;

    /**
     * @var array
     */
    public $responses;

    /**
     * @var array
     */
    public $progressMetricTotal = 0;

    /**
     * @var array
     */
    public $sectionTotals;

    /**
     * @var array
     */
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
        'updated' => 'render',
    ];

    /**
     * @var array
     */
    public $updateForm = [
        'net_projected_value' => '',
        'investment' => '',
        'priority_level' => '',
        'start_date' => '',

    ];

    /**
     * Undocumented function
     *
     * @param  Event  $event
     * @param  Form   $form
     * @param  Team   $team
     * @return void
     */
    public function mount(Event $event, Form $form, Team $team)
    {
        $this->event = $event;
        $this->form = $form;
        $this->team = $team;

        $this->questions = $form->allQuestions();
        $this->feedback_questions = $form->feedbackQuestions();
        $this->sections = collect($this->questions)->groupBy('section')->reject(fn ($item, $key) => $key == 'custom');
        $this->sectionTotals = $this->sections->keys()->mapWithkeys(fn ($item) => [$item . '_count' => 0])->all();
        $this->totalSections = $this->sections->reject(fn ($item, $key) => $key == 'Intutive_Scoring')->flatten(1)->count();
        $this->responses = $this->form->responses()->where('team_id', $team->id)->get();
    }

    /**
     * Confirm the update of a team
     */
    public function confirmUpdate()
    {
        $this->confirmingUpdating = true;

        $pivot = $this->team->pivot();

        $this->updateForm = [
            'net_projected_value' => $pivot?->net_projected_value,
            'investment' => $pivot?->investment,
            'priority_level' => $this->team->priority_level,
            'start_date' => $this->team->start_date->format('Y-m-d'),
        ];
    }

    public function update()
    {
        $this->event->teams()->updateExistingPivot($this->team, [
            'net_projected_value' => $this->updateForm['net_projected_value'],
            'investment' => $this->updateForm['investment'],

        ]);
        tap($this->team)->update([
            'priority_level' => $this->updateForm['priority_level'],
            'start_date' => $this->updateForm['start_date'],
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
        return view('events.results');
    }
}
