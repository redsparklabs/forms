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
     * @var \App\Models\Event
     */
    public $event;

    /**
     * @var \App\Models\Form
     */
    public $form;

    /**
     *
     * @var \Illuminate\Support\Collection.
     */
    public $questions;

    /**
     * @var array
     */
    public $feedback_questions;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $sections;

    /**
     * @var \App\Models\Team
     */
    public $team;

    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $responses;

    /**
     * @var integer
     */
    public $progressMetricTotal = 0;

    /**
     * @var array
     */
    public $sectionTotals;

    /**
     * @var integer
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
     * @var array
     */
    protected $rules = [
        'updateForm.net_projected_value' => ['numeric','regex:/^\d+(\.\d{1,2})?$/'],
        'updateForm.investment' => ['numeric','regex:/^\d+(\.\d{1,2})?$/'],
    ];
        /**
     * @var array
     */
    protected $messages = [
        // 'updateForm.net_projected_value.numeric' => 'Please enter a valid number.',
        // 'updateForm.investment.numeric' => 'Please enter a valid number.',
        'updateForm.net_projected_value.regex' => 'Please enter a valid number.',
        'updateForm.investment.regex' => 'Please enter a valid number.',
    ];

    /**
     * Undocumented function
     *
     * @param  Event  $event
     * @param  Form   $form
     * @param  Team   $team
     * @return void
     */
    public function mount(Event $event, Team $team)
    {
        $this->event = $event;
        $this->form = $event->latestForm();
        $this->team = $team;

        $this->questions = $this->form->allQuestions();
        $this->feedback_questions = $this->form->feedbackQuestions();
        $this->sections = collect($this->questions)->groupBy('section')->reject(fn ($item, $key) => $key == 'custom');
        $this->sectionTotals = $this->sections->keys()->mapWithkeys(fn ($item) => [$item . '_count' => 0])->all();
        $this->totalSections = $this->sections->reject(fn ($item, $key) => $key == 'Intutive_Scoring')->flatten(1)->count();
        $this->responses = $this->event->responses()->where('team_id', $team->id)->get();
    }

    /**
     * Confirm the update of a team
     *
     * @return void
     */
    public function confirmUpdate()
    {
        $this->confirmingUpdating = true;

        $pivot = $this->event->teams()->find($this->team)?->pivot;

        $this->updateForm = [
            'net_projected_value' => $pivot?->net_projected_value,
            'investment' => $pivot?->investment,
            'priority_level' => $this->team->priority_level,
            'start_date' => $this->team->start_date?->format('Y-m-d'),
        ];
    }

    /**
     * Update a team
     *
     * @return void
     */
    public function update()
    {
        $this->validate();

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
     * Close the update modal without saving.
     *
     * @return void
     */
    public function closeModal()
    {
        $this->resetErrorBag();
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
