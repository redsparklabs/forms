<div>
    <header class="bg-white shadow">
        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex">
                <div class="w-full">
                    <div>
                        <div class="flex">
                            <h3 class="flex-1 text-lg leading-6 font-medium text-gray-900">Growth Board - {{ $event->name }} </h3>
                            <div>
                               <button class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"  wire:click="confirmUpdate('{{ $event->id }}', '{{ $form->id }}', '{{ $questions }}')">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
                            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Project</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $team->name }}</dd>
                            </div>
                            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Project Start Date:</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->start_date->format('m-d-y') }}</dd>
                            </div>
                             <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Priority Level:</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->priority_level }}</dd>
                            </div>
                            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Current Progress Metric:</dt>
                                <dd class="mt-1 text-sm font-semibold text-blue-500">{{ $team->progress_metric }}</dd>
                            </div>
                            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Investment To Date:</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->pivot()->investment ?? 'N/A'}}</dd>
                            </div>
                            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">NPV:</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->pivot()->net_projected_value ?? 'N/A'}}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6 w-3/4 m-auto my-4">
         <div>
            <table class="w-1/2 m-auto border-collapse">
                <thead class="table-auto h-[278px]">
                    <tr>
                        <th scope="col" class="align-bottom">GB Member</th>
                        <th scope="col" class="w-10 bg-blue-500 border whitespace-nowrap">
                            <div style="transform: translate(0, 115px) rotate(270deg);" class="w-10">
                                <span class="p-2 text-white ">PROGRESS METRIC</span>
                            </div>
                        </th>
                        @foreach($questions as $question)
                            <th scope="col" class="w-10 bg-white border whitespace-nowrap">
                                <div style="transform: translate(0, 115px) rotate(270deg);" class="w-10">
                                    <span class="text-{{ $question['color'] }} p-2">{{ $question['question'] }}</span>
                                </div>
                            </th>
                        @endforeach

                        @foreach($sections->all() as $section => $sectionData)
                            <th scope="col" class="w-10 bg-white border whitespace-nowrap">
                                <div style="transform: translate(0, 115px) rotate(270deg);" class="w-10">
                                    <span class="text-{{ Arr::get($sectionData, 'color') }} p-2">{{ implode(' ', explode('_', $section)) }}</span>
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>

                    @foreach($responses as $response)
                        <tr class="border">
                            <td class="p-2"> {{ $response->email }} </td>

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
                            <td class="p-2 text-right bg-white border-2">{{ number_format($total / $totalSections, 1) }}</td>

                            @foreach($questions as $question)
                                <td class="p-2 text-center bg-white border-2">{{ Arr::get($response->questions, Str::slug($question['question'])) }}</td>
                            @endforeach

                            @foreach($sections->all() as $section => $sectionData)
                                <td class="p-2 text-center bg-white border-2">
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
                        <td class="p-2 font-bold text-right text-white bg-blue-500 border-2">
                            @if($progressMetricTotal > 0)
                                {{ number_format($progressMetricTotal / $responses->count(), 1) }}
                            @endif
                        </td>

                        @foreach($questions as $question)
                            <td class="p-2 text-center bg-blue-100 border-2">
                                @php
                                    $mappedQuestions = collect($responses)->map(function ($value) {
                                        return $value->response['questions'];
                                    });

                                    if( $mappedQuestions->pluck(Str::slug($question['question']))->sum() > 0) {
                                        echo number_format( $mappedQuestions->pluck(Str::slug($question['question']))->sum() / $mappedQuestions->count(), 1);
                                    }
                                @endphp
                            </td>
                        @endforeach

                        @foreach($sections->all() as $section => $sectionData)
                            <td class="bg-{{ Arr::get($sectionData, 'color') }} border-2 text-center p-2">
                                @if($sectionTotals[$section .'_count'])
                                    {{ number_format($sectionTotals[$section .'_count'] / $responses->count(), 1) }}
                                @endif
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>

            <table class="w-full m-auto mt-10 border-collapse">
                <thead class="table-auto">
                    <tr>
                        <th scope="col">
                            <div class="mb-2 text-lg text-left">Qualitative Feedback</div>
                            <div class="text-xs font-normal">Feedback, Questions, Ideas, and follow-up items.</div>
                        </th>
                        @foreach($feedback_questions as $question)
                            <th scope="col" class="px-4 py-2 text-left">
                                <div class="mb-2 text-lg text-blue-600">{{ $question['question'] }}</div>
                                <div class="text-xs font-normal">{{ $question['description'] }}</div>
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @foreach($responses as $response)
                    <tr class="border-b-2 border-black border-solid">
                        <td class="py-2 text-left">{{ $response->email }} </td>
                        @foreach($response->response['questions']['custom'] as $custom)
                            <td class="px-4 py-2"> {{ $custom }} </td>
                        @endforeach
                    </tr>
                    @endforeach
                    <tr>
                        <td class="p-2 text-sm italic" colspan="{{ count($feedback_questions) + 1 }}">*Note: All Scores are calculated based on the last Evaluation, they are not a aggregate of all Progress scores.</td>
                    </tr>
                </tbody>
            </table>

            <div class="w-2/3 m-auto mt-10">
                <div class="grid grid-flow-col grid-rows-2 gap-4">

                     @foreach($questions->where('hidden', false)->sortBy('order')->take(7) as $question)
                        @php
                            $mappedQuestions = collect($responses)->map(function ($value) {
                                return $value->response['questions'];
                            });
                            $number = 0;
                            if($mappedQuestions->pluck(Str::slug($question['question']))->sum() > 0) {
                                $number = number_format( $mappedQuestions->pluck(Str::slug($question['question']))->sum() / $mappedQuestions->count(), 1);
                            }
                        @endphp
                        <div class="{{ $question['classes'] }} {{ colorize($number) }} flex items-center justify-center text-center p-4">{{ $question['question'] }}<br/>{{ $number}}</div>
                    @endforeach
                </div>

                <div class="grid grid-flow-col gap-4 mt-2">
                     @foreach($questions->where('hidden', false)->sortBy('order')->skip(7)->take(2) as $question)
                        @php
                            $mappedQuestions = collect($responses)->map(function ($value) {
                                return $value->response['questions'];
                            });
                            $number = 0;
                            if($mappedQuestions->pluck(Str::slug($question['question']))->sum()) {
                                $number = number_format( $mappedQuestions->pluck(Str::slug($question['question']))->sum() / $mappedQuestions->count(), 1);
                            }
                        @endphp

                        <div class="{{ $question['classes']}} {{ colorize($number) }} flex text-center items-center justify-center">{{ $question['question'] }}<br/>{{ $number}}</div>
                    @endforeach
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
                <x-jet-input id="net_projected_value" type="text" class="block w-full mt-1" wire:model.defer="updateForm.net_projected_value" />
                <x-jet-input-error for="net_projected_value" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-label for="investment" value="{{ __('Investment') }}" />
                <x-jet-input type="text" id="investment" class="block w-full mt-1" wire:model.defer="updateForm.investment" />
                <x-jet-input-error for="investment" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-label for="priority_level" value="{{ __('Priority Level') }}" />
                <x-jet-input id="priority_level" type="text" class="block w-full mt-1" wire:model.defer="updateForm.priority_level" />
                <x-jet-input-error for="priority_level" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-label for="start_date" value="{{ __('Start Date') }}" />
                <x-jet-input id="start_date" type="date" class="block w-full mt-1" wire:model.defer="updateForm.start_date" />
                <x-jet-input-error for="start_date" class="mt-2" />
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
