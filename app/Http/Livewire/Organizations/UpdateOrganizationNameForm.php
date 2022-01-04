<?php

namespace App\Http\Livewire\Organizations;

use App\Actions\Jetstream\UpdateOrganizationName;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UpdateOrganizationNameForm extends Component
{
    /**
     * The user instance.
     *
     * @var mixed
     */
    public $user;

    /**
     * The organization instance.
     *
     * @var mixed
     */
    public $organization;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    /**
     * Mount the component.
     *
     * @param  mixed  $organization
     * @return void
     */
    public function mount($organization)
    {
        $this->organization = $organization;
        $this->user = Auth::user();

        $this->state = $organization->withoutRelations()->toArray();
    }

    /**
     * Update the organization's name.
     *
     * @param  \App\Actions\Jetstream\UpdateOrganizationName  $updater
     * @return void
     */
    public function updateOrganizationName(UpdateOrganizationName $updater)
    {
        $this->resetErrorBag();

        $updater->update($this->user, $this->organization, $this->state);

        $this->emit('saved');

        $this->emit('refresh-navigation-menu');
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
        return view('organizations.update-organization-name-form');
    }
}
