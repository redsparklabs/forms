
<div>
    <header class="bg-white shadow">
        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        {{ __('Projects') }}
                    </h2>
                </div>
                <div>
                    <a class="ml-6 text-sm text-blue-500 cursor-pointer focus:outline-none"  wire:click="confirmCreate()">
                        {{ __('Create') }}
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mt-10 sm:mt-0">
            <x-jet-action-section>
                <x-slot name="title">
                    {{ __('Projects') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('All of the projects that are part of this organization.') }}
                </x-slot>

                <x-slot name="content">
                    <div class="space-y-3">
                        @forelse ($organization->teams->sortBy('name') as $team)

                            <div class="flex justify-between">
                                <div>{{ $team->name }}</div>
                                <div class="flex items-start">
                                    @if (Gate::check('viewTeam', $organization) )
                                        <a class="ml-6 text-sm text-blue-500 cursor-pointer focus:outline-none" href="{{ route('teams.show', [$team->id]) }}">
                                            {{ __('View') }}
                                        </a>
                                    @endif

                                    @if (Gate::check('removeTeam', $organization))
                                        <button class="ml-6 text-sm text-red-500 cursor-pointer focus:outline-none" wire:click="confirmDestroy('{{ $team->id }}')">
                                            {{ __('Archive') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-2">
                                @if($team->progress_metric)
                                    <div class="flex items-center w-full">
                                        <span class="text-sm text-gray-500">{{ _('Progress Metric') }}</span>
                                        <div class="p-2 ml-2 font-bold text-right text-white bg-blue-500 ">{{ $team->progress_metric }}</div>
                                    </div>
                                @endif
                                @if($team->priority_level)
                                    <div class="flex items-center w-full">
                                        <span class="text-sm text-gray-500">{{ _('Priority Level') }}:</span>
                                        <span class="ml-2 text-sm">{{ $team->priority_level }}</span>
                                    </div>
                                @endif
                                @if($team->start_date)
                                    <div class="flex items-center w-full">
                                        <span class="text-sm text-gray-500">{{ _('Start Date') }}:</span>
                                        <span class="ml-2 text-sm">{{ $team->start_date->format('m/d/y') }}</span>
                                    </div>
                                @endif
                            </div>
                            @if($team->pivot())
                                <div class="grid grid-cols-3 gap-2">
                                    @if($team->pivot()->net_projected_value)
                                        <div class="flex items-center w-full">
                                            <span class="text-sm text-gray-500">{{ _('Net Project Value') }}:</span>
                                            <span class="ml-2 text-sm">{{ $team->pivot()->net_projected_value }}</span>
                                        </div>
                                    @endif
                                    @if($team->pivot()->investment)
                                        <div class="flex items-center w-full">
                                            <span class="text-sm text-gray-500">{{ _('Investment') }}:</span>
                                            <span class="ml-2 text-sm">{{ $team->pivot()->investment }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            @if(!$loop->last)
                                <hr />
                            @endif
                        @empty
                            <div class="text-sm text-center text-gray-600 ">
                                {{ __('No Projects created. Go ahead and') }} <a class="underline" href="{{ route('teams.create') }}">create one</a>!
                            </div>
                        @endforelse
                    </div>
                </x-slot>
            </x-jet-action-section>
        </div>

        <x-jet-dialog-modal wire:model="confirmingCreating">
            <x-slot name="title">
                {{ __('Create Project') }}
            </x-slot>

            <x-slot name="description">

            </x-slot>

            <x-slot name="content">
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="name" value="{{ __('Project Name') }}" />
                    <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.defer="createForm.name" />
                    <x-jet-input-error for="createForm.name" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="priority_level" value="{{ __('Priority Level') }}" />
                    <x-jet-input id="priority_level" type="text" class="block w-full mt-1" wire:model.defer="createForm.priority_level" />
                    <x-jet-input-error for="createForm.priority_level" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="start_date" value="{{ __('Start Date') }}" />
                    <x-jet-input id="start_date" onkeydown="return false" type="date" class="block w-full mt-1" required pattern="\d{4}-\d{2}-\d{2}" wire:model.defer="createForm.start_date" />
                    <x-jet-input-error for="createForm.start_date" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingCreating')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-2" wire:click="create" spinner="create">
                    {{ __('Create') }}
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
</div>

