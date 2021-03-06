<div>
    <header class="bg-white shadow">
        <div class="py-6 mx-auto max-w-7xl">
            <div class="flex">
                <div class="w-full">
                    <div>
                        <div class="flex">
                            <h3 class="flex-1 text-lg leading-6 font-medium text-gray-900">Growth Board - {{ $event->name }} </h3>
                            <div>
                                <x-buttons.green text="Update" wire:click="confirmUpdate('{{ $event->id }}', '{{ $form->id }}', '{{ $questions }}')" />
                            </div>
                        </div>
                        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
                            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Project</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->name }}</dd>
                            </div>
                            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Assessment Date</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $event->date?->format('m/d/y') }}</dd>
                            </div>
                             <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Priority Level</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->priority_level }}</dd>
                            </div>
                            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Current Progress Metric</dt>
                                <dd class="mt-1 text-sm font-semibold">
                                     <div class="flex items-center justify-center">
                                        @php
                                            $circumference = 2 * 22 / 7 * 120;
                                        @endphp
                                        <svg class="transform -rotate-90 w-72 h-72">
                                            <circle cx="145" cy="145" r="120" stroke="currentColor" stroke-width="30" fill="transparent" class="text-gray-100" />

                                            <circle cx="145" cy="145" r="120" stroke="currentColor" stroke-width="30" fill="transparent"
                                                stroke-dasharray="{{ $circumference }}"
                                                stroke-dashoffset="{{ $circumference - ($event->progressMetric($team) * 20) / 100 * $circumference }}"
                                                class="text-{{ $event->stage($event->progressMetric($team))->color}}" />
                                        </svg>
                                        <div class="flex items-center justify-center absolute text-5xl bg-{{ $event->stage($event->progressMetric($team))->color }} text-white rounded-full w-32 h-32 text-center p-4">{{ number_format($event->progressMetric($team), 1) }}</div>
                                    </div>
                                    <div class="flex mt-4">
                                        <div class="flex-1 p-2 text-white font-bold text-center bg-karban-green-2">1</div>
                                        <div class="flex-1 p-2 text-white font-bold text-center bg-karban-green-3">2</div>
                                        <div class="flex-1 p-2 text-white font-bold text-center bg-karban-green-4">3</div>
                                        <div class="flex-1 p-2 text-white font-bold text-center bg-karban-green-5">4</div>
                                        <div class="flex-1 p-2 text-white font-bold text-center bg-karban-green-6">5</div>
                                    </div>
                                </dd>
                            </div>
                            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Investment To Date</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">${{ number_format($event->teams()->find($team->id)->pivot->investment, 2) ?? 'N/A'}}</dd>
                            </div>
                            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">NPV</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">${{ number_format($event->teams()->find($team->id)->pivot->net_projected_value, 2) ?? 'N/A'}}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="px-4 py-5 bg-white shadow rounded-lg max-w-7xl overflow-hidden sm:p-6 m-auto my-4">
         <div>
            <table class="w-full m-auto border-collapse">
                <thead class="table-auto h-[278px]">
                    <tr>
                        <th scope="col" class="align-bottom">GB Member</th>
                        <th scope="col" class="w-20 bg-karban-green-3 border-2 whitespace-nowrap">
                            <div style="transform: translate(0, 115px) rotate(270deg);" class="w-10 ml-2">
                                <span class="p-2 text-white ">PROGRESS METRIC</span>
                            </div>
                        </th>
                        @foreach($questions as $question)
                            <th scope="col" class="w-20 bg-white border-2 whitespace-nowrap text-gray-700">
                                <div style="transform: translate(0, 115px) rotate(270deg);" class="w-10 ml-2">
                                    <span class="p-2">{{ $question['question'] }}</span>
                                </div>
                            </th>
                        @endforeach

                        @foreach($sections->all() as $section => $sectionData)
                            <th scope="col" class="w-20 bg-karban-green-3 text-white border-2 whitespace-nowrap">
                                <div style="transform: translate(0, 115px) rotate(270deg);" class="w-10 ml-2">
                                    <span class="text-{{ Arr::get($sectionData, 'color') }} p-2">{{ implode(' ', explode('_', $section)) }}</span>
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>

                    @foreach($responses as $response)
                        <tr>
                            <td class="p-2 pl-0"> {{ $response->email }} </td>

                            @php
                                $total = 0;
                            @endphp

                            @foreach($sections->reject(fn($item, $key) => $key == 'Intutive_Scoring')->all() as $section => $sectionData)
                                @php
                                    $sectionQuestions = collect($sectionData)->pluck('question')->map(fn($item) => Str::slug($item))->toArray();

                                    $total += collect($response->questions)->filter(function($item, $key) use ($sectionQuestions) {
                                        return in_array($key, $sectionQuestions);
                                    })->sum();
                                @endphp
                            @endforeach

                            @php
                                $progressMetricTotal += number_format($total / $totalSections, 1);
                            @endphp
                            <td class="p-2 text-center font-bold text-white bg-karban-green-3 border">{{ number_format($total / $totalSections, 1) }}</td>

                            @foreach($questions as $question)
                                <td class="p-2 text-center bg-white border">{{ Arr::get($response->questions, Str::slug($question['question'])) }}</td>
                            @endforeach

                            @foreach($sections->all() as $section => $sectionData)
                                <td class="p-2 text-center bg-white font-bold text-gray-700 border">
                                    @php
                                        $sectionQuestions = collect($sectionData)->pluck('question')->map(fn($item) => Str::slug($item))->toArray();
                                        $total = collect($response->questions)->filter(function($item, $key) use($sectionQuestions) {
                                            return in_array($key, $sectionQuestions);
                                        })->sum();

                                        $sectionTotals[$section .'_count'] += number_format($total / $sections->count(), 1);
                                        echo number_format($total / $sections->count(), 1);
                                    @endphp
                                </td>
                            @endforeach
                        </tr>
                    @endforeach


                    <tr>
                        <td></td>
                        @if($progressMetricTotal > 0 && $responses->count() > 0)
                            <td class="p-2 font-bold text-center text-white bg-{{colorize(number_format($progressMetricTotal / $responses->count(), 1))}} border">
                                {{ number_format($progressMetricTotal / $responses->count(), 1) }}
                        @else
                            <td></td>
                        @endif
                        </td>

                        @foreach($questions as $question)
                            @php
                                $mappedQuestions = collect($responses)->map(function ($value) {
                                    return $value->response['questions'];
                                });
                            @endphp
                            @if($mappedQuestions->count() > 0)

                                <td class="p-2 font-bold text-center text-white bg-{{ colorize(number_format( $mappedQuestions->pluck(Str::slug($question['question']))->sum() / $mappedQuestions->count(), 1)) }} border">
                                    @php


                                        if( $mappedQuestions->pluck(Str::slug($question['question']))->sum() > 0) {
                                            echo number_format( $mappedQuestions->pluck(Str::slug($question['question']))->sum() / $mappedQuestions->count(), 1);
                                        }
                                    @endphp
                                </td>
                            @endif
                        @endforeach

                        @foreach($sections->all() as $section => $sectionData)
                            @if($sectionTotals[$section .'_count'] && $responses->count())
                                <td class="text-white font-bold bg-{{colorize(number_format($sectionTotals[$section .'_count'] / $responses->count(), 1) ) }} border text-center p-2">
                                    {{ number_format($sectionTotals[$section .'_count'] / $responses->count(), 1) }}
                                </td>
                            @else
                                <td> </td>
                            @endif
                        @endforeach
                    </tr>
                </tbody>
            </table>

            <table class="w-full m-auto mt-10 border-collapse">
                <thead class="table-auto">
                    <tr>
                        <th scope="col">
                            <div class="mb-2 text-lg text-left text-gray-700">Qualitative Feedback</div>
                            <div class="text-xs font-normal text-left">Feedback, Questions, Ideas, and follow-up items.</div>
                        </th>
                        @foreach($feedback_questions as $question)
                            <th scope="col" class="px-4 py-2 text-left">
                                <div class="mb-2 text-lg text-gray-700">{{ $question['question'] }}</div>
                                <div class="text-xs font-normal">{{ $question['description'] }}</div>
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @foreach($responses as $response)
                        @if(Arr::get($response->response, 'questions.custom'))
                            <tr class="border-b-2 border-black border-solid">
                                <td class="py-2 text-left">{{ $response->email }} </td>

                                    @foreach(Arr::get($response->response, 'questions.custom') as $custom)
                                        <td class="px-4 py-2"> {{ $custom }} </td>
                                    @endforeach
                            </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td class="p-2 text-sm italic" colspan="{{ count($feedback_questions) + 1 }}">*Note: All Scores are calculated based on the last Evaluation, they are not a aggregate of all Progress scores.</td>
                    </tr>
                </tbody>
            </table>

            <div class="w-2/3 m-auto mt-10">
                <div class="grid grid-flow-col grid-rows-2 gap-1 w-full">

                    @if($responses)
                        @foreach($questions->where('hidden', false)->sortBy('order')->take(7) as $i => $question)
                            @php
                                $number = 0;
                                $mappedResponses = collect($responses)->map(fn ($value) => $value->response['questions']);
                                if($mappedResponses->pluck(Str::slug($question['question']))->sum() > 0) {
                                    $number = number_format( $mappedResponses->pluck(Str::slug($question['question']))->sum() / $mappedResponses->count(), 1);
                                }

                            @endphp
                             <div x-data="{ tooltip{{$i}}: false }"
                                 class="{{ $question['classes'] }} bg-{{ colorize($number) }}  rounded flex"
                                >
                                    <div
                                        x-on:mouseover="tooltip{{$i}} = true"
                                        x-on:mouseleave="tooltip{{$i}} = false"
                                        class="text-center p-4 items-center justify-center flex w-full text-white font-bold py-8"
                                    >
                                        <div>{{ $question['abbrev'] }} <br/>{{ $number}}</div>
                                    </div>
                                      <div class="relative" x-cloak x-show.transition.origin.top="tooltip{{$i}}">
                                        <div class="absolute top-0 z-10 w-48 p-2 -mt-1 text-sm leading-tight text-black transform -translate-x-1/2 -translate-y-full bg-white rounded-lg border border-black">
                                            <div class="font-bold mb-2">{{ $question['question']}}</div>
                                            <div>{{ $question['description']}}</div>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                    @endif
                </div>

                <div class="grid grid-flow-col grid-rows-2 gap-1 mt-1 w-full">
                    @if($responses)
                         @foreach($questions->where('hidden', false)->sortBy('order')->skip(7)->take(2) as $question)
                            @php
                                $mappedResponses = collect($responses)->map(function ($value) {
                                    return $value->response['questions'];
                                });
                                $number = 0;
                                if($mappedResponses->pluck(Str::slug($question['question']))->sum()) {
                                    $number = number_format( $mappedResponses->pluck(Str::slug($question['question']))->sum() / $mappedResponses->count(), 1);
                                }
                            @endphp

                             <div x-data="{ tooltip2{{$i}}: false }"
                                 class="{{ $question['classes'] }} bg-{{ colorize($number) }}  rounded flex"
                                >
                                    <div
                                        x-on:mouseover="tooltip2{{$i}} = true"
                                        x-on:mouseleave="tooltip2{{$i}} = false"
                                        class="text-center p-4 items-center justify-center flex w-full text-white font-bold py-8"
                                    >
                                        <div>{{ $question['abbrev'] }} <br/>{{ $number}}</div>
                                    </div>
                                      <div class="relative" x-cloak x-show.transition.origin.top="tooltip2{{$i}}">
                                        <div class="absolute top-0 z-10 w-48 p-2 -mt-1 text-sm leading-tight text-black transform -translate-x-1/2 -translate-y-full bg-white rounded-lg border border-black">
                                            <div class="font-bold mb-2">{{ $question['question']}}</div>
                                            <div>{{ $question['description']}}</div>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-jet-dialog-modal wire:model="confirmingUpdating">
        <x-slot name="title">
            {{ __('Update Fields') }}
        </x-slot>

        <x-slot name="content">

            <div class="mt-4">
                <x-jet-label for="net_projected_value" value="{{ __('Net Projected Value') }}" />
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span class="inline-flex shadow-sm items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">$</span>
                    <x-jet-input id="net_projected_value" type="text" class="block w-full border-l-0 rounded-l-none" wire:model.defer="updateForm.net_projected_value" />
                </div>
                <x-jet-input-error for="updateForm.net_projected_value" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-label for="investment" value="{{ __('Investment') }}" />
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span class="inline-flex shadow-sm items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">$</span>
                    <x-jet-input type="text" id="investment" class="block w-full border-l-0 rounded-l-none" wire:model.defer="updateForm.investment" />
                </div>
                <x-jet-input-error for="updateForm.investment" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-label for="priority_level" value="{{ __('Priority Level') }}" />
                <x-jet-input id="priority_level" type="text" class="block w-full mt-1" wire:model.defer="updateForm.priority_level" />
                <x-jet-input-error for="updateForm.priority_level" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-label for="start_date" value="{{ __('Start Date') }}" />
                <x-jet-input id="start_date" type="date" class="block w-full mt-1" wire:model.defer="updateForm.start_date" />
                <x-jet-input-error for="updateForm.start_date" class="mt-2" />
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
