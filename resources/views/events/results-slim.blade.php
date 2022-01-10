
<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
        slim
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



        <tr>
            <td class="p-2 font-bold text-right text-white bg-blue-500 border-2">
                {{ $progressMetricTotal }}
            </td>

            @foreach($questions as $question)
                <td class="p-2 text-center bg-blue-100 border-2">
                    @php
                        $mappedQuestions = collect($responses)->map(fn ($value) => $value->response['questions']);

                        if( $mappedQuestions->pluck(Str::slug($question['question']))->sum() > 0) {
                            echo number_format( $mappedQuestions->pluck(Str::slug($question['question']))->sum() / $mappedQuestions->count(), 1);
                        }

                    @endphp
                </td>
            @endforeach

            @foreach($sections->all() as $section => $sectionData)
                <td class="bg-{{ $sectionData->first()['color'] }} border-2 text-center p-2">
                    @if($sectionTotals[$section .'_count'])
                        {{ number_format($sectionTotals[$section .'_count'] / $responses->count(), 1) }}
                    @endif
                </td>
            @endforeach
        </tr>
</x-app-layout>
