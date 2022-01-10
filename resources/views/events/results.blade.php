
<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Results &middot; {{ $event->name }} &middot; {{ $form->name }} &middot; @if($team) {{ $team->name }} @endif
        </h2>
    </x-slot>

    <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
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
                                    <span class="text-{{ $sectionData->first()['color'] }} p-2">{{ implode(' ', explode('_', $section)) }}</span>
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
                                    $sectionQuestions = $sectionData->pluck('question')->map(fn($item) => Str::slug($item))->toArray();

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
                                        $sectionQuestions = $sectionData->pluck('question')->map(fn($item) => Str::slug($item))->toArray();
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
                            <td class="bg-{{ $sectionData->first()['color'] }} border-2 text-center p-2">
                                @if($sectionTotals[$section .'_count'])
                                    {{ number_format($sectionTotals[$section .'_count'] / $form->responses->count(), 1) }}
                                @endif
                            </td>
                        @endforeach

                    </tr>
                </tbody>
            </table>

           {{--  <table class="w-full m-auto mt-10 border-collapse">
                <thead class="table-auto">
                    <tr>
                        <th scope="col"></th>
                        @foreach($feedback_questions as $question)
                            <th scope="col" class="px-4 py-2 text-left">
                                <div class="mb-2 text-lg">{{ $question['question'] }}</div>
                                <div class="text-xs font-normal">{{ $question['description'] }}</div>
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @foreach($responses as $response)
                    <tr class="border-b-2 border-black border-solid">
                        <td class="px-4 py-2">{{ $response->email }} {{ $response->team }} </td>
                        @foreach($response->response['questions']['custom'] as $custom)
                            <td class="px-4 py-2"> {{ $custom }} </td>
                        @endforeach
                    </tr>
                    @endforeach
                    <tr>
                        <td class="p-2 text-sm italic" colspan="{{ count($feedback_questions) + 1 }}">*Note: All Scores are calculated based on the last Evaluation, they are not a aggregate of all Progress scores.</td>
                    </tr>
                </tbody>
            </table> --}}

            <div class="w-2/3 m-auto mt-10">
                <div class="grid grid-flow-col gap-2 grid-rows-">

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

                        <div class="{{ $question['classes']}} {{ colorize($number) }} flex items-center justify-center">{{ $question['question'] }}<br/>{{ $number}}</div>
                    @endforeach
                </div>


                <div class="grid grid-flow-col gap-2 mt-2 grid-rows-">
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

                        <div class="{{ $question['classes']}} {{ colorize($number) }} flex items-center justify-center">{{ $question['question'] }}<br/>{{ $number}}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
