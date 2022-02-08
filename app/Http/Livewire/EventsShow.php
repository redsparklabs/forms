<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Livewire\BaseComponent;
use App\Actions\Events\UpdateEvent;

class EventsShow extends BaseComponent
{
    use WithPagination;

    /**
     * The user instance.
     *
     * @var \App\Models\User|null
     */
    public $event;


    /**
     * The organization instance.
     *
     * @var \App\Models\Organization
     */
    public $organization;

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
    public $componentName = 'Events';

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
    public $updateForm = [
        'name' => '',
        'date' => '',
        'teams' => [],
        'forms' => '',
    ];

    /**
     * Mount the component
     *
     * @param  Event $event
     *
     * @return void
     */
    public function mount(Event $event)
    {
        $this->event = $event;
        $this->organization = $this->event->organization;
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


    public function createAction() {

    }
    public function destroyAction() {

    }
    /**
     * Confirm the update of a team
     */
    public function confirmUpdateAction()
    {

        $this->updateForm = [
            'name' => $this->event?->name,
            'date' => $this->event?->date->format('Y-m-d'),
            'teams' => $this->event?->teams->pluck('id')->mapWithkeys(fn ($item) => [$item => $item]),
            'forms' => $this->event?->forms->first()->id
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


        UpdateEvent::run(
            $this->user,
            $this->organization,
            $this->event,
            $this->updateForm
        );
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
            ->withTrashed()
            ->search($this->keyword, ['name', 'priority_level'])
            ->orderBy($this->sortByField, $this->sortDirection)
            ->paginate(25);

        return view('events.show', compact('teams'));
    }
}
