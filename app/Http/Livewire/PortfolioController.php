<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Organization;
use App\Models\Form;
use App\Models\FormQuestion;
use App\Http\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class PortfolioController extends Component
{
    use WithPagination;
    /**
     * @var array
     */
    protected $listeners = [
        'refresh' => 'render',
    ];


    public $sortByField = 'name';

    public $sortDirection = 'asc';

    public $keyword = null;

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
            ->search($this->keyword)
            ->orderBy($this->sortByField, $this->sortDirection)
            ->paginate(25);
        return view('portfolio', compact('teams'));
    }
}
