<div>
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
                    @forelse ($organization->teams->sortBy('name') as $team)
                        <div class="flex justify-between">
                            <div>{{ $team->name }}</div>
                            <div class="flex items-start">
                                @if (Gate::check('viewTeam', $organization) )
                                    <a class="ml-6 text-sm text-blue-500 cursor-pointer focus:outline-none" href="{{ route('teams.show', [$team->id]) }}">
                                        {{ __('View') }}
                                    </a>
                                @endif

(move update - to growth boards show page)
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
                        <div class="grid grid-cols-3 gap-4">
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
                            <div class="grid grid-cols-3 gap-4">
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
                    @empty
                        <div class="text-sm text-center text-gray-600 ">
                            No Projects created. Go ahead and <a class="underline" href="{{ route('teams.create') }}">create one</a>!
                        </div>
                    @endforelse
                </div>
            </x-slot>
        </x-jet-action-section>
    </div>


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
