<x-app-layout>
    <x-slot name="header">

        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ Auth::user()->currentOrganization->name }} {{ __('Portfolio') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mt-10 sm:mt-0">
                <x-jet-action-section>
                    <x-slot name="title">
                        {{ __('Projects') }}
                    </x-slot>

                    <x-slot name="description"></x-slot>

                    <x-slot name="content">
                        <div class="space-y-6">
                            @forelse (Auth::user()->currentOrganization->teams->sortBy('name') as $team)
                            <div class="pb-10 border-b">
                                <div class="flex justify-between">
                                    <div>{{ $team->name }}</div>
                                    <div class="flex items-start">
                                        <a class="ml-6 text-sm text-blue-500 cursor-pointer focus:outline-none" href="{{ route('teams.show', $team->id) }}">
                                            {{ __('View') }}
                                        </a>
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
                                            <span class="text-sm text-gray-500">{{ _('State Date') }}:</span>
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
                            </div>
                            @empty
                                <div class="text-center">
                                    No projects created. Go ahead and <a class="text-blue-900 underline" href="{{ route('teams.create') }}">create one</a>!
                                </div>
                            @endforelse
                        </div>
                    </x-slot>
                </x-jet-action-section>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mt-10 sm:mt-0">
                <x-jet-action-section>
                    <x-slot name="title">
                        {{ __('Growth Boards') }}
                    </x-slot>

                    <x-slot name="description"></x-slot>

                    <x-slot name="content">
                        <div class="space-y-6">
                            @foreach (Auth::user()->currentOrganization->events->sortBy('name') as $event)
                                <div class="flex items-center justify-between">
                                    <div>{{ $event->name }}</div>

                                    @if($team->latestEvent() && $team->latestform())
                                        <div>
                                            <a class="ml-2 text-sm text-blue-500 cursor-pointer focus:outline-none" href="{{ route('events.results', [$team->latestEvent()->id, $team->latestform()->id, $team->id]) }}">
                                                {{ __('View Results') }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </x-slot>
                </x-jet-action-section>
            </div>
        </div>
    </div>
</x-app-layout>
