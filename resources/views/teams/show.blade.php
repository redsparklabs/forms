<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Project - ') . $team->name }}
        </h2>
    </x-slot>
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
                                        <span class="text-gray-600 text-md">{{ $event->teams->find($team)->pivot->investment }}</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold leading-tight text-gray-800 text-md">Net projected Value:</span>
                                        <span class="text-gray-600 text-md">{{ $event->teams->find($team)->pivot->net_projected_value }}</span>
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
</x-app-layout>
