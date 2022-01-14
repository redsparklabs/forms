<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Growth Board - ' . $event->name) }}
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
                            @php
                                $form = $event->forms()->first();
                                $data = $team->calculateSections($form);
                            @endphp
                            <div class="flex items-center justify-between">
                                <div class="flex items-center w-3/4">
                                    <div>{{ $team->name }}</div>
                                    @if($data['progressMetricTotal'] > 0)
                                        <div class="p-2 ml-10 font-bold text-right text-white bg-blue-500">
                                            {{ number_format($data['progressMetricTotal'] / $data['responses']->count(), 1) }}
                                        </div>
                                    @endif
                                    <div class="ml-10">{{ $team->created_at->format('m-d-Y'), }}</div>
                                </div>
                                @if($data['progressMetricTotal'] > 0)
                                    <div class="flex items-center">
                                        <a class="ml-6 text-sm text-blue-500 cursor-pointer focus:outline-none" href="{{ route('events.team.results', [$event->id, $form->id, $team->id]) }}">
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
</x-app-layout>
