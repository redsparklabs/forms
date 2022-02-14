<div>
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

                    {{-- <x-growth-circle :color="$team->stage()->color" :metric="$team->latest_progress_metric" /> --}}

                    <div class="flex items-center justify-center">
                        @php
                            $circumference = 2 * 22 / 7 * 120;
                        @endphp
                        <svg class="transform -rotate-90 w-72 h-72">
                            <circle cx="145" cy="145" r="120" stroke="currentColor" stroke-width="30" fill="transparent" class="text-gray-100" />

                            <circle cx="145" cy="145" r="120" stroke="currentColor" stroke-width="30" fill="transparent"
                                stroke-dasharray="{{ $circumference }}"
                                stroke-dashoffset="{{ $circumference - ($team->latest_progress_metric * 20) / 100 * $circumference }}"
                                class="text-{{ $team->stage()->color}}" />
                        </svg>
                        <div class="flex items-center justify-center absolute text-5xl bg-{{ $team->stage()->color }} text-white rounded-full w-32 h-32 text-center p-4">{{ number_format($team->latest_progress_metric, 1) }}</div>
                    </div>

                    <div class="flex mt-4">
                        <div class="flex-1 p-2 text-white font-bold text-center bg-karban-green-2">1</div>
                        <div class="flex-1 p-2 text-white font-bold text-center bg-karban-green-3">2</div>
                        <div class="flex-1 p-2 text-white font-bold text-center bg-karban-green-4">3</div>
                        <div class="flex-1 p-2 text-white font-bold text-center bg-karban-green-5">4</div>
                        <div class="flex-1 p-2 text-white font-bold text-center bg-karban-green-6">5</div>
                    </div>

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
                    <dd class="mt-1 text-sm font-semibold text-gray-900">${{ number_format($team->latestPivot()?->investment, 2) ?? 'N/A'}}</dd>
                </div>

                 <div class="col-start-7 col-span-3 x-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Net Present Value (NPV)</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">${{ number_format($team->latestPivot()?->net_projected_value, 2) ?? 'N/A'}}</dd>
                </div>

                <div class="col-start-4 col-span-3 col-end-7 px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Development Stage</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->stage()->name }}</dd>
                </div>

                 <div class="col-start-7 col-span-3 px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Project Sponsor</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->sponsor ?? 'N/A'}}</dd>
                </div>
            </div>
        </div>
    </header>


    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="shadow rounded p-4">
            <div class="text-md font-medium text-gray-500 truncate">Progress Metrics</div>
            <canvas id="myChart" width="1025"  role="img" aria-label="" ></canvas>
        </div>
    </div>


    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 pt-10">
        <div class="flex">
            <div class="mr-12 flex-1 gap-4 shadow p-4 rounded">
                <div class="text-md font-medium text-gray-500 truncate mb-4">Business Model Development</div>
                <div class="grid grid-flow-col grid-rows-2 gap-1 w-full">
                    @php
                        $responses = $team->latestform()?->responses()->where('team_id', $team->id)->get();
                    @endphp
                    @if($responses)
                        @foreach($team->latestform()->allQuestions()->where('hidden', false)->sortBy('order')->take(7) as $question)
                            @php
                                $number = 0;
                                $mappedResponses = collect($responses)->map(fn ($value) => $value->response['questions']);
                                if($mappedResponses->pluck(Str::slug($question['question']))->sum() > 0) {
                                    $number = number_format( $mappedResponses->pluck(Str::slug($question['question']))->sum() / $mappedResponses->count(), 1);
                                }

                            @endphp
                            <div class="{{ $question['classes'] }} bg-{{ colorize($number) }} flex items-center justify-center text-center p-4 text-white font-bold py-8 rounded">{{ $number}}</div>
                        @endforeach
                    @endif
                </div>

                <div class="grid grid-flow-col grid-rows-2 gap-1 mt-1 w-full">
                    @if($responses)
                         @foreach($team->latestform()->allQuestions()->where('hidden', false)->sortBy('order')->skip(7)->take(2) as $question)
                            @php
                                $mappedResponses = collect($responses)->map(function ($value) {
                                    return $value->response['questions'];
                                });
                                $number = 0;
                                if($mappedResponses->pluck(Str::slug($question['question']))->sum()) {
                                    $number = number_format( $mappedResponses->pluck(Str::slug($question['question']))->sum() / $mappedResponses->count(), 1);
                                }
                            @endphp

                            <div class="{{ $question['classes']}} bg-{{ colorize($number) }} flex text-center items-center justify-center text-white font-bold py-8 rounded">{{ $number}}</div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="flex-1 shadow p-4 rounded">
                <div class="text-md font-medium text-gray-500 truncate">Stage of Development</div>
                <div class="text-lg font-semibold my-2">{{ $team->stage()->name }}</div>
                <div>{{ $team->stage()->description }}</div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 pt-10">
        <div class="shadow rounded p-4">

            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">

                        <div class="flex items-center">
                            <div class="flex-1 w-2/3 text-md font-medium text-gray-500 truncate">{{ __('Assessment History') }}</div>
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
                                                <x-buttons.green-link text="View Results" href="{{ route('events.results',[$event->id, $event->latestForm()->id, $team->id]) }}" />
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
