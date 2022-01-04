<?php

namespace App\Http\Livewire\Organizations;

use Illuminate\Support\Facades\Auth;
use App\Actions\Jetstream\UpdateOrganizationName;
use Livewire\Component;

class UpdateOrganizationNameForm extends Component
{
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

        $this->state = $organization->withoutRelations()->toArray();
    }

    /**
     * Update the organization's name.
     *
     * @param  \App\Actions\Jetstream\UpdatesOrganizationNames  $updater
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
