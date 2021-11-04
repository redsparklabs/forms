
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $form->name }}
    </h2>
</x-slot>

<div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
         <div>
            <table class="w-1/2 border-collapse m-auto">
                <thead class="table-auto h-[278px]">
                    <tr>
                        <th scope="col" class="align-bottom">GB Member</th>
                        <th scope="col" class="bg-blue-500 border w-10 whitespace-nowrap">
                            <div style="transform: translate(0, 115px) rotate(270deg);" class="w-10">
                                <span class="p-2 text-white ">PROGRESS METRIC</span>
                            </div>
                        </th>
                        @php
                            $questions = collect($questions)->reject(fn($item) => $item['section'] == 'custom');
                        @endphp
                        @foreach($questions as $question)
                            <th scope="col" class="bg-white border w-10 whitespace-nowrap">
                                <div style="transform: translate(0, 115px) rotate(270deg);" class="w-10">
                                    <span class="text-{{ $question['color'] }} p-2">{{ $question['question'] }}</span>
                                </div>
                            </th>
                        @endforeach

                        @php
                            $sections = collect($questions)->groupBy('section')->reject(fn($item, $key) => $key == 'custom');
                        @endphp

                        @foreach($sections->all() as $section => $sectionData)
                            <th scope="col" class="bg-white border w-10 whitespace-nowrap">
                                <div style="transform: translate(0, 115px) rotate(270deg);" class="w-10">
                                    <span class="text-{{ $sectionData->first()['color'] }} p-2">{{ implode(' ', explode('_', $section)) }}</span>
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                        $progressMetricTotal = 0;
                        $sections = collect($questions)->groupBy('section')->reject(fn($item, $key) => $key == 'custom');
                        $sectiontotals = $sections->keys()->mapWithkeys(fn($item) => [$item.'_count' => 0])->all();
                    @endphp
                    @foreach($this->form->responses as $response)
                        <tr class="border">
                            <td class="p-2"> {{ $response->email }} </td>

                            @php
                                $total = 0;
                            @endphp
                            <?php
                                $totalSections = $sections->reject(function($item, $key) {
                                    return $key == 'Intutive_Scoring';
                                })->flatten(1)->count();
                            ?>
                            @foreach($sections->all() as $section => $sectionData)
                                @if($section == 'Intutive_Scoring')
                                    @continue
                                @endif

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
                            <td class="border-2 text-right bg-white p-2">{{ number_format($total / $totalSections, 1) }}</td>

                            @foreach($questions as $question)
                                <td class="border-2 text-center bg-white p-2">{{ Arr::get($response->questions, Str::slug($question['question'])) }}</td>
                            @endforeach

                            @php
                                $sections = collect($questions)->groupBy('section')->reject(fn($item, $key) => $key == 'custom');
                            @endphp

                            @foreach($sections->all() as $section => $sectionData)
                                <td class="border-2 text-center bg-white p-2">
                                    @php
                                        $sectionQuestions = $sectionData->pluck('question')->map(fn($item) => Str::slug($item))->toArray();
                                        $total = collect($response->questions)->filter(function($item, $key) use($sectionQuestions) {
                                            return in_array($key, $sectionQuestions);
                                        })->sum();

                                        $sectiontotals[$section .'_count'] += number_format($total / $sections->count(), 1);
                                        echo number_format($total / $sections->count(), 1);
                                    @endphp
                                </td>
                            @endforeach
                        </tr>
                    @endforeach


                    <tr>
                        <td></td>
                        <td class="border-2 bg-blue-500 text-white font-bold text-right p-2">
                            {{  number_format($progressMetricTotal / $this->form->responses->count(), 1) }}
                        </td>

                        @foreach($questions as $question)
                            <td class="border-2 text-center bg-blue-100 p-2">
                                @php
                                $mappedQuestions = collect($this->form->responses)->map(function ($value) {
                                    return $value->response['questions'];
                                });

                                echo number_format( $mappedQuestions->pluck(Str::slug($question['question']))->sum() / $mappedQuestions->count(), 1);
                                @endphp
                            </td>
                        @endforeach

                        @foreach($sections->all() as $section => $sectionData)
                            <td class="bg-{{ $sectionData->first()['color'] }} border-2 text-center p-2">
                                {{ number_format($sectiontotals[$section .'_count'] / $this->form->responses->count(), 1) }}
                            </td>
                        @endforeach

                    </tr>
                </tbody>
            </table>

           {{--  <table class="w-full border-collapse m-auto mt-10">
                <thead class="table-auto">
                    <tr>
                        <th scope="col"></th>
                        @foreach($feedback_questions as $question)
                            <th scope="col" class="text-left py-2 px-4">
                                <div class="text-lg mb-2">{{ $question['question'] }}</div>
                                <div class="font-normal text-xs">{{ $question['description'] }}</div>
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @foreach($this->form->responses as $response)
                    <tr class="border-b-2 border-black border-solid">
                        <td class="py-2 px-4">{{ $response->email }} </td>
                        @foreach($response->response['questions']['custom'] as $custom)
                            <td class="py-2 px-4"> {{ $custom }} </td>
                        @endforeach
                    </tr>
                    @endforeach
                    <tr>
                        <td class="text-sm italic p-2" colspan="{{ count($feedback_questions) + 1 }}">*Note: All Scores are calculated based on the last Evaluation, they are not a aggregate of all Progress scores.</td>
                    </tr>
                </tbody>
            </table> --}}

            <div class="w-2/3 m-auto mt-10">
                <div class="grid grid-rows- grid-flow-col gap-2">

                     @foreach($questions->where('hidden', false)->sortBy('order')->take(7) as $question)
                        @php
                            $mappedQuestions = collect($this->form->responses)->map(function ($value) {
                                return $value->response['questions'];
                            });
                            $number = number_format( $mappedQuestions->pluck(Str::slug($question['question']))->sum() / $mappedQuestions->count(), 1);
                        @endphp

                        <div class="{{ $question['classes']}} {{ colorize($number) }} flex items-center justify-center">{{ $question['question'] }}<br/>{{ $number}}</div>
                    @endforeach
                </div>


                <div class="grid grid-rows- grid-flow-col gap-2 mt-2">
                     @foreach($questions->where('hidden', false)->sortBy('order')->skip(7)->take(2) as $question)
                        @php
                            $mappedQuestions = collect($this->form->responses)->map(function ($value) {
                                return $value->response['questions'];
                            });
                            $number = number_format( $mappedQuestions->pluck(Str::slug($question['question']))->sum() / $mappedQuestions->count(), 1);
                        @endphp

                        <div class="{{ $question['classes']}} {{ colorize($number) }} flex items-center justify-center">{{ $question['question'] }}<br/>{{ $number}}</div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

