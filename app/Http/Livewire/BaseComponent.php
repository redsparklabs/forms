<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use WireUi\Traits\Actions;
use App\Team;

abstract class BaseComponent extends Component {

    use Actions;

    /**
     * The team we are using
     */
    public $team;

    /**
     * The Components Name
     */
    public $componentName;

    /**
     * Indicates if the application is confirming if a Form should be destroyed.
     *
     * @var bool
     */
    public $confirmingDestroying = false;

    /**
     * The ID of the Form being destroyed.
     *
     * @var int|null
     */
    public $idBeingDestroyed = null;

    /**
     * Indicates if the a resource should be updated.
     *
     * @var bool
     */
    public $confirmingUpdating = false;

    /**
     * The ID of the form being updated.
     *
     * @var int|null
     */
    public $idBeingUpdated = null;

    /**
     * The "createForm" form state.
     *
     * @var array
     */
    public $createForm = [];

    /**
     * The "update" form state.
     *
     * @var array
     */
    public $updateForm = [];

    /**
     * Add a new resource.
     *
     * @return void
     */
    public function create()
    {
        $this->resetErrorBag();

        $this->createAction();

        $this->notification()->success(
            $this->componentName . ' Created',
            'Your ' . strtolower($this->componentName) . ' was successfully created.'
        );

        $this->reset('createForm');

        $this->emit('created');

        $this->reloadTeam();
    }

    /**
     * Execute the creation action
     *
     * @param  int  $id
     * @return void
     */
    abstract public function createAction();

    /**
     * Confirm that the given resource should be updated.
     *
     * @param  int  $id
     * @return void
     */
    public function confirmUpdate($id)
    {
        $this->confirmingUpdating = true;

        $this->idBeingUpdated = $id;

        $this->confirmUpdateAction();

    }

    /**
     * Confirm action that should be executed
     *
     * @return void
     */
    abstract public function confirmUpdateAction();

    /**
     * Update a form on the team.
     *
     * @return void
     */
    public function update()
    {
        $this->updateAction();

        $this->notification()->success(
            $this->componentName . ' Updated',
            'Your ' . strtolower($this->componentName) . ' was successfully updated.'
        );

        $this->reset('updateForm');

        $this->emit('updated');

        $this->confirmingUpdating = false;

        $this->idBeingUpdated = null;

        $this->reloadTeam();
    }

    /**
     * Update action that should be executed
     *
     * @return void
     */
    abstract public function updateAction();

    /**
     * Confirm that the given resource should be destroyed.
     *
     * @param  int  $id
     * @return void
     */
    public function confirmDestroy($id)
    {
        $this->confirmingDestroying = true;

        $this->idBeingDestroyed = $id;
    }

    /**
     * Destroy a resource.
     *
     * @return void
     */
    public function destroy()
    {
        $this->destroyAction();

        $this->notification()->success(
            $this->componentName . ' Removed',
            'Your ' . strtolower($this->componentName) . ' was successfully removed.'
        );

        $this->confirmingDestroying = false;

        $this->idBeingDestroyed = null;

        $this->emit('destroyed');

        $this->reloadTeam();
    }

    /*
     * Destroy action that should be executed
     *
     * @param  int  $id
     * @return void
     */
    abstract public function destroyAction();

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    public function reloadTeam()
    {
        if($this->team) {
            $this->team = $this->team->fresh();
        }
    }
}
