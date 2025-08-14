<?php

namespace App\Http\Livewire;

use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class TeamMemberManager extends Component
{
    use WithPagination;

    /**
     * The team instance.
     *
     * @var \App\Models\Team
     */
    public $team;

    /**
     * The email address of the user to invite.
     *
     * @var string
     */
    public $email = '';

    /**
     * The role to assign to the invited user.
     *
     * @var string
     */
    public $role = TeamMember::ROLE_MEMBER;

    /**
     * Indicates if the application is confirming if a team member should be removed.
     *
     * @var bool
     */
    public $confirmingTeamMemberRemoval = false;

    /**
     * The ID of the team member being removed.
     *
     * @var int|null
     */
    public $teamMemberIdBeingRemoved = null;

    /**
     * The ID of the team member whose role is being updated.
     *
     * @var int|null
     */
    public $updatingTeamMemberRole = null;

    /**
     * The new role for the team member.
     *
     * @var string|null
     */
    public $newRole = null;

    /**
     * Mount the component.
     *
     * @param  \App\Models\Team  $team
     * @return void
     */
    public function mount(Team $team)
    {
        $this->team = $team;
    }

    /**
     * Add a new team member.
     *
     * @return void
     */
    /**
     * Add a new team member.
     *
     * @return void
     */
    public function addTeamMember()
    {
        $this->resetErrorBag();
        
        // Log method entry with current state
        \Log::debug('TeamMemberManager@addTeamMember - Starting', [
            'email' => $this->email ?? 'null',
            'role' => $this->role ?? 'null',
            'team_id' => $this->team->id ?? 'null',
            'auth_user_id' => auth()->id() ?? 'null'
        ]);
        
        try {
            // Validate the request
            $validated = $this->validate([
                'email' => ['required', 'email', 'max:255'],
                'role' => ['required', 'string', 'in:lead,member'],
            ]);
            
            // Log successful validation
            \Log::debug('TeamMemberManager@addTeamMember - Validation passed', [
                'validated_email' => $validated['email'],
                'validated_role' => $validated['role'],
                'auth_user' => auth()->id(),
            ]);
            
            // Check if the user is authorized to add team members
            if (!auth()->user() || !auth()->user()->can('inviteMembers', $this->team)) {
                throw new \Exception('You are not authorized to invite team members.');
            }

            // Log before checking for existing member
            \Log::debug('TeamMemberManager@addTeamMember - Checking for existing member', [
                'email' => $validated['email'],
                'team_id' => $this->team->id,
            ]);
            
            // Check if the email is already a member or invited
            $existingMember = TeamMember::where('team_id', $this->team->id)
                ->where(function($query) use ($validated) {
                    // Check if email exists in the pivot table
                    $query->where('email', $validated['email']);
                    
                    // Also check if a user with this email is already a member
                    $user = User::where('email', $validated['email'])->first();
                    if ($user) {
                        $query->orWhere('user_id', $user->id);
                    }
                })
                ->first();
                
            // Log the result of the existing member check
            \Log::debug('TeamMemberManager@addTeamMember - Existing member check', [
                'email' => $validated['email'],
                'existing_member_found' => $existingMember ? true : false,
                'existing_status' => $existingMember->status ?? 'n/a',
            ]);

            if ($existingMember) {
                if ($existingMember->status === TeamMember::STATUS_ACTIVE) {
                    throw new \Exception('This user is already a member of the team.');
                }
                
                // Log before updating existing invitation
                \Log::debug('TeamMemberManager@addTeamMember - Updating existing invitation', [
                    'email' => $validated['email'],
                    'existing_status' => $existingMember->status,
                    'new_role' => $validated['role']
                ]);
                
                // Resend invitation if it's pending
                $existingMember->update([
                    'invitation_token' => Str::random(40),
                    'invitation_sent_at' => now(),
                    'role' => $validated['role']
                ]);
                
                $invitation = $existingMember;
                
                // Log after updating invitation
                \Log::debug('TeamMemberManager@addTeamMember - Updated existing invitation', [
                    'email' => $validated['email'],
                    'invitation_id' => $invitation->id,
                    'new_token' => $invitation->invitation_token
                ]);
            } else {
                // Log before creating new invitation
                \Log::debug('TeamMemberManager@addTeamMember - Creating new invitation', [
                    'email' => $validated['email'],
                    'role' => $validated['role'],
                    'team_id' => $this->team->id
                ]);
                
                // Create new invitation directly in the pivot table
                $invitation = TeamMember::create([
                    'team_id' => $this->team->id,
                    'user_id' => null, // Will be set later when user is created or accepts
                    'email' => $validated['email'],
                    'role' => $validated['role'],
                    'invitation_token' => Str::random(40),
                    'invitation_sent_at' => now(),
                    'status' => TeamMember::STATUS_INVITED
                ]);
                
                // Log after creating invitation
                \Log::debug('TeamMemberManager@addTeamMember - Created new invitation', [
                    'email' => $validated['email'],
                    'invitation_id' => $invitation->id,
                    'invitation_token' => $invitation->invitation_token
                ]);
            }

            // Check if user exists
            $user = User::where('email', $validated['email'])->first();
            
            if ($user) {
                // Log before sending notification to existing user
                \Log::debug('TeamMemberManager@addTeamMember - Sending invitation to existing user', [
                    'user_id' => $user->id,
                    'email' => $validated['email'],
                    'invitation_id' => $invitation->id
                ]);
                
                // User exists, send them the invitation directly
                $user->notify(new \App\Notifications\TeamInvitationNotification($this->team, $invitation->invitation_token));
                
                // Log after sending notification
                \Log::debug('TeamMemberManager@addTeamMember - Sent invitation to existing user', [
                    'user_id' => $user->id,
                    'email' => $validated['email']
                ]);
            } else {
                // Log before creating new user
                $name = explode('@', $validated['email'])[0]; // Use the part before @ as name
                \Log::debug('TeamMemberManager@addTeamMember - Creating new user', [
                    'email' => $validated['email'],
                    'generated_name' => $name,
                    'name_empty' => empty($name),
                    'email_empty' => empty($validated['email'])
                ]);
                
                // For non-users, create a temporary user with a default name
                
                try {
                    $name = trim($name); // Ensure no whitespace issues
                    $email = $validated['email'];
                    
                    // Debug log the data we're about to use
                    \Log::debug('TeamMemberManager@addTeamMember - Attempting to create user', [
                        'name' => $name,
                        'email' => $email,
                        'name_empty' => empty($name),
                        'email_empty' => empty($email),
                        'name_length' => strlen($name),
                        'email_length' => strlen($email)
                    ]);
                    
                    if (empty($name)) {
                        $error = 'Name cannot be empty';
                        \Log::error('TeamMemberManager@addTeamMember - ' . $error, [
                            'email' => $email,
                            'name' => $name
                        ]);
                        throw new \Exception($error);
                    }
                    
                    if (empty($email)) {
                        $error = 'Email cannot be empty';
                        \Log::error('TeamMemberManager@addTeamMember - ' . $error, [
                            'name' => $name
                        ]);
                        throw new \Exception($error);
                    }
                    
                    // Prepare user data with proper name handling
                    $tempPassword = Str::random(32);
                    $name = trim($name); // Ensure no whitespace issues
                    
                    if (empty($name)) {
                        // If name is still empty, use the part before @ in email as fallback
                        $name = explode('@', $email)[0];
                        $name = ucfirst($name); // Capitalize first letter for better UX
                    }
                    
                    // Ensure we have a valid name
                    if (empty($name)) {
                        $name = 'User ' . substr(md5($email), 0, 8); // Fallback name
                    }
                    
                    // Create a properly formatted input array that matches what CreateNewUser expects
                    $input = [
                        'name' => $name,
                        'email' => $email,
                        'password' => $tempPassword,
                        'password_confirmation' => $tempPassword,
                        'terms' => true, // Assume terms are accepted for invited users
                    ];

                    // Log the data before calling CreateNewUser
                    \Log::debug('TeamMemberManager@addTeamMember - Calling CreateNewUser with data:', [
                        'name' => $input['name'],
                        'email' => $input['email'],
                        'has_password' => !empty($input['password']),
                        'has_password_confirmation' => !empty($input['password_confirmation']),
                        'terms_accepted' => $input['terms'] ?? false,
                        'input_structure' => gettype($input),
                        'input_count' => count($input),
                    ]);

                    try {
                        // Use the CreateNewUser action to properly create the user
                        $createNewUser = new \App\Actions\Fortify\CreateNewUser();
                        
                        // Log right before calling create
                        \Log::debug('TeamMemberManager@addTeamMember - About to call CreateNewUser->create()', [
                            'name' => $input['name'],
                            'email' => $input['email'],
                            'has_password' => !empty($input['password']),
                            'has_password_confirmation' => !empty($input['password_confirmation']),
                            'has_terms' => !empty($input['terms'])
                        ]);
                        
                        // Create the user using the CreateNewUser action
                        $user = $createNewUser->create($input);
                        
                        if (!$user) {
                            $error = 'CreateNewUser returned null';
                            \Log::error('TeamMemberManager@addTeamMember - ' . $error, [
                                'email' => $email,
                                'user_data' => $userData
                            ]);
                            throw new \Exception($error);
                        }
                        
                        // Log successful user creation
                        \Log::debug('TeamMemberManager@addTeamMember - Successfully created user', [
                            'user_id' => $user->id,
                            'email' => $user->email,
                            'name' => $user->name,
                            'attributes' => $user->getAttributes()
                        ]);
                    } catch (\Exception $e) {
                        \Log::error('TeamMemberManager@addTeamMember - Exception in CreateNewUser', [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString(),
                            'data' => $userData
                        ]);
                        throw $e;
                    }
                    
                    \Log::info('User created successfully', [
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'created_at' => $user->created_at,
                    ]);
                    
                    try {
                        // Log before sending invitation
                        \Log::debug('TeamMemberManager@addTeamMember - Sending invitation to new user', [
                            'user_id' => $user->id,
                            'email' => $user->email,
                            'invitation_id' => $invitation->id,
                            'team_id' => $this->team->id,
                            'user_attributes' => $user->getAttributes()
                        ]);
                        
                        // Update the invitation with the user ID first
                        $invitation->update([
                            'user_id' => $user->id
                        ]);
                        
                        // Send invitation to the new user
                        $user->notify(new \App\Notifications\TeamInvitationNotification($this->team, $invitation->invitation_token));
                        
                        // Log successful invitation
                        \Log::info('TeamMemberManager@addTeamMember - Invitation sent to new user', [
                            'user_id' => $user->id,
                            'email' => $user->email,
                            'invitation_id' => $invitation->id,
                            'team_id' => $this->team->id
                        ]);
                    } catch (\Exception $e) {
                        // Log the error but don't fail the entire process
                        \Log::error('TeamMemberManager@addTeamMember - Failed to send invitation', [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString(),
                            'user_id' => $user->id ?? null,
                            'email' => $user->email ?? null,
                            'invitation_id' => $invitation->id ?? null
                        ]);
                        
                        // Re-throw the exception to be handled by the outer try-catch
                        throw $e;
                    }
                    
                } catch (\Exception $e) {
                    \Log::error('Error creating user or sending invitation: ' . $e->getMessage(), [
                        'email' => $validated['email'],
                        'trace' => $e->getTraceAsString()
                    ]);
                    throw $e; // Re-throw to be caught by the outer try-catch
                }
            }

            // Reset the form
            $this->reset(['email', 'role']);
            
            // Show success message
            session()->flash('status', 'Invitation sent successfully.');
            
            // Refresh the component to show the updated list
            $this->emit('refreshTeamMembers');
            
        } catch (\Exception $e) {
            $this->addError('email', $e->getMessage());
            \Log::error('Error in addTeamMember: ' . $e->getMessage());
        }
    }

    /**
     * Cancel a pending team member invitation.
     *
     * @param  int  $invitationId
     * @return void
     */
    public function cancelTeamInvitation($invitationId)
    {
        if (!Auth::user() || !Auth::user()->can('manageMembers', $this->team)) {
            abort(403);
        }

        $invitation = $this->team->pendingInvitations()
            ->where('id', $invitationId)
            ->firstOrFail();

        $invitation->delete();
    }

    /**
     * Confirm that the given team member should be removed.
     *
     * @param  int  $userId
     * @return void
     */
    public function confirmTeamMemberRemoval($userId)
    {
        $this->confirmingTeamMemberRemoval = true;
        $this->teamMemberIdBeingRemoved = $userId;
    }

    /**
     * Remove a team member from the team.
     *
     * @param  int  $userId
     * @return void
     */
    public function removeTeamMember($userId)
    {
        if (!Auth::user() || !Auth::user()->can('removeMember', [$this->team, User::findOrFail($userId)])) {
            abort(403);
        }

        $this->team->members()->detach($userId);

        $this->confirmingTeamMemberRemoval = false;
        $this->teamMemberIdBeingRemoved = null;
    }

    /**
     * Update the given team member's role.
     *
     * @param  int  $userId
     * @param  string  $role
     * @return void
     */
    public function updateRole($userId, $role)
    {
        $user = User::findOrFail($userId);
        
        if (!Auth::user() || !Auth::user()->can('updateMemberRole', [$this->team, $user])) {
            abort(403);
        }

        $this->team->members()->updateExistingPivot($userId, [
            'role' => $role,
        ]);

        $this->updatingTeamMemberRole = null;
    }

    /**
     * Get the current user of the application.
     *
     * @return \App\Models\User
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
        // Debug log to check team and user info
        \Log::debug('TeamMemberManager render', [
            'user_id' => auth()->id(),
            'team_id' => $this->team->id,
            'team_name' => $this->team->name,
            'can_invite' => auth()->user()->can('inviteMembers', $this->team),
            'can_manage' => auth()->user()->can('manageMembers', $this->team)
        ]);

        return view('livewire.team-member-manager', [
            'teamMembers' => $this->team->members()
                ->wherePivot('status', TeamMember::STATUS_ACTIVE)
                ->orderBy('name')
                ->paginate(10, ['*'], 'teamMembersPage'),
            'pendingInvitations' => $this->team->pendingInvitations()
                ->orderBy('created_at', 'desc')
                ->paginate(10, ['*'], 'pendingInvitationsPage'),
        ]);
    }
}
