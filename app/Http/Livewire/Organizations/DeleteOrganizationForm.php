<?php

namespace App\Http\Livewire\Organizations;

use Illuminate\Support\Facades\Auth;
use App\Actions\Jetstream\ValidateOrganizationDeletion;
use App\Actions\Jetstream\DeleteOrganization;
use Laravel\Jetstream\RedirectsActions;
use Livewire\Component;

class DeleteOrganizationForm extends Component
{
    use RedirectsActions;

    /**
     * The organization instance.
     *
     * @var mixed
     */
    public $organization;

    /**
     * Indicates if organization deletion is being confirmed.
     *
     * @var bool
     */
    public $confirmingOrganizationDeletion = false;

    /**
     * Mount the component.
     *
     * @param  mixed  $organization
     * @return void
     */
    public function mount($organization)
    {
        $this->organization = $organization;
    }

    /**
     * Delete the organization.
     *
     * @param  \App\Actions\Jetstream\ValidateOrganizationDeletion  $validator
     * @param  \App\Actions\Jetstream\DeleteOrganization  $deleter

     * @return \Illuminate\Http\Response
     */
    public function deleteOrganization(ValidateOrganizationDeletion $validator, DeleteOrganization $deleter)
    {
        $validator->validate(Auth::user(), $this->organization);

        $deleter->delete($this->organization);

        return $this->redirectPath($deleter);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('organizations.delete-organization-form');
    }
}
