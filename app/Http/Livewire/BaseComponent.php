<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use WireUi\Traits\Actions;
use App\Models\Team;

abstract class BaseComponent extends Component
{

    use Actions;

    /**
     * The team we are using
     * @var Team
     */
    public $team;

    /**
     * The Components Name
     * @var string
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
    public $confirmingCreating = false;

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
    }

    /**
     * Confirm that the given resource should be updated.
     *
     * @return void
     */
    public function confirmCreate()
    {
        $this->confirmingCreating = true;
    }

    /**
     * Execute the creation action
     *
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

        // $this->reloadOrganization();
    }

    /**
     * Close any open update modal and reset related state.
     *
     * @return void
     */
    public function closeModal()
    {
        // Close the updating modal consistently
        $this->confirmingUpdating = false;

        // Clear the id being edited
        $this->idBeingUpdated = null;

        // Clear validation state so it doesn't persist into next open
        $this->resetErrorBag();
        $this->resetValidation();
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
            $this->componentName . ' Archived',
            'Your ' . strtolower($this->componentName) . ' was successfully archived.'
        );

        $this->confirmingDestroying = false;

        $this->idBeingDestroyed = null;

        $this->emit('destroyed');
    }

    /**
     * Destroy action that should be executed
     *
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

    /**
     * @return void
     */
    // public function reloadOrganization()
    // {
    //     $this->organization = $this->organization->fresh();
    // }
}
