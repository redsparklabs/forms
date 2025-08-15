<?php

namespace App\Http\Livewire;

use App\Models\Team;
use App\Actions\Teams\DestroyTeam;
use App\Models\Organization;
use App\Models\Response;
use Livewire\WithPagination;
use App\Actions\Teams\UpdateTeam;
use App\Http\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class TeamsShow extends BaseComponent
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
     * The component's listeners.
     *
     * @var array
     */
    protected $listeners = [
        'refresh' => 'render',
        'created' => 'render',
        'updated' => 'render',
    ];

    /**
     * @var string
     */
    public $componentName = 'Project';

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
     * @var array
     */
    public $updateForm = [
        'name' => '',
        'priority_level' => '',
        'start_date' => '',
        'description' => '',
        'minimum_success_criteria' => '',
        'estimated_launch_date' => '',
        'sponsor' => '',
    ];

    /**
     * Historical chart properties
     */
    public $showHistoricalModal = false;
    public $selectedQuestionSlug;
    public $selectedQuestionTitle;
    public $selectedQuestionDescription;
    public $historicalData = [];

    /**
     * @var array
     */
    protected $messages = [
        'updateForm.name.required' => 'Please add a name for this project.',
        'updateForm.description.required' => 'Please enter a description for this project.',
        'updateForm.start_date.required' => 'Please enter a start date for this project.',
        'updateForm.start_date.date' => 'Please enter a proper start date.',
    ];

    /**
     * @var array
     */
    protected $rules = [
        'updateForm.name' => ['required'],
        'updateForm.description' => ['required'],
        'updateForm.start_date' => ['required', 'date'],
    ];

    /**
     * Mount the component
     *
     * @param  Team $team
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

        $this->emit('reload_graph');
        $this->emit('refresh');
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
            'name' => $team->name,
            'priority_level' => $team->priority_level,
            'start_date' => $team->start_date?->format('Y-m-d'),
            'description' => $team->description,
            'minimum_success_criteria' => $team->minimum_success_criteria,
            'estimated_launch_date' => $team->estimated_launch_date?->format('Y-m-d'),
            'sponsor' => $team->sponsor,
        ];
    }

    /**
     * Update a team
     *
     * @return void
     */
    public function updateAction()
    {
        $this->validate();

        $team  = $this->organization->teams()->find($this->idBeingUpdated);

        UpdateTeam::run(
            $this->user,
            $this->organization,
            $team,
            $this->updateForm
        );

        $this->emit('refresh');
    }

    /**
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

        redirect()->route('teams.index');
    }

    /**
     * Show historical chart for a specific question
     */
    public function showHistoricalChart($questionSlug, $questionTitle, $questionDescription = '')
    {
        $this->selectedQuestionSlug = $questionSlug;
        $this->selectedQuestionTitle = $questionTitle;
        $this->selectedQuestionDescription = $questionDescription;
        $this->loadHistoricalData();
        $this->showHistoricalModal = true;
        
        // Emit event to render chart after modal is shown
        $this->emit('renderHistoricalChart', $this->historicalData);
    }

    /**
     * Close historical chart modal
     */
    public function closeHistoricalModal()
    {
        $this->showHistoricalModal = false;
        $this->selectedQuestionSlug = null;
        $this->selectedQuestionTitle = null;
        $this->selectedQuestionDescription = null;
        $this->historicalData = [];
    }

    /**
     * Load historical data for the selected question
     */
    private function loadHistoricalData()
    {
        if (!$this->selectedQuestionSlug) {
            return;
        }

        // Get all events for this team, ordered by created date
        $events = $this->team->events()->orderBy('created_at', 'asc')->get();
        
        $historicalData = [];
        
        foreach ($events as $event) {
            // Get responses for this event and team
            $responses = $event->responses()
                ->where('team_id', $this->team->id)
                ->get();
            
            if ($responses->isNotEmpty()) {
                // Calculate average score for this question across all responses in this event
                $scores = [];
                foreach ($responses as $response) {
                    $questionData = $response->response['questions'] ?? [];
                    if (isset($questionData[$this->selectedQuestionSlug])) {
                        $scores[] = (float) $questionData[$this->selectedQuestionSlug];
                    }
                }
                
                if (!empty($scores)) {
                    $averageScore = array_sum($scores) / count($scores);
                    $historicalData[] = [
                        'date' => $event->created_at->format('M j, Y'),
                        'score' => number_format($averageScore, 1),
                        'event_id' => $event->id
                    ];
                }
            }
        }
        
        $this->historicalData = $historicalData;
    }

    /**
     * Render the component
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {

        $events = $this->team
            ->events()
            ->search($this->keyword, ['name', 'date'])
            ->orderBy($this->sortByField, $this->sortDirection)
            ->paginate(25);

        // Chart data: limit to last 90 days relative to most recent event
        $latestEventDate = $this->team->events()->max('date');
        if ($latestEventDate) {
            $endDate = Carbon::parse($latestEventDate);
        } else {
            $endDate = Carbon::now();
        }
        $startDate = (clone $endDate)->subDays(90);

        $chartEvents = $this->team
            ->events()
            ->whereBetween('date', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->orderBy('date', 'asc')
            ->get();

        return view('teams.show', compact('events', 'chartEvents'));
    }
}
