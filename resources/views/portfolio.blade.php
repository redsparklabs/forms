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

                    <x-slot name="description">
                        {{-- <a class="text-sm text-blue-500 cursor-pointer focus:outline-none" href="{{ route('teams.create') }}">{{ __('Create a new Project') }}</a> --}}
                    </x-slot>

                    <x-slot name="content">

                        <div class="space-y-6">
                            @forelse (Auth::user()->currentOrganization->teams->sortBy('name') as $team)
                            <div>
                                <div class="flex justify-between ">
                                    <div class="text-md p-1">{{ $team->name }}</div>
                                     @if($team->progress_metric)
                                        <div>
                                            <span class="text-sm text-gray-500">{{ _('Progress Metric') }}</span>
                                            <div class="inline-block p-1 font-bold text-center text-white bg-blue-500 ">{{ $team->progress_metric }}</div>
                                        </div>
                                    @endif
                                     @if($team->priority_level)
                                        <div class="p-1">
                                            <span class="text-sm text-gray-500">{{ _('Priority Level') }}:</span>
                                            <span class="ml-2 text-sm">{{ $team->priority_level }}</span>
                                        </div>
                                    @endif

                                    <div class="p-1">
                                        <a class="ml-6 text-sm text-blue-500 cursor-pointer focus:outline-none" href="{{ route('teams.show', $team->id) }}">
                                            {{ __('View') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @empty
                                <div class="text-center">
                                    <span class="text-md text-center text-gray-600">No Projects created. Go ahead and <a class="text-blue-900 underline" href="{{ route('teams.create') }}">{{ __('create one') }}</a>!</span>
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

                    <x-slot name="description">
                        <a class="text-sm text-blue-500 cursor-pointer focus:outline-none" href="{{ route('events.create') }}">{{ __('Create a new Growth Board') }}</a>
                    </x-slot>

                    <x-slot name="content">
                        <div class="space-y-6">
                            @forelse (Auth::user()->currentOrganization->events->sortBy('name') as $event)
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
                             @empty
                                <div class="text-center">
                                    <span class="text-md text-center text-gray-600">No Growth Boards created. Go ahead and <a class="text-blue-900 underline" href="{{ route('events.create') }}">create one</a>!</span>
                                </div>
                            @endforelse
                        </div>
                    </x-slot>
                </x-jet-action-section>
            </div>
        </div>
    </div>
</x-app-layout>
