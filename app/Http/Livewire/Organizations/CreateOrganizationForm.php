<?php

namespace App\Http\Livewire\Organizations;

use Illuminate\Support\Facades\Auth;
use App\Actions\CreatesOrganizations;
use Laravel\Jetstream\RedirectsActions;
use Livewire\Component;

class CreateOrganizationForm extends Component
{
    use RedirectsActions;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    /**
     * Create a new team.
     *
     * @param  \App\Actions\CreatesOrganizations  $creator
     *
     * @return \Illuminate\Http\Response
     */
    public function createOrganization(CreatesOrganizations $creator)
    {
        $this->resetErrorBag();

        $creator->create(Auth::user(), $this->state);

        return $this->redirectPath($creator);
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
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('organizations.create-organization-form');
    }
}
