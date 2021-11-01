<div>
    @if (Gate::check('addClub', $team))
        <x-jet-section-border />

        <!-- Add Team -->
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
                        <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="createForm.name" />
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

    @if ($team->clubs->isNotEmpty())
        <x-jet-section-border />
        <!-- Manage Teams -->
        <div class="mt-10 sm:mt-0">
            <x-jet-action-section>
                <x-slot name="title">
                    {{ __('Teams') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('All of the teams that are part of this organization.') }}
                </x-slot>

                <!-- Organization Team List -->
                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($team->clubs->sortBy('name') as $club)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img class="w-8 h-8 rounded-full" src="{{ $club->club_image }}" alt="{{ $club->name }}">
                                    <div class="ml-4">{{ $club->name }}</div>
                                </div>

                                <div class="flex items-center">

                                    <!-- Remove Team -->
                                     @if (Gate::check('updateClub', $team))
                                        <button class="cursor-pointer ml-6 text-sm text-blue-500 focus:outline-none" wire:click="confirmUpdate('{{ $club->id }}')">
                                            {{ __('Update') }}
                                        </button>
                                    @endif

                                    @if (Gate::check('removeClub', $team))
                                        <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none" wire:click="confirmDestroy('{{ $club->id }}')">
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
            {{ __('Update Team') }}
        </x-slot>

        <x-slot name="content">
            <!-- Team Name -->
            <x-jet-label for="name" value="{{ __('Team Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" model="updateForm.name" wire:model.defer="updateForm.name" />
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
