<div>
    @if ($organization->teams->isNotEmpty())
        <div class="mt-10 sm:mt-0">
            <x-jet-action-section>
                <x-slot name="title">
                    {{ __('Projects') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('All of the projects that are part of this organization.') }}
                </x-slot>

                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($organization->teams->sortBy('name') as $team)

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="ml-4">{{ $team->name }}</div>
                                    @if($team->progress_metric)
                                        <div class="p-2 ml-2 font-bold text-right text-white bg-blue-500 ">{{ $team->progress_metric }}</div>
                                    @endif

                                </div>

                                <div class="flex items-center">
                                    @if (Gate::check('viewTeam', $organization))
                                        <a class="ml-6 text-sm text-blue-500 cursor-pointer focus:outline-none" href="{{ route('events.results', [$team->latestEvent()->id, $team->latestform()->id]) }}">
                                            {{ __('View Results') }}
                                        </a>
                                    @endif

                                    @if (Gate::check('updateTeam', $organization))
                                        <button class="ml-6 text-sm text-blue-500 cursor-pointer focus:outline-none" wire:click="confirmUpdate('{{ $team->id }}')">
                                            {{ __('Update') }}
                                        </button>
                                    @endif

                                    @if (Gate::check('removeTeam', $organization))
                                        <button class="ml-6 text-sm text-red-500 cursor-pointer focus:outline-none" wire:click="confirmDestroy('{{ $team->id }}')">
                                            {{ __('Archive') }}
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

    <x-jet-dialog-modal wire:model="confirmingUpdating">
        <x-slot name="title">
            {{ __('Update Project') }}
        </x-slot>

        <x-slot name="content">
            <div>
                <x-jet-label for="name" value="{{ __('Project Name') }}" />
                <x-jet-input id="name" type="text" class="block w-full mt-1" model="updateForm.name" wire:model.defer="updateForm.name" />
                <x-jet-input-error for="name" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-label for="priority_level" value="{{ __('Priority Level') }}" />
                <x-jet-input id="priority_level" type="text" class="block w-full mt-1" wire:model.defer="updateForm.priority_level" />
                <x-jet-input-error for="priority_level" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-label for="start_date" value="{{ __('Start Date') }}" />
                <x-jet-input type="date" id="start_date"  class="block w-full mt-1" wire:model.defer="updateForm.start_date" />
                <x-jet-input-error for="start_date" class="mt-2" />
            </div>
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

    <x-jet-confirmation-modal wire:model="confirmingDestroying">
        <x-slot name="title">
            {{ __('Archive Project') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to archive this project?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingDestroying')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="destroy" spinner="destroy">
                {{ __('Archive') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
