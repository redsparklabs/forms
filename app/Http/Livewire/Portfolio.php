<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Organization;
use App\Models\Form;
use App\Models\FormQuestion;
use App\Http\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Portfolio extends Component
{
    use WithPagination;
    /**
     * @var array
     */
    protected $listeners = [
        'refresh' => 'render',
    ];

    public $projectsSortByField = 'name';

    public $projectsSortDirection = 'asc';

    public $projectsKeyword = null;

    public $eventsSortByField = 'name';

    public $eventsSortDirection = 'asc';

    public $eventsKeyword = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortByProject($field)
    {
        $this->projectsSortByField = $field;

        $this->projectsSortDirection = ($this->projectsSortDirection == 'desc') ? 'asc': 'desc';

        $this->emit('refresh');
    }

    public function sortByEvent($field)
    {
        $this->eventsSortByField = $field;

        $this->eventsSortDirection = ($this->eventsSortDirection == 'desc') ? 'asc': 'desc';

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

        return view('portfolio', compact('teams', 'events'));
    }
}
