<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
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
        return true; // All authenticated users can view teams
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Team  $team
     * @return mixed
     */
    public function view(User $user, Team $team)
    {
        // Organization admins can view any team in their organization
        if ($user->hasOrganizationRole($team->organization, 'admin')) {
            return true;
        }
        
        // Team members can view their team
        return $user->isMemberOf($team);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // Any authenticated user can create a team
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Team  $team
     * @return mixed
     */
    public function update(User $user, Team $team)
    {
        // Organization admins can update any team in their organization
        if ($user->hasOrganizationRole($team->organization, 'admin')) {
            return true;
        }
        
        // Only team owners and leads can update the team
        return $user->hasTeamRole($team, TeamMember::ROLE_OWNER) || 
               $user->hasTeamRole($team, TeamMember::ROLE_LEAD);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Team  $team
     * @return mixed
     */
    public function delete(User $user, Team $team)
    {
        // Only organization admins can delete teams
        return $user->hasOrganizationRole($team->organization, 'admin');
    }

    /**
     * Determine whether the user can view team members.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Team  $team
     * @return mixed
     */
    public function viewMembers(User $user, Team $team)
    {
        // Organization admins can view members of any team in their organization
        if ($user->hasOrganizationRole($team->organization, 'admin')) {
            return true;
        }
        
        // All team members can view the member list
        return $user->isMemberOf($team);
    }

    /**
     * Determine whether the user can manage team members.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Team  $team
     * @return mixed
     */
    public function manageMembers(User $user, Team $team)
    {
        // Load the organization relationship if not already loaded
        if (!$team->relationLoaded('organization')) {
            $team->load('organization');
        }

        // Check if the organization is properly loaded
        if (!$team->organization) {
            \Log::error('Organization not loaded for team', [
                'team_id' => $team->id,
                'team_name' => $team->name
            ]);
            return false;
        }

        // Organization admins can manage members of any team in their organization
        if ($user->hasOrganizationRole($team->organization, 'admin')) {
            \Log::debug('User is organization admin', [
                'user_id' => $user->id,
                'organization_id' => $team->organization->id,
                'organization_name' => $team->organization->name
            ]);
            return true;
        }
        
        // Check team roles
        $isOwner = $user->hasTeamRole($team, TeamMember::ROLE_OWNER);
        $isLead = $user->hasTeamRole($team, TeamMember::ROLE_LEAD);
        
        \Log::debug('Team role check', [
            'user_id' => $user->id,
            'team_id' => $team->id,
            'is_owner' => $isOwner,
            'is_lead' => $isLead
        ]);
        
        // Team owners and leads can manage team members
        return $isOwner || $isLead;
    }

    /**
     * Determine whether the user can invite team members.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Team  $team
     * @return mixed
     */
    public function inviteMembers(User $user, Team $team)
    {
        $result = $this->manageMembers($user, $team);
        
        \Log::debug('inviteMembers check', [
            'user_id' => $user->id,
            'team_id' => $team->id,
            'has_permission' => $result,
            'method' => __METHOD__
        ]);
        
        return $result;
    }

    /**
     * Determine whether the user can remove team members.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Team  $team
     * @param  \App\Models\User  $member
     * @return mixed
     */
    public function removeMember(User $user, Team $team, User $member)
    {
        // Organization admins can remove any member from any team in their organization
        if ($user->hasOrganizationRole($team->organization, 'admin')) {
            return true;
        }

        // Users can't remove themselves
        if ($user->is($member)) {
            return false;
        }

        // Team owners can remove any member
        if ($user->hasTeamRole($team, TeamMember::ROLE_OWNER)) {
            return true;
        }

        // Team leads can only remove members (not other leads or owners)
        if ($user->hasTeamRole($team, TeamMember::ROLE_LEAD)) {
            return !$member->hasTeamRole($team, TeamMember::ROLE_OWNER) && 
                   !$member->hasTeamRole($team, TeamMember::ROLE_LEAD);
        }

        return false;
    }

    /**
     * Determine whether the user can update team member roles.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Team  $team
     * @param  \App\Models\User  $member
     * @param  string  $role
     * @return mixed
     */
    public function updateMemberRole(User $user, Team $team, User $member, string $role)
    {
        // Organization admins can update any member's role
        if ($user->hasOrganizationRole($team->organization, 'admin')) {
            return true;
        }

        // Users can't change their own role
        if ($user->is($member)) {
            return false;
        }

        // Only team owners can promote members to lead or owner
        if (in_array($role, [TeamMember::ROLE_OWNER, TeamMember::ROLE_LEAD])) {
            return $user->hasTeamRole($team, TeamMember::ROLE_OWNER);
        }

        // Team owners can demote members to regular members
        if ($role === TeamMember::ROLE_MEMBER) {
            return $user->hasTeamRole($team, TeamMember::ROLE_OWNER);
        }

        return false;
    }
}
