<div>
    @if (Gate::check('addTeam', $organization))
        <x-jet-section-border />

        <!-- Add Organization -->
        <div class="mt-10 sm:mt-0">
            <x-jet-form-section submit="create">
                <x-slot name="title">
                    {{ __('Add Team') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Add a new team to your organization.') }}
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6">
                        <div class="max-w-xl text-sm text-gray-600">
                            {{ __('Please provide the name of the team you would like to add to this organization.') }}
                        </div>
                    </div>

                    <!-- Team Name -->
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="name" value="{{ __('Team Name') }}" />
                        <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.defer="createForm.name" />
                        <x-jet-input-error for="name" class="mt-2" />
                    </div>

                </x-slot>

                <x-slot name="actions">
                    <x-jet-action-message class="mr-3" on="created">
                        {{ __('Added.') }}
                    </x-jet-action-message>

                    <x-jet-button spinner="create">
                        {{ __('Add') }}
                    </x-jet-button>
                </x-slot>
            </x-jet-form-section>
        </div>


    @endif

    @if ($organization->teams->isNotEmpty())
        <x-jet-section-border />
        <!-- Manage Organizations -->
        <div class="mt-10 sm:mt-0">
            <x-jet-action-section>
                <x-slot name="title">
                    {{ __('Teams') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('All of the teams that are part of this organization.') }}
                </x-slot>

                <!-- Organization Organization List -->
                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($organization->teams->sortBy('name') as $team)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img class="w-8 h-8 rounded-full" src="{{ $team->team_image }}" alt="{{ $team->name }}">
                                    <div class="ml-4">{{ $team->name }}</div>
                                </div>

                                <div class="flex items-center">

                                    <!-- Remove Organization -->
                                     @if (Gate::check('updateTeam', $team))
                                        <button class="ml-6 text-sm text-blue-500 cursor-pointer focus:outline-none" wire:click="confirmUpdate('{{ $team->id }}')">
                                            {{ __('Update') }}
                                        </button>
                                    @endif

                                    @if (Gate::check('removeTeam', $team))
                                        <button class="ml-6 text-sm text-red-500 cursor-pointer focus:outline-none" wire:click="confirmDestroy('{{ $team->id }}')">
                                            {{ __('Remove') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-jet-action-section>
        </div>

    @endif

    <!-- Uodate Club Confirmation Modal -->
    <x-jet-dialog-modal wire:model="confirmingUpdating">
        <x-slot name="title">
            {{ __('Update Organization') }}
        </x-slot>

        <x-slot name="content">
            <!-- Team Name -->
            <x-jet-label for="name" value="{{ __('Team Name') }}" />
            <x-jet-input id="name" type="text" class="block w-full mt-1" model="updateForm.name" wire:model.defer="updateForm.name" />
            <x-jet-input-error for="name" class="mt-2" />
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingUpdating')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="update" spinner="update">
                {{ __('Update') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Remove Club Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingDestroying">
        <x-slot name="title">
            {{ __('Remove Team') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to remove this team from the organization?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingDestroying')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="destroy" spinner="destroy">
                {{ __('Remove') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
