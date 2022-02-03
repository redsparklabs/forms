<div>
    <header class="bg-white shadow">
        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <div class="flex justify-between">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        {{ __('Project - ') . $team->name }}
                    </h2>
                </div>
                <div>
                    @if (Gate::check('updateTeam', $organization))
                        <button class="ml-6 text-sm text-blue-500 cursor-pointer focus:outline-none" wire:click="confirmUpdate('{{ $team->id }}')">
                            {{ __('Update') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </header>
    <div>
        <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mt-10 sm:mt-0">
                <x-jet-action-section>
                    <x-slot name="title">
                        {{ __('Growth Boards') }}
                    </x-slot>

                    <x-slot name="description">
                        {{ __('All of the Growth Boards that are part of this project.') }}
                    </x-slot>

                    <!-- Organization Organization List -->
                    <x-slot name="content">
                        <div class="space-y-6">
                            @forelse ($team->events->sortBy('name') as $event)
                            <div>
                                    <div>
                                        <span class="font-semibold leading-tight text-gray-800 text-md">Growth Investment:</span>
                                        <span class="text-gray-600 text-md">{{ $event->pivot->investment }}</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold leading-tight text-gray-800 text-md">Net projected Value:</span>
                                        <span class="text-gray-600 text-md">{{ $event->pivot->net_projected_value }}</span>
                                    </div>
                                    @if($team->progress_metric)
                                        <div>
                                            <span class="font-semibold leading-tight text-gray-800 text-md">Progress Metric:</span>
                                            <span class="font-bold text-right text-blue-500">{{ $team->progress_metric }}</span>
                                        </div>
                                    @endif
                            </div>


                            <div>graph here</div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="ml-4">{{ $event->name }}</div>
                                    </div>

                                    <div>
                                        @if($team->latestEvent() && $team->latestform())
                                            <a class="ml-2 text-sm text-blue-500 cursor-pointer focus:outline-none" href="{{ route('events.results', [$team->latestEvent()->id, $team->latestform()->id, $team->id]) }}">
                                                {{ __('View Results') }}
                                            </a>
                                        @endif
                                    </div>

                                </div>
                            @empty
                                <div class="w-full text-center">
                                     {{ __('No') }} <a class="text-blue-900 cursor-pointer focus:outline-none" href="{{ route('events.index') }}">{{ __('Growth Boards') }}</a> {{ __('have been created.') }}
                                </div>
                            @endforelse
                        </div>
                    </x-slot>
                </x-jet-action-section>
            </div>
        </div>
    </div>

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

</div>
