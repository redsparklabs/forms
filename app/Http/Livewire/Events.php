<?php

namespace App\Http\Livewire;

use App\Actions\Events\CreateEvent;
use App\Actions\Events\UpdateEvent;
use App\Actions\Events\DestroyEvent;
use App\Models\Organization;
use App\Http\Livewire\BaseComponent;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Events extends BaseComponent
{

    use WithPagination;

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
     * @var string
     */
    public $sortByField = 'date';

    /**
     * @var null
     */
    public $keyword = null;

    /**
     * @var string
     */
    public $sortDirection = 'desc';

    /**
     * @var string
     */
    public $componentName = 'Event';

    /**
     * The component's listeners.
     *
     * @var array
     */
    protected $listeners = [
        'refresh' => 'render',
        'updated' => 'render',
        'created' => 'render',
        'destroyed' => 'render',
    ];

    /**
     * @var array
     */
    public $createForm = [
        'name' => '',
        'date' => '',
        'teams' => [],
        'forms' => '',
        'department' => ''
    ];

    /**
     * @var array
     */
    public $updateForm = [
        'name' => '',
        'date' => '',
        'teams' => [],
        'forms' => '',
        'department' => '',
        'questions' => []
    ];

    /**
     * Mount the component
     *
     * @return void
     */
    public function mount()
    {
        $this->user = Auth::user();
        
        // Handle organization-based access (organization admins)
        if ($this->user->allOrganizations()->count() > 0) {
            $this->organization = $this->user->currentOrganization;
        } else {
            // For project-scoped team members, organization will be null
            $this->organization = null;
        }

        if (request()->has('create')) {
            $this->confirmingCreating = true;
        }
    }

    /**
     * Update the search keyword.
     *
     * @return void
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Sort the collection by the given field.
     *
     * @param  string $field
     *
     * @return void
     */
    public function sortBy(string $field)
    {
        $this->sortByField = $field;

        $this->sortDirection = ($this->sortDirection == 'desc') ? 'asc' : 'desc';

        $this->emit('refresh');
    }
    /**
     * Create a new team
     *
     * @return void
     */
    public function createAction()
    {
        $this->validate([
            'createForm.name' => 'required',
            'createForm.teams' => 'required',
            'createForm.date' => ['required', 'date'],
            'createForm.forms' => 'required'
        ], [
            'createForm.name.required' => 'Please enter a name.',
            'createForm.teams.required' => 'Please choose a team.',
            'createForm.forms.required' => 'Please choose a form.',
            'createForm.date.required' => 'Please enter a proper date.',
        ]);

        CreateEvent::run(
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
        $event = $this->organization->events()->find($this->idBeingUpdated);
        $form = $event?->forms->first();
        
        // Get questions with their current order and enabled status
        $questions = [];
        if ($form) {
            $formQuestions = $form->questions()->orderBy('form_question.order')->get();
            foreach ($formQuestions as $question) {
                $questions[$question->id] = [
                    'id' => $question->id,
                    'question' => $question->question,
                    'description' => $question->description,
                    'section' => $question->section,
                    'enabled' => !$question->hidden,
                    'order' => $question->pivot->order
                ];
            }
        }
        
        $this->updateForm = [
            'name' => $event?->name,
            'date' => $event?->date->format('Y-m-d'),
            'teams' => $event?->teams->pluck('id')->mapWithkeys(fn ($item) => [$item => $item]),
            'department' => $event?->department,
            'forms' => $event?->forms->first()->id,
            'questions' => $questions
        ];
    }

    /**
     * Update a team
     *
     * @return void
     */
    public function updateAction()
    {
        $this->updateForm['teams'] = array_filter($this->updateForm['teams']);

        $this->validate([
            'updateForm.name' => 'required',
            'updateForm.teams' => 'required',
            'updateForm.date' => ['required', 'date'],
            'updateForm.forms' => 'required'
        ], [
            'updateForm.name.required' => 'Please enter a name.',
            'updateForm.teams.required' => 'Please choose a team.',
            'updateForm.forms.required' => 'Please choose a form.',
            'updateForm.date.required' => 'Please enter a proper date.',
        ]);

        $event = $this->organization->events()->find($this->idBeingUpdated);

        // Update the event
        UpdateEvent::run(
            $this->user,
            $this->organization,
            $event,
            $this->updateForm
        );

        // Update question settings if questions are provided
        if (!empty($this->updateForm['questions'])) {
            $form = $event->forms()->first();
            if ($form) {
                foreach ($this->updateForm['questions'] as $questionId => $questionData) {
                    // Update question enabled/disabled status
                    \App\Models\Question::where('id', $questionId)
                        ->update(['hidden' => !$questionData['enabled']]);
                    
                    // Update question order in pivot table
                    $form->questions()->updateExistingPivot($questionId, [
                        'order' => $questionData['order']
                    ]);
                }
            }
        }
    }

    /**
     * Move question up in order
     *
     * @param int $questionId
     * @return void
     */
    public function moveQuestionUp($questionId)
    {
        $questions = $this->updateForm['questions'];
        $currentOrder = $questions[$questionId]['order'];
        
        // Find the question with the previous order
        foreach ($questions as $id => $question) {
            if ($question['order'] == $currentOrder - 1) {
                // Swap orders
                $this->updateForm['questions'][$id]['order'] = $currentOrder;
                $this->updateForm['questions'][$questionId]['order'] = $currentOrder - 1;
                break;
            }
        }
        
        // Trigger Livewire reactivity by reassigning the entire array
        $this->updateForm = $this->updateForm;
    }

    /**
     * Move question down in order
     *
     * @param int $questionId
     * @return void
     */
    public function moveQuestionDown($questionId)
    {
        $questions = $this->updateForm['questions'];
        $currentOrder = $questions[$questionId]['order'];
        
        // Find the question with the next order
        foreach ($questions as $id => $question) {
            if ($question['order'] == $currentOrder + 1) {
                // Swap orders
                $this->updateForm['questions'][$id]['order'] = $currentOrder;
                $this->updateForm['questions'][$questionId]['order'] = $currentOrder + 1;
                break;
            }
        }
        
        // Trigger Livewire reactivity by reassigning the entire array
        $this->updateForm = $this->updateForm;
    }

    /**
     * Delete a team
     *
     * @return void
     */
    public function destroyAction()
    {
        $organization  = $this->organization->events()->find($this->idBeingDestroyed);

        DestroyEvent::run(
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
        // Check if user has an organization (organization admin)
        if ($this->user->allOrganizations()->count() > 0 && $this->organization) {
            // Organization-based access (existing logic)
            $events = $this->organization
                ->events()
                ->search($this->keyword)
                ->orderBy($this->sortByField, $this->sortDirection)
                ->paginate(25);
        } else {
            // Project-scoped access for team members
            // Get events only for teams this user belongs to
            $userTeamIds = \App\Models\Team::whereHas('members', function ($query) {
                $query->where('user_id', $this->user->id);
            })->pluck('id');

            $events = \App\Models\Event::whereHas('teams', function ($query) use ($userTeamIds) {
                $query->whereIn('teams.id', $userTeamIds);
            })
                ->search($this->keyword)
                ->orderBy($this->sortByField, $this->sortDirection)
                ->paginate(25);
        }

        return view('events.index', compact('events'));
    }
}
