<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;
    /**
     * @var array
     */
    protected $listeners = [
        'refresh' => 'render',
    ];

    /**
     * @var string
     */
    public $projectsSortByField = 'name';

    /**
     * @var string
     */
    public $projectsSortDirection = 'asc';

    /**
     * @var string|null
     */
    public $projectsKeyword = null;

    /**
     * @var string
     */
    public $eventsSortByField = 'name';

    /**
     * @var string
     */
    public $eventsSortDirection = 'asc';

    /**
     * @var string|null
     */
    public $eventsKeyword = null;

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

    public function sortByProject(string $field)
    {
        $this->projectsSortByField = $field;

        $this->projectsSortDirection = ($this->projectsSortDirection == 'desc') ? 'asc' : 'desc';

        $this->emit('refresh');
    }

    /**
     * Sort the collection by the given field.
     *
     * @param  string $field
     *
     * @return void
     */
    public function sortByEvent(string $field)
    {
        $this->eventsSortByField = $field;

        $this->eventsSortDirection = ($this->eventsSortDirection == 'desc') ? 'asc' : 'desc';

        $this->emit('refresh');
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Check if user has an organization (organization owner/admin)
        if ($this->user->allOrganizations()->count() > 0) {
            // Organization-based access (existing logic)
            $teams = $this->user->currentOrganization->teams();

            $teamsPaginated = $teams
                ->search($this->projectsKeyword)
                ->orderBy($this->projectsSortByField, $this->projectsSortDirection)
                ->paginate(25);

            $events = $this->user
                ->currentOrganization
                ->events()
                ->search($this->eventsKeyword)
                ->orderBy($this->eventsSortByField, $this->eventsSortDirection)
                ->paginate(25, ['*'], 'eventsPage');

            return view('dashboard', compact('teams', 'events', 'teamsPaginated'));
        } else {
            // Project-scoped access for invited team members
            // Get only the teams this user is a member of
            $userTeams = \App\Models\Team::whereHas('members', function ($query) {
                $query->where('user_id', $this->user->id);
            });

            $teamsPaginated = $userTeams
                ->search($this->projectsKeyword)
                ->orderBy($this->projectsSortByField, $this->projectsSortDirection)
                ->paginate(25);

            // Get events only for teams this user belongs to
            $teamIds = $userTeams->pluck('id');
            $events = \App\Models\Event::whereIn('team_id', $teamIds)
                ->search($this->eventsKeyword)
                ->orderBy($this->eventsSortByField, $this->eventsSortDirection)
                ->paginate(25, ['*'], 'eventsPage');

            return view('dashboard', compact('teams', 'events', 'teamsPaginated'))
                ->with('isProjectScopedUser', true);
        }
    }
}
