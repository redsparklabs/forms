<div>
    <div class="space-y-6">
        <!-- Add Team Member -->
        @can('inviteMembers', $team)
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Add Team Member') }}</h3>
                    <form wire:submit.prevent="addTeamMember">
                        <div class="mt-5">
                            <div class="flex space-x-4">
                                <div class="flex-1">
                                    <label for="email" class="sr-only">{{ __('Email address') }}</label>
                                    <input
                                        wire:model.defer="email"
                                        type="email"
                                        id="email"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        placeholder="{{ __('Email address') }}"
                                        required
                                    >
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="role" class="sr-only">{{ __('Role') }}</label>
                                    <select
                                        wire:model.defer="role"
                                        id="role"
                                        class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                        required
                                    >
                                        <option value="{{ \App\Models\TeamMember::ROLE_MEMBER }}">
                                            {{ __('Member') }}
                                        </option>
                                        <option value="{{ \App\Models\TeamMember::ROLE_LEAD }}">
                                            {{ __('Lead') }}
                                        </option>
                                    </select>
                                </div>
                                <button
                                    type="submit"
                                    wire:loading.attr="disabled"
                                    class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                >
                                    <span wire:loading.remove>{{ __('Add') }}</span>
                                    <span wire:loading>{{ __('Sending...') }}</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endcan

        <!-- Team Member List -->
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Team Members') }}</h3>
            </div>
            <div class="border-t border-gray-200">
                <ul role="list" class="divide-y divide-gray-200">
                    @forelse($teamMembers as $member)
                        <li class="flex items-center justify-between px-6 py-4">
                            <div class="flex items-center">
                                <img class="h-10 w-10 rounded-full" src="{{ $member->profile_photo_url }}" alt="">
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $member->name }}
                                        @if($member->id === $team->owner_id)
                                            <span class="ml-2 inline-flex items-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-medium text-indigo-800">
                                                {{ __('Owner') }}
                                            </span>
                                        @else
                                            <span class="ml-2 inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                                                {{ ucfirst($member->pivot->role) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $member->email }}</div>
                                </div>
                            </div>
                            
                            @if(auth()->user()->can('updateMemberRole', [$team, $member]) && $member->id !== $team->owner_id)
                                <div class="flex items-center space-x-4">
                                    <select
                                        wire:model.defer="newRole"
                                        wire:change="updateRole({{ $member->id }}, $event.target.value)"
                                        class="rounded-md border-gray-300 py-1 pl-2 pr-8 text-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500"
                                    >
                                        <option value="{{ \App\Models\TeamMember::ROLE_MEMBER }}" {{ $member->pivot->role === \App\Models\TeamMember::ROLE_MEMBER ? 'selected' : '' }}>
                                            {{ __('Member') }}
                                        </option>
                                        <option value="{{ \App\Models\TeamMember::ROLE_LEAD }}" {{ $member->pivot->role === \App\Models\TeamMember::ROLE_LEAD ? 'selected' : '' }}>
                                            {{ __('Lead') }}
                                        </option>
                                        @if(auth()->user()->can('updateMemberRole', [$team, $member, \App\Models\TeamMember::ROLE_OWNER]))
                                            <option value="{{ \App\Models\TeamMember::ROLE_OWNER }}" {{ $member->pivot->role === \App\Models\TeamMember::ROLE_OWNER ? 'selected' : '' }}>
                                                {{ __('Owner') }}
                                            </option>
                                        @endif
                                    </select>
                                    
                                    @if(auth()->user()->can('removeMember', [$team, $member]) && $member->id !== $team->owner_id)
                                        <button
                                            type="button"
                                            wire:click="confirmTeamMemberRemoval({{ $member->id }})"
                                            class="text-red-600 hover:text-red-900 text-sm font-medium"
                                        >
                                            {{ __('Remove') }}
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </li>
                    @empty
                        <li class="px-6 py-4 text-sm text-gray-500">
                            {{ __('No team members found.') }}
                        </li>
                    @endforelse
                </ul>
                {{ $teamMembers->links() }}
            </div>
        </div>

        <!-- Pending Invitations -->
        @if($pendingInvitations->isNotEmpty())
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ __('Pending Invitations') }}</h3>
                </div>
                <div class="border-t border-gray-200">
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach($pendingInvitations as $invitation)
                            <li class="flex items-center justify-between px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 12a5 5 0 110-10 5 5 0 010 10zm0-2a3 3 0 100-6 3 3 0 000 6zm0 13a7.5 7.5 0 110-15 7.5 7.5 0 010 15zm0-2a5.5 5.5 0 100-11 5.5 5.5 0 000 11z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $invitation->pivot->email }}
                                            <span class="ml-2 inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">
                                                {{ ucfirst($invitation->pivot->role) }}
                                            </span>
                                            <span class="ml-2 inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">
                                                {{ __('Pending') }}
                                            </span>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ __('Invitation sent') }} {{ $invitation->pivot->invitation_sent_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                                @can('manageMembers', $team)
                                    <div class="flex space-x-4">
                                        <button
                                            type="button"
                                            wire:click="resendInvitation({{ $invitation->pivot->id }})"
                                            class="text-indigo-600 hover:text-indigo-900 text-sm font-medium"
                                        >
                                            {{ __('Resend') }}
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="cancelInvitation({{ $invitation->pivot->id }})"
                                            class="text-red-600 hover:text-red-900 text-sm font-medium"
                                        >
                                            {{ __('Cancel') }}
                                        </button>
                                    </div>
                                @endcan
                            </li>
                        @endforeach
                    </ul>
                    {{ $pendingInvitations->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Remove Team Member Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingTeamMemberRemoval">
        <x-slot name="title">
            {{ __('Remove Team Member') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to remove this person from the team?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingTeamMemberRemoval')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="removeTeamMember" wire:loading.attr="disabled">
                {{ __('Remove') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
