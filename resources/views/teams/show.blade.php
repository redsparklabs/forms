<div class="mb-5">
    <header class="bg-white">
        <div class="px-4 pt-6 pb-10 mx-auto max-w-7xl sm:px-10 lg:px-8">
            <div class="flex">
                <h2 class="flex-1 text-xl font-medium leading-6 text-gray-900 font-bold">{{ __('Project') }} - {{ $team->name }}</h2>

                <div>
                    @if (Gate::check('updateTeam', $organization))
                        <x-buttons.green text="Update" wire:click="confirmUpdate('{{$team->id}}')" />
                    @endif

                     @if (Gate::check('removeTeam', $organization))
                        <x-buttons.red text="Archive" wire:click="confirmDestroy('{{$team->id}}')" />
                    @endif
                </div>
            </div>
            <div class="mt-3">
                <span class="text-gray-500 text-sm">{{ $team->description }}</span>
            </div>

            <div class="grid grid-cols-9 gap-4 mt-5">
                <div class="row-span-3 col-span-3 px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                    <span class="inline-block text-sm font-medium text-gray-500 mb-2">Latest Progress Metric</span>

                    <div class="flex items-center justify-center">
                        @php
                            $circumference = 2 * 22 / 7 * 120;
                        @endphp
                        <svg class="transform -rotate-90 w-72 h-72">

                            <circle cx="145" cy="145" r="120" stroke="currentColor" stroke-width="30" fill="transparent" class="text-gray-100" />

                            <circle cx="145" cy="145" r="120" stroke="currentColor" stroke-width="30" fill="url('#myGradient')"
                                stroke-dasharray="{{ $circumference }}"
                                stroke-dashoffset="{{ $circumference - ($team->latestEvent()?->progressMetric($team) * 20) / 100 * $circumference }}"
                                class="text-{{ $team->latestEvent()?->stage($team->latestEvent()?->progressMetric($team))->color}}" />
                        </svg>
                        <div class="flex items-center justify-center absolute text-5xl bg-{{ $team->latestEvent()?->stage($team->latestEvent()?->progressMetric($team))->color }} text-white rounded-full w-32 h-32 text-center p-4">{{ number_format($team->latestEvent()?->progressMetric($team), 1) }}</div>
                    </div>
                   {{--  <div class="flex items-center justify-center">
                        <div class="h-72 w-72 rounded-full bg-gradient-to-l from-karban-green-2 to-{{ $team->latestEvent()?->stage($team->latestEvent()?->progressMetric($team))->color }} flex items-center justify-center">
                            <div class="h-56 w-56 bg-white rounded-full flex items-center justify-center">
                                <div class="flex items-center justify-center h-36 w-36 rounded-full text-white text-5xl bg-{{ $team->latestEvent()?->stage($team->latestEvent()?->progressMetric($team))->color }}">{{ number_format($team->latestEvent()?->progressMetric($team), 1) }}</div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="flex mt-4">
                        <div class="flex-1 p-2 text-white font-bold text-center bg-karban-green-2">1</div>
                        <div class="flex-1 p-2 text-white font-bold text-center bg-karban-green-3">2</div>
                        <div class="flex-1 p-2 text-white font-bold text-center bg-karban-green-4">3</div>
                        <div class="flex-1 p-2 text-white font-bold text-center bg-karban-green-5">4</div>
                        <div class="flex-1 p-2 text-white font-bold text-center bg-karban-green-6">5</div>
                    </div>
                    {{-- <div class="flex mt-4 bg-gradient-to-r from-karban-green-2 to-karban-green-6">
                        <div class="flex-1 p-2 text-white font-bold text-center">1</div>
                        <div class="flex-1 p-2 text-white font-bold text-center">2</div>
                        <div class="flex-1 p-2 text-white font-bold text-center">3</div>
                        <div class="flex-1 p-2 text-white font-bold text-center">4</div>
                        <div class="flex-1 p-2 text-white font-bold text-center">5</div>
                    </div> --}}

                </div>


                <div class="col-span-2 px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Project Start Date</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->start_date?->format('m/d/y') ?? 'N/A' }}</dd>
                </div>
                 <div class="col-span-2 px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Estimated Launch</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">
                        @if($team->estimated_launch_date)
                            Q{{ $team->estimated_launch_date?->quarter }} {{ $team->estimated_launch_date?->format('Y') }}
                        @else
                            N/A
                        @endif
                    </dd>
                </div>

                 <div class="col-span-2 px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Minimum Success Criteria</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->minimum_success_criteria ?? 'N/A' }}</dd>
                </div>

                <div class="col-start-4 col-span-3 col-end-7 px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Investment To Date</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">${{ number_format($team->latestEvent()?->pivot?->investment, 2)}}</dd>
                </div>

                 <div class="col-start-7 col-span-3 x-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Net Present Value (NPV)</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">${{ number_format($team->latestEvent()?->pivot?->net_projected_value, 2)}}</dd>
                </div>

                <div class="col-start-4 col-span-3 col-end-7 px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Development Stage</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->latestEvent()?->stage($team->latestEvent()->progressMetric($team))->name }}</dd>
                </div>

                 <div class="col-start-7 col-span-3 px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Project Sponsor</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->sponsor ?? 'N/A'}}</dd>
                </div>
            </div>
        </div>
    </header>


    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 pt-5" x-cloak x-data="{ activeTab:  0 }">
        <div class="flex z-0 relative top-0.5 ">
            <a @click.prevent="activeTab = 0;" class="shadow border-gray-100 border-l border-t border-r border-gray-200  px-4 py-2 cursor-pointer rounded-tl-md rounded-tr-md text-sm font-medium text-gray-500 truncate" :class="activeTab == 0 ? 'text-gray-900' : 'border-b'">Progress Metrics</a>

            <a @click.prevent="activeTab = 1" class="shadow relative border-l border-t border-r border-gray-200 px-4 py-2 cursor-pointer rounded-tl-md rounded-tr-md ml-1 text-sm font-medium text-gray-500 truncate" :class="activeTab == 1 ? 'text-gray-900' : 'border-b'">Assessment History</a>

            <a @click.prevent="activeTab = 2" class="shadow relative border-l border-t border-r border-gray-200 px-4 py-2 cursor-pointer rounded-tl-md rounded-tr-md ml-1 text-sm font-medium text-gray-500 truncate" :class="activeTab == 2 ? 'text-gray-900' : 'border-b'">Business Model Progression</a>
        </div>

        <div class="border-gray-100 border-l border-b border-r shadow relative rounded-tr-md rounded-b-md p-4 z-10 bg-white" :class="{ 'active': activeTab === 0 }" x-show.transition.in.opacity.duration.600="activeTab === 0">
            <canvas id="myChart" width="1025"  role="img" aria-label="" ></canvas>
        </div>
        <div class="border-gray-100 border-l border-b shadow relative rounded-tr-md rounded-b-md p-4 z-10 bg-white" :class="{ 'active': activeTab === 1 }" x-show.transition.in.opacity.duration.600="activeTab === 1">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">

                        <div class="flex items-center">
                            <div class="flex-1"></div>
                            <div class="flex-initial w-1/4 mb-2 justify-end">
                                <x-jet-input id="keywords" type="text" class="block w-full mt-1" wire:model="keyword" :placeholder="__('Search')"/>
                            </div>
                        </div>
                        <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900" wire:click="sortBy('name')">
                                        {{ __('Name') }}
                                        @if($events->count() > 1)
                                            <x-sort :dir="$sortDirection" :active="$sortByField == 'name'"/>
                                        @endif
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900" wire:click="sortBy('date')">
                                        {{ __('Date') }}
                                        @if($events->count() > 1)
                                            <x-sort :dir="$sortDirection" :active="$sortByField == 'date'"/>
                                        @endif
                                    </th>
                                     <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        {{ __('Progress Metric') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        {{ __('NPV') }}
                                    </th>

                                    <th scope="col" class="relative px-6 py-3 text-right"></th>
                                </thead>
                                <tbody>
                                    @forelse ($events as $event)
                                        <tr @class([
                                            'bg-white' => $loop->odd,
                                            'bg-gray-50' => $loop->even
                                        ])>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                {{ $event->name }}
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                {{ $event->date->format('m/d/y') }}
                                            </td>
                                             <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                <span class="font-bold text-lg text-{{ colorize($event->progressMetric($team)) }}">{{ $event->progressMetric($team) }}</span>
                                            </td>
                                             <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                ${{ number_format($event->teams->find($team->id)->pivot->net_projected_value, 2) ?? 'N/A' }}
                                            </td>
                                              <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                              @if($event->progressMetric($team) > 0)
                                                    <x-buttons.green-link href="{{ route('events.results', [$event->id, $team->id]) }}">  {{ __('View Results') }}</x-buttons.green-link>
                                                @else
                                                    <x-buttons.yellow>Awaiting Results</x-buttons.green>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        @if(!$keyword)
                                             <tr class="bg-white">
                                                <td class="px-6 py-4 text-sm font-medium text-center text-gray-500 whitespace-nowrap" colspan="5">
                                                    No assessments available. Go ahead and <a class="text-blue-500 underline" href="{{ route('events.index', 'create') }}">{{ __('create one') }}</a>!
                                                </td>
                                            </tr>
                                        @else
                                            <tr class="bg-white">
                                                <td class="px-6 py-4 text-sm font-medium text-center text-gray-500 whitespace-nowrap" colspan="5">
                                                    {{ __('No Growth Boards found.') }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforelse
                                </tbody>
                            </table>
                            @if($events->hasPages())
                                <div class="p-4">
                                    {{ $events->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-gray-100 border-l border-b shadow relative rounded-tr-md rounded-b-md p-4 z-10 bg-white" :class="{ 'active': activeTab === 2}" x-show.transition.in.opacity.duration.600="activeTab === 2">

            <div class="flex">
                <div class="mr-12 flex-1 gap-4 shadow p-4 rounded">
                    <div class="text-md font-medium text-gray-500 truncate mb-4">Business Model Development</div>
                    <div class="grid grid-flow-col grid-rows-2 gap-1 w-full">
                        @php
                        // @dd($team);
                            $responses = $team->latestEvent()?->responses()->where('team_id', $team->id)->get();
                        @endphp
                        @if($responses)
                            @foreach($team->latestEvent()->latestForm()->allQuestions()->where('hidden', false)->sortBy('order')->take(7) as $i => $question)
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
                                            <div>{{ $number}}</div>
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
                             @foreach($team->latestEvent()->latestForm()->allQuestions()->where('hidden', false)->sortBy('order')->skip(7)->take(2) as $i => $question)
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
                                            <div>{{ $number}}</div>
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
                <div class="flex-1 shadow p-4 rounded">
                    <div class="text-md font-medium text-gray-500 truncate">Stage of Development</div>
                    <div class="text-lg font-semibold my-2">{{ $team->latestEvent()?->stage($team->latestEvent()->progressMetric($team))->name }}</div>
                    <div>{{ $team->latestEvent()?->stage($team->latestEvent()->progressMetric($team))->description }}</div>
                </div>
            </div>
        </div>
    </div>



    @include('teams._update')
    @include('teams._destroy')
</div>

@push('scripts')

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>
    <script>
    window.load = loadGraph()

    window.livewire.on('reload_graph', () => {
        loadGraph()
    })

    function loadGraph() {
        const chart = new Chart(document.getElementById("myChart"), {
            type: "line",
            data: {
                labels: [
                    "{!! $events->sortBy('date')->map(fn($item) => $item->date->format('M'))->implode('","') !!}"
                ],
                datasets: [{
                    label: 'Progress Metric',
                    tension: .5,
                    borderColor: "#00c241",
                    borderWidth: 3,
                    backgroundColor: "#00c241",
                    yAxisID: 'y',
                    data: [
                        {{ $events->sortBy('date')->map(fn($item) => $item->progressMetric($team))->implode(',') }}
                    ],
                },{
                    label: 'Investment to Date',
                    tension: .5,
                    borderColor: "#61aa8d",
                    borderWidth: 3,
                    backgroundColor: "#61aa8d",
                    yAxisID: 'y2',
                    data: [
                        {{ $events->sortBy('date')->map(fn($item) => (string) $item->pivot?->investment)->implode(',') }}
                    ],
                },{
                    label: 'NPV',
                    tension: .5,
                    borderColor: "#154214",
                    borderWidth: 3,
                    backgroundColor: "#154214",
                    yAxisID: 'y1',
                    data: [
                        {{ $events->sortBy('date')->map(fn($item) => (string) $item->pivot?->net_projected_value)->implode(',') }}
                    ],
                }]
            },
            options: {
                animations: {
                  radius: {
                    duration: 400,
                    easing: 'linear',
                    loop: (context) => context.active
                  }
                },

                hoverRadius: 4,
                hoverBackgroundColor: '#b8d99b',
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    title: {
                        display: false,
                        text: 'Progress Metrics'
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        min: 0,
                        max: 5,
                        ticks: {
                            stepSize: 1
                        },

                    },
                    y1: {
                        position: 'left',
                        display: false,
                        type: 'logarithmic'
                    },
                    y2: {
                        position: 'right',
                        display: false,
                        type: 'logarithmic'
                    }
                }
            }
        });
    };
    </script>
@endpush
