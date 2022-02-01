<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Growth Board - ' . $event->name) }} {{ $event->start_date }}
        </h2>
    </x-slot>

    <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mt-10 sm:mt-0">
            <x-jet-action-section>
                <x-slot name="title">
                    {{ __('Projects') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('All of the projects that are part of this Growth Board.') }}
                </x-slot>

                <x-slot name="content">
                    <div>
                        @foreach ($event->teams->sortBy('name') as $team)
                            <div class="flex justify-between">
                                <div>{{ $team->name }}</div>
                                <div class="flex items-start">
                                    @if( $team->progress_metric > 0)
                                        <div class="flex items-center">
                                            <a class="ml-6 text-sm text-blue-500 cursor-pointer focus:outline-none" href="{{ route('events.results', [$event->id, $team->latestForm()->id, $team->id]) }}">
                                                {{ __('View Results') }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 mt-4">
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
                                        <span class="text-sm text-gray-500">{{ _('State Date') }}:</span>
                                        <span class="ml-2 text-sm">{{ $team->start_date->format('m/d/y') }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="grid grid-cols-3 gap-4 mt-4">
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
                        @endforeach
                    </div>
                </x-slot>
            </x-jet-action-section>
        </div>
    </div>
</x-app-layout>
