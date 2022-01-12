<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function view(User $user, Organization $organization)
    {
        return $user->belongsToOrganization($organization);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function update(User $user, Organization $organization)
    {
        return $user->ownsOrganization($organization);
    }

    /**
     * Determine whether the user can add organization members.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function addOrganizationMember(User $user, Organization $organization)
    {
        return $user->ownsOrganization($organization);
    }

    /**
     * Determine whether the user can update organization member permissions.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function updateOrganizationMember(User $user, Organization $organization)
    {
        return $user->ownsOrganization($organization);
    }

    /**
     * Determine whether the user can remove organization members.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function removeOrganizationMember(User $user, Organization $organization)
    {
        return $user->ownsOrganization($organization);
    }

    /**
     * Determine whether the user can view the team.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function viewTeam(User $user, Organization $organization)
    {
        return $user->ownsOrganization($organization);
    }

    /**
     * Determine whether the user can add organization members.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function addTeam(User $user, Organization $organization)
    {
        return $user->ownsOrganization($organization);
    }

    /**
     * Determine whether the user can update organization member permissions.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function updateTeam(User $user, Organization $organization)
    {
        return $user->ownsOrganization($organization);
    }

    /**
     * Determine whether the user can remove organization members.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function removeTeam(User $user, Organization $organization)
    {
        return $user->ownsOrganization($organization);
    }

    /**
     * Determine whether the user can view the team.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function viewEvent(User $user, Organization $organization)
    {
        return $user->ownsOrganization($organization);
    }


    /**
     * Determine whether the user can add organization members.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function addEvent(User $user, Organization $organization)
    {
        return $user->ownsOrganization($organization);
    }

    /**
     * Determine whether the user can update organization member permissions.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function updateEvent(User $user, Organization $organization)
    {
        return $user->ownsOrganization($organization);
    }

    /**
     * Determine whether the user can remove organization members.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function removeEvent(User $user, Organization $organization)
    {
        return $user->ownsOrganization($organization);
    }
    /**
     * Determine whether the user can view the team.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function viewForm(User $user, Organization $organization)
    {
        return $user->ownsOrganization($organization);
    }

    /**
     * Determine whether the user can add organization members.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function addForm(User $user, Organization $organization)
    {
        return $user->ownsOrganization($organization);
    }

    /**
     * Determine whether the user can update organization member permissions.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function updateForm(User $user, Organization $organization)
    {
        return $user->ownsOrganization($organization);
    }

    /**
     * Determine whether the user can remove organization members.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function removeForm(User $user, Organization $organization)
    {
        return $user->ownsOrganization($organization);
    }
    /**
     * Determine whether the user can view the team.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function viewQuestion(User $user, Organization $organization)
    {
        return $user->ownsOrganization($organization);
    }

    /**
     * Determine whether the user can add organization members.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function addQuestion(User $user, Organization $organization)
    {
        return $user->ownsOrganization($organization);
    }

    /**
     * Determine whether the user can update organization member permissions.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function updateQuestion(User $user, Organization $organization)
    {
        return $user->ownsOrganization($organization);
    }

    /**
     * Determine whether the user can remove organization members.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function removeQuestion(User $user, Organization $organization)
    {
        return $user->ownsOrganization($organization);
    }
    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Organization  $organization
     * @return mixed
     */
    public function delete(User $user, Organization $organization)
    {
        return $user->ownsOrganization($organization);
    }
}
