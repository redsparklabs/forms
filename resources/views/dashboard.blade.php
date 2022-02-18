<div>
    <header class="bg-white">
        <div class="px-4 pt-6 pb-10 mx-auto max-w-7xl sm:px-10 lg:px-8">
            <div class="flex">
                <h2 class="flex-1 text-xl font-medium leading-6 text-gray-900 font-bold">
                    {{ $this->user->currentOrganization->name }} {{ __('Portfolio') }}
                </h2>
            </div>
        </div>
    </header>

     <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 pt-5">
        <div class="border shadow relative rounded-lg p-4">
            <canvas id="myChart" width="1025"  role="img" aria-label="" ></canvas>
        </div>
    </div>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 pt-5">
       <div class="grid grid-cols-9 gap-4 mt-5">
            <div class="col-span-2 px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Total Net Present Value (NPV)</dt>

                    {{-- <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $events->each->pivot->pluck('net_projected_value') }}</dd> --}}
            </div>
                   {{--   <div class="col-span-2 px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
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
                    <dt class="text-sm font-medium text-gray-500 truncate">Net Projected Value (NPV)</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">${{ number_format($team->latestEvent()?->pivot?->net_projected_value, 2)}}</dd>
                </div>

                <div class="col-start-4 col-span-3 col-end-7 px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Development Stage</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->latestEvent()?->stage($team->latestEvent()->progressMetric($team))->name }}</dd>
                </div>

                 <div class="col-start-7 col-span-3 px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Project Sponsor</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->sponsor ?? 'N/A'}}</dd>
                </div> --}}
            </div>
    </div>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 pt-5">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                     <div class="flex items-center">
                        <div class="flex-1">
                            <h2 class="font-semibold text-md text-gray-500 leading-tight">
                                {{ __('Protfolio Projects') }}
                            </h2>
                        </div>
                        <div class="w-1/4 mb-2 justify-end">
                            <x-jet-input id="keywords" type="text" class="block w-full mt-1" wire:model="projectsKeyword" :placeholder="__('Search')"/>
                        </div>
                    </div>
                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900" wire:click="sortByProject('name')">
                                        {{ __('Name') }}
                                        @if($teams->count() > 1)
                                            <x-sort :dir="$projectsSortDirection" :active="$projectsSortByField == 'name'"/>
                                        @endif
                                    </th>
                                     <th scope="col" class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900" wire:click="sortBy('start_date')">
                                        {{ __('Start Date') }}
                                        @if($teams->count() > 1)
                                            <x-sort :dir="$projectsSortDirection" :active="$projectsSortByField == 'start_date'"/>
                                        @endif
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        {{ __('Progress Metric') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900">
                                        {{ __('NPV') }}
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($teams as $team)
                                    <tr @class([
                                        'bg-white' => $loop->odd,
                                        'bg-gray-50' => $loop->even
                                    ])>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                            {{ $team->name }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                            {{ $team->start_date?->format('m/d/y') ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-500 whitespace-nowrap">
                                            @if($team->latestEvent())
                                                <span class="font-bold text-lg text-{{ colorize($team->latestEvent()?->progressMetric($team)) }}">{{ $team->latestEvent()?->progressMetric($team) }}</span>
                                            @else
                                                {{ __('N/A') }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-500 whitespace-nowrap">
                                            ${{ number_format($team->latestEvent()?->pivot?->net_projected_value, 2)}}
                                        </td>
                                         <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                            <x-buttons.green-link href="{{ route('teams.show', $team->id) }}">{{ __('View Project') }}</x-buttons.green-link>
                                        </td>
                                    </tr>
                                @empty
                                    @if(!$projectsKeyword)
                                        <tr class="bg-white">
                                        <td class="px-6 py-4 text-sm font-medium text-center text-gray-500 whitespace-nowrap" colspan="4">
                                            {{ __('No Projects created.')}} {{ __('Go ahead and') }} <a class="text-blue-500 underline" href="{{route('teams.index', 'create') }}">{{ __('add one') }}</a>!
                                        </td>
                                    </tr>
                                    @else
                                        <tr class="bg-white">
                                            <td class="px-6 py-4 text-sm font-medium text-center text-gray-500 whitespace-nowrap" colspan="4">
                                                {{ __('No Projects found.') }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforelse
                            </tbody>
                        </table>
                        @if($teams->hasPages())
                            <div class="p-4">
                                {{ $teams->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div<>


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
                    {{-- "{!! $teams->sortBy('date')->map(fn($team) => $team->events()->pluck('date')->date->format('M'))->implode('","') !!}" --}}
                ],
                datasets: [
                    @foreach($teams as $team)
                    {
                        label: "{!! $team->name !!}",
                        tension: .5,
                        borderColor: "#00c241",
                        borderWidth: 3,
                        backgroundColor: "#00c241",
                        data: [
                            {{ $team->events()->get()->map(fn($e) => $e->progressMetric($team))->implode(',') }}
                        ],
                    },
                    @endforeach
                ]
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
                    },
                    legend: {
                        position: 'bottom'
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
