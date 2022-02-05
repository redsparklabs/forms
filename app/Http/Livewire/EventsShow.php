<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use WireUi\Traits\Actions;

class EventsShow extends Component
{
    /**
     * The user instance.
     *
     * @var \App\Models\User|null
     */
    public $event;
    /**
     * @var string
     */
    public $sortByField = 'name';

    /**
     * @var null
     */
    public $keyword = null;

    /**
     * @var string
     */
    public $sortDirection = 'asc';

    /**
     * @var string
     */
    public $componentName = 'EventsShow';

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
     * Mount the component
     *
     * @param  Organization $organization
     *
     * @return void
     */
    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        $this->sortByField = $field;

        $this->sortDirection = ($this->sortDirection == 'desc') ? 'asc': 'desc';

        $this->emit('refresh');
    }


    /**
     * Render the component
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $teams = $this->event
            ->teams()
            ->search($this->keyword, ['name', 'priority_level'])
            ->orderBy($this->sortByField, $this->sortDirection)
            ->paginate(25);

        return view('events.show', compact('teams'));
    }
}
