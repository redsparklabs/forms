
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
            @if ($event->teams->isNotEmpty())
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

                                        @php
                                            $form = $event->forms()->first();
                                            $data = $team->calculateSections($form);
                                        @endphp

                                    </div>
                                    <div class="items-center block">
                                        <table class="w-full">
                                            <tr>
                                                <td class="p-2 font-bold text-right text-white bg-blue-500">
                                                @if($data['progressMetricTotal'] > 0)
                                                    {{ number_format($data['progressMetricTotal'] / $data['responses']->count(), 1) }}
                                                @endif
                                                </td>
                                                @foreach($data['questions'] as $question)
                                                    <td class="p-2 text-center bg-blue-100">
                                                        @php
                                                            $mappedQuestions = collect($data['responses'])->map(fn ($value) => $value->response['questions']);
                                                            if( $mappedQuestions->pluck(Str::slug($question['question']))->sum() > 0) {
                                                                echo number_format( $mappedQuestions->pluck(Str::slug($question['question']))->sum() / $mappedQuestions->count(), 1);
                                                            }
                                                        @endphp
                                                    </td>
                                                @endforeach

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
    </div>
</x-app-layout>
