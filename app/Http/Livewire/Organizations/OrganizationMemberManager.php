<?php

namespace App\Http\Livewire\Organizations;

use Illuminate\Support\Facades\Auth;
use App\Actions\Jetstream\UpdateOrganizationMemberRole;
use App\Actions\Jetstream\AddOrganizationMember;
use App\Actions\Jetstream\InviteOrganizationMember;
use App\Actions\Jetstream\RemoveOrganizationMember;
use App\Models\Organization;
use App\Models\OrganizationInvitation;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Role;
use Livewire\Component;

class OrganizationMemberManager extends Component
{

    /**
     * The organization instance.
     *
     * @var \App\Models\User|null
     */
    public $user;

    /**
     * The organization instance.
     *
     * @var mixed
     */
    public $organization;

    /**
     * Indicates if a user's role is currently being managed.
     *
     * @var bool
     */
    public $currentlyManagingRole = false;

    /**
     * The user that is having their role managed.
     *
     * @var mixed
     */
    public $managingRoleFor;

    /**
     * The current role for the user that is having their role managed.
     *
     * @var string
     */
    public $currentRole;

    /**
     * Indicates if the application is confirming if a user wishes to leave the current organization.
     *
     * @var bool
     */
    public $confirmingLeavingOrganization = false;

    /**
     * Indicates if the application is confirming if a organization member should be removed.
     *
     * @var bool
     */
    public $confirmingOrganizationMemberRemoval = false;

    /**
     * The ID of the organization member being removed.
     *
     * @var int|null
     */
    public $organizationMemberIdBeingRemoved = null;

    /**
     * The "add organization member" form state.
     *
     * @var array
     */
    public $addOrganizationMemberForm = [
        'email' => '',
        'role' => null,
    ];

    /**
     * Mount the component.
     *
     * @param  mixed  $organization
     * @return void
     */
    public function mount($organization)
    {
        $this->user = Auth::user();
        $this->organization = $organization;
    }

    /**
     * Add a new organization member to a organization.
     *
     * @return void
     */
    public function addOrganizationMember()
    {
        $this->resetErrorBag();

        if (Features::sendsTeamInvitations()) {
            app(InviteOrganizationMember::class)->invite(
                $this->user,
                $this->organization,
                $this->addOrganizationMemberForm['email'],
                $this->addOrganizationMemberForm['role']
            );
        } else {
            app(AddOrganizationMember::class)->add(
                $this->user,
                $this->organization,
                $this->addOrganizationMemberForm['email'],
                $this->addOrganizationMemberForm['role']
            );
        }

        $this->addOrganizationMemberForm = [
            'email' => '',
            'role' => null,
        ];

        $this->organization = $this->organization->fresh();

        $this->emit('saved');
    }

    /**
     * Cancel a pending organization member invitation.
     *
     * @param  int  $invitationId
     * @return void
     */
    public function cancelOrganizationInvitation($invitationId)
    {
        if (! empty($invitationId)) {

            OrganizationInvitation::whereKey($invitationId)->delete();
        }

        $this->organization = $this->organization->fresh();
    }

    /**
     * Allow the given user's role to be managed.
     *
     * @param  int  $userId
     * @return void
     */
    public function manageRole($userId)
    {
        $this->currentlyManagingRole = true;
        $this->managingRoleFor = Jetstream::findUserByIdOrFail($userId);
        $this->currentRole = $this->managingRoleFor->organizationRole($this->organization)->key;
    }

    /**
     * Save the role for the user being managed.
     *
     * @param  \App\Actions\Jetstream\UpdateOrganizationMemberRole  $updater
     * @return void
     */
    public function updateRole(UpdateOrganizationMemberRole $updater)
    {
        $updater->update(
            $this->user,
            $this->organization,
            $this->managingRoleFor->id,
            $this->currentRole
        );

        $this->organization = $this->organization->fresh();

        $this->stopManagingRole();
    }

    /**
     * Stop managing the role of a given user.
     *
     * @return void
     */
    public function stopManagingRole()
    {
        $this->currentlyManagingRole = false;
    }

    /**
     * Remove the currently authenticated user from the organization.
     *
     * @param  \App\Actions\Jetstream\RemoveOrganizationMember  $remover
     * @return \Illuminate\Http\RedirectResponse
     */
    public function leaveOrganization(RemoveOrganizationMember $remover)
    {
        $remover->remove(
            $this->user,
            $this->organization,
            $this->user
        );

        $this->confirmingLeavingOrganization = false;

        $this->organization = $this->organization->fresh();

        return redirect(config('fortify.home'));
    }

    /**
     * Confirm that the given organization member should be removed.
     *
     * @param  int  $userId
     * @return void
     */
    public function confirmOrganizationMemberRemoval($userId)
    {
        $this->confirmingOrganizationMemberRemoval = true;

        $this->organizationMemberIdBeingRemoved = $userId;
    }

    /**
     * Remove a organization member from the organization.
     *
     * @param  \App\Actions\Jetstream\RemoveOrganizationMember  $remover
     * @return void
     */
    public function removeOrganizationMember(RemoveOrganizationMember $remover)
    {
        if($this->organizationMemberIdBeingRemoved)
        {
            $remover->remove(
                $this->user,
                $this->organization,
                Jetstream::findUserByIdOrFail($this->organizationMemberIdBeingRemoved)
            );

            $this->confirmingOrganizationMemberRemoval = false;

            $this->organizationMemberIdBeingRemoved = null;

            $this->organization = $this->organization->fresh();
        }
    }

    /**
     * Get the available organization member roles.
     *
     * @return array
     */
    public function getRolesProperty()
    {
        return collect(Jetstream::$roles)->transform(function ($role) {
            return with($role->jsonSerialize(), function ($data) {
                return (new Role(
                    $data['key'],
                    $data['name'],
                    $data['permissions']
                ))->description($data['description']);
            });
        })->values()->all();
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('organizations.organization-member-manager');
    }
}
