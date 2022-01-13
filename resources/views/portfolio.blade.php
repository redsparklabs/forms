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
                            @foreach (Auth::user()->currentOrganization->teams->sortBy('name') as $team)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center w-full">
                                        <div class="w-1/2 ml-4">{{ $team->name }}</div>

                                        <div class="w-1/2 ml-4">{{ $team->created_at->format('m-d-Y') }}</div>
                                    </div>

                                    @if($team->progress_metric)
                                        <div class="p-2 ml-2 font-bold text-right text-white bg-blue-500 ">{{ $team->progress_metric }}</div>
                                    @endif
                                    <div class="flex items-center">
                                        <a class="ml-6 text-sm text-blue-500 cursor-pointer focus:outline-none" href="{{ route('teams.show', $team->id) }}">
                                            {{ __('View') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-slot>
                </x-jet-action-section>
            </div>
        </div>
    </div>

    <!-- <div class="py-12">
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
                                    <div class="flex items-center w-full">
                                        <div class="w-1/2 ml-4">{{ $event->name }}</div>

                                        <div class="w-1/2 ml-4">{{ $event->created_at->format('m-d-Y') }}</div>
                                    </div>

                                    <div class="flex items-center">
                                        <a class="ml-6 text-sm text-blue-500 cursor-pointer focus:outline-none" href="{{ route('events.show', $event->id) }}">
                                            {{ __('View') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-slot>
                </x-jet-action-section>
            </div>
        </div>
    </div> -->
</x-app-layout>
