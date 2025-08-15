<?php

namespace App\Actions\Fortify;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use App\Actions\CreateForm;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        \Log::debug('CreateNewUser - Input data:', [
            'input' => $input,
            'has_name' => isset($input['name']),
            'name_value' => $input['name'] ?? null,
            'has_email' => isset($input['email']),
            'has_password' => isset($input['password']),
            'has_invitation' => isset($input['invitation_token']),
        ]);
        
        // Make password optional if this is an invitation
        $isInvitation = !empty($input['invitation_token']);
        
        $rules = [
            'name' => ['nullable', 'string', 'max:255'],
            'email' => $isInvitation 
                ? ['required', 'string', 'email', 'max:255'] // Allow existing emails for invitations
                : ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $isInvitation ? ['nullable'] : $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() && !$isInvitation 
                ? ['required', 'accepted'] 
                : ['sometimes'],
        ];
        
        $validator = Validator::make($input, $rules);
        
        if ($validator->fails()) {
            \Log::error('CreateNewUser - Validation failed:', [
                'errors' => $validator->errors()->toArray(),
                'input' => $input,
                'rules' => $rules
            ]);
            $validator->validate();
        }

        return DB::transaction(function () use ($input) {
            // Log the input data we're about to use
            \Log::debug('CreateNewUser - Transaction started', [
                'input_keys' => array_keys($input),
                'name_present' => isset($input['name']),
                'name_value' => $input['name'] ?? null,
                'email_present' => isset($input['email']),
                'password_present' => isset($input['password']),
            ]);

            // Ensure name is set - use email prefix if not provided
            $name = $input['name'] ?? '';
            if (empty($name) && !empty($input['email'])) {
                $name = explode('@', $input['email'])[0];
                $name = ucfirst(str_replace(['.', '_', '-'], ' ', $name));
                $name = trim($name);
                if (empty($name)) {
                    $name = 'User';
                }
            } elseif (empty($name)) {
                $name = 'User';
            }

            // Create user data array with explicit type casting and validation
            $userData = [
                'name' => (string)$name,
                'email' => (string)($input['email'] ?? ''),
                'password' => isset($input['password']) && !empty($input['password']) 
                    ? Hash::make((string)$input['password'])
                    : Hash::make(Str::random(32)),
                'password_confirmation' => $input['password_confirmation'] ?? null,
            ];
            
            // Ensure we have a valid password
            if (empty($userData['password'])) {
                $userData['password'] = Hash::make(Str::random(32));
            }
            
            // Log the data before user creation
            \Log::debug('CreateNewUser - User data before creation:', [
                'userData' => $userData,
                'name_empty' => empty($userData['name']),
                'name_length' => strlen($userData['name']),
                'email_empty' => empty($userData['email']),
                'password_empty' => empty($userData['password']),
                'input_has_name' => isset($input['name']),
                'input_name_value' => $input['name'] ?? 'NOT SET',
            ]);
            
            // Log before creating user
            \Log::debug('CreateNewUser - Creating user with data:', [
                'name' => $userData['name'],
                'email' => $userData['email'],
                'has_password' => !empty($userData['password']),
                'fillable' => (new User())->getFillable(),
                'guarded' => (new User())->getGuarded(),
            ]);
            
            try {
                // Check if this is an invitation and user already exists
                $isInvitation = !empty($input['invitation_token']);
                if ($isInvitation) {
                    $existingUser = User::where('email', $userData['email'])->first();
                    if ($existingUser) {
                        // Update existing user with new name and password
                        $existingUser->update([
                            'name' => $userData['name'],
                            'password' => $userData['password']
                        ]);
                        $user = $existingUser;
                        
                        // Log after updating
                        \Log::debug('CreateNewUser - Updated existing user for invitation', [
                            'user_id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'updated' => true,
                        ]);
                    } else {
                        // Create new user for invitation
                        $user = User::create([
                            'name' => $userData['name'],
                            'email' => $userData['email'],
                            'password' => $userData['password']
                        ]);
                        
                        // Log after creating
                        \Log::debug('CreateNewUser - Created new user for invitation', [
                            'user_id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'wasRecentlyCreated' => $user->wasRecentlyCreated,
                        ]);
                    }
                } else {
                    // Regular registration - create new user
                    $user = User::create([
                        'name' => $userData['name'],
                        'email' => $userData['email'],
                        'password' => $userData['password']
                    ]);
                    
                    // Log after creating
                    \Log::debug('CreateNewUser - User created successfully', [
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'wasRecentlyCreated' => $user->wasRecentlyCreated,
                        'exists' => $user->exists,
                    ]);
                }
            } catch (\Exception $e) {
                \Log::error('CreateNewUser - Exception during user save', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'user_data' => $userData,
                    'user_attributes' => isset($user) ? $user->getAttributes() : 'User not created',
                ]);
                throw $e;
            }
            
            // Log successful user creation
            \Log::debug('CreateNewUser - User saved successfully', [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'attributes' => $user->getAttributes(),
                'wasRecentlyCreated' => $user->wasRecentlyCreated,
            ]);
            
            // Handle team invitation if token is provided
            if (!empty($input['invitation_token'])) {
                try {
                    $teamId = $this->processInvitation($user, $input['invitation_token']);
                    
                    // Store the team ID in session for redirect after registration
                    session(['invitation_redirect_team_id' => $teamId]);
                    
                    \Log::info('Invitation processed successfully during registration - NO organization created', [
                        'user_id' => $user->id,
                        'team_id' => $teamId,
                        'invitation_token' => $input['invitation_token'],
                    ]);
                    
                } catch (\Exception $e) {
                    \Log::error('Failed to process invitation during registration', [
                        'error' => $e->getMessage(),
                        'user_id' => $user->id,
                        'invitation_token' => $input['invitation_token'],
                    ]);
                    // Even if invitation processing fails, DO NOT create an organization
                    // The user was invited to join a team, not to create their own organization
                }
                
                // IMPORTANT: Invited users should NEVER get an organization created
                // They are joining an existing team, not creating their own workspace
            } else {
                // Only create organization if this is a regular registration (no invitation)
                $this->createOrganization($user);
            }
            
            // Return the created user
            return $user->fresh();
        });
    }

    /**
     * Create a personal team for the user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function createOrganization(User $user)
    {
        $user->ownedOrganizations()->save(Organization::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0] . "'s Organization",
            'personal_organization' => true,
        ]));
    }
    
    /**
     * Process a team invitation for the given user.
     *
     * @param  \App\Models\User  $user
     * @param  string  $token
     * @return void
     * @throws \Exception
     */
    protected function processInvitation(User $user, string $token)
    {
        $invitation = \App\Models\TeamMember::where('invitation_token', $token)
            ->where('invitation_sent_at', '>=', now()->subDays(7))
            ->first();
            
        if (!$invitation) {
            throw new \Exception('Invalid or expired invitation token');
        }
        
        // Update the invitation to mark it as accepted
        $invitation->update([
            'user_id' => $user->id,
            'status' => \App\Models\TeamMember::STATUS_ACTIVE,
            'invitation_token' => null,
            'invitation_sent_at' => null,
        ]);
        
        // Log the successful invitation acceptance
        \Log::info('User accepted team invitation during registration', [
            'user_id' => $user->id,
            'team_id' => $invitation->team_id,
            'invitation_id' => $invitation->id,
        ]);
        
        // Return the team ID for redirect purposes
        return $invitation->team_id;
    }
}
