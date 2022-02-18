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


        $teams = $this->user
            ->currentOrganization
            ->teams()
            ->search($this->projectsKeyword)
            ->orderBy($this->projectsSortByField, $this->projectsSortDirection)
            ->paginate(25);

        $events = $this->user
            ->currentOrganization
            ->events()
            ->search($this->eventsKeyword)
            ->orderBy($this->eventsSortByField, $this->eventsSortDirection)
            ->paginate(25, ['*'], 'eventsPage');

        return view('dashboard', compact('teams', 'events'));
    }
}
