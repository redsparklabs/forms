
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Event - ' . $event->name) }}
        </h2>
    </x-slot>

    <div>
        <div class="pb-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if ($event->forms->isNotEmpty())
                <x-jet-section-border />
                <div class="mt-10 sm:mt-0">
                    <x-jet-action-section>
                        <x-slot name="title">
                            {{ __('Forms') }}
                        </x-slot>

                        <x-slot name="description">
                            {{ __('All of the forms that are part of this event.') }}
                        </x-slot>

                        <x-slot name="content">
                            <div class="space-y-6">
                                @foreach ($event->forms->sortBy('name') as $form)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="ml-4">{{ $form->name }}</div>
                                        </div>

                                        <div class="flex items-center">
                                            <a class="ml-6 text-sm text-blue-500 cursor-pointer hover:text-blue-700 focus:outline-none" href="{{ route('form-builder', $event->slug) }}">
                                                {{ __('View') }}
                                            </a>
                                            <a class="ml-6 text-sm text-blue-500 cursor-pointer hover:text-blue-700 focus:outline-none" href="{{ route('events.results', [$event->id, $form->id]) }}">
                                                {{ __('Results') }}
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </x-slot>
                    </x-jet-action-section>
                </div>
            @endif
            @if ($event->forms->isNotEmpty())
                <x-jet-section-border />
                <div class="mt-10 sm:mt-0">
                    <x-jet-action-section>
                        <x-slot name="title">
                            {{ __('Teams') }}
                        </x-slot>

                        <x-slot name="description">
                            {{ __('All of the teams that are part of this event.') }}
                        </x-slot>

                        <x-slot name="content">
                            <div class="space-y-6">
                                @foreach ($event->teams->sortBy('name') as $team)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <img class="w-8 h-8 rounded-full" src="{{ $team->team_image }}" alt="{{ $team->name }}">
                                            <div class="ml-4">{{ $team->name }}</div>
                                        </div>

                                        <div class="flex items-center">
                                            <a class="ml-6 text-sm text-blue-500 cursor-pointer focus:outline-none" href="{{ route('events.team.results', [$event->id, $form->id, $team->id]) }}">
                                                {{ __('Results') }}
                                            </a>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </x-slot>
                    </x-jet-action-section>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
