
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Growth Board - ' . $event->name) }}
        </h2>
    </x-slot>


    <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
        @if ($event->teams->isNotEmpty())
            <div class="mt-10 sm:mt-0">
                <x-jet-action-section>
                    <x-slot name="title">
                        {{ __('Projects') }}
                    </x-slot>

                    <x-slot name="description">
                        {{ __('All of the projects that are part of this Growth Board.') }}
                    </x-slot>

                    <x-slot name="content">
                        <div class="space-y-6">
                            @foreach ($event->teams->sortBy('name') as $team)
                                @php
                                    $form = $event->forms()->first();
                                    $data = $team->calculateSections($form);
                                @endphp
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
                                <div class="items-center block">
                                    <table class="">
                                        <tr>
                                            <td class="p-2 font-bold text-right text-white bg-blue-500">
                                            @if($data['progressMetricTotal'] > 0)
                                                {{ number_format($data['progressMetricTotal'] / $data['responses']->count(), 1) }}
                                            @endif
                                            </td>

                                            @foreach($data['allSections']->all() as $section => $sectionData)
                                                <td class="bg-{{ $sectionData->first()['color'] }} text-center p-2">
                                                    @if($data['sectionCount'][$section .'_count'])
                                                        {{ number_format($data['sectionCount'][$section .'_count'] / $data['responses']->count(), 1) }}
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    </x-slot>
                </x-jet-action-section>
            </div>
        @endif
    </div>
</x-app-layout>
