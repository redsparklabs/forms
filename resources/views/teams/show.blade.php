<div>
    <header class="bg-white shadow">
        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
             <div class="flex">
                <div class="w-full">
                    <div>
                        <div class="flex">
                            <h2 class="flex-1 text-xl font-medium leading-6 text-gray-900">Project - {{ $team->name }}</h2>
                            <div>
                                @if (Gate::check('updateTeam', $organization))
                                    <button class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 cursor-pointer" wire:click="confirmUpdate('{{ $team->id }}')">
                                        {{ __('Update') }}
                                    </button>
                                @endif

                                 @if (Gate::check('removeTeam', $organization))
                                    <button class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" wire:click="confirmDestroy('{{ $team->id }}')">
                                        {{ __('Archive') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                        <dl class="grid grid-rows-3 grid-flow-col gap-4 mt-5">
                            <div class="row-span-3 px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                                <div class="flex items-center justify-center" x-data="{ circumference: 2 * 22 / 7 * 120 }">
                                    <svg class="transform -rotate-90 w-72 h-72">
                                        <circle cx="145" cy="145" r="120" stroke="currentColor" stroke-width="15" fill="transparent" class="text-gray-700" />

                                        <circle cx="145" cy="145" r="120" stroke="currentColor" stroke-width="15" fill="transparent"
                                            :stroke-dasharray="circumference"
                                            :stroke-dashoffset="circumference - ({{$team->latest_progress_metric}} * 20) / 100 * circumference"
                                            class="text-blue-500" />
                                    </svg>
                                    <span class="absolute text-5xl bg-yellow-400 rounded-full w-12 h-12 text-center" x-text="{{ $team->latest_progress_metric }}"></span>
                                </div>

                            </div>

                            <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Project Start Date:</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->start_date->format('m/d/y') }}</dd>
                            </div>
                             <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Priority Level:</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->priority_level ?? 'N/A' }}</dd>
                            </div>

                            <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Investment To Date:</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->latestPivot()?->investment ?? 'N/A'}}</dd>
                            </div>
                            <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">NPV:</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->latestPivot()?->net_projected_value ?? 'N/A'}}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div>
        <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-jet-action-section :background="false">
                <x-slot name="title">
                    {{ __('Growth Boards') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('All of the Growth Boards that are part of this project.') }}
                </x-slot>

                <x-slot name="content">
                        <div class="w-full">
                            <canvas id="myChart" width="1025" height="400" role="img" aria-label="" ></canvas>
                        </div>

                   <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <div class="flex justify-end">
                                    <div class="w-1/4 mb-2">
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
                                                {{ __('Net Project Value') }}
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
                                                        <div class="w-10 p-2 font-bold text-center text-white bg-blue-500">
                                                            {{ $event->progressMetric($team) }}
                                                        </div>
                                                    </td>
                                                     <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                        {{ $event->teams->find($team->id)->pivot->net_projected_value ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                                        <a class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('events.results',[$event->id, $event->latestForm()->id, $team->id]) }}">
                                                            {{ __('View Results') }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                @if(!$keyword)
                                                     <tr class="bg-white">
                                                        <td class="px-6 py-4 text-sm font-medium text-center text-gray-500 whitespace-nowrap" colspan="5">
                                                            No Growth Boards created. Go ahead and <a class="text-blue-500 underline" href="{{ route('events.index', 'create') }}">{{ __('create one') }}</a>!
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
                </x-slot>
            </x-jet-action-section>
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
                    "{!! $events->sortBy('date')->map(fn($item) => $item->date->format('m/d/y'))->implode('","') !!}"
                ],
                datasets: [{
                    tension: 0.1,
                    fill: true,
                    label: 'Progress',
                    borderColor: "blue",
                    yAxisID: 'y',
                    data: [
                        {{ $events->sortBy('date')->map(fn($item) => $item->progressMetric($team))->implode(',') }}
                    ],
                    // fill: true,
                    // pointBackgroundColor: "#4A5568",
                    // borderWidth: "3",
                    // pointBorderWidth: "4",
                    // pointHoverRadius: "6",
                    // pointHoverBorderWidth: "8",
                    // pointHoverBorderColor: "rgb(74,85,104,0.2)"
                }, {
                    label: 'Net Projected Value',
                    borderColor: "red",
                    // yAxisID: 'y1',
                    data: [
                        {{ $events->sortBy('date')->map(fn($item) => (string) $item->pivot?->net_projected_value)->implode(',') }}
                    ],
                },{
                    label: 'Investment',
                    borderColor: "green",
                    // yAxisID: 'y2',
                    data: [
                        {{ $events->sortBy('date')->map(fn($item) => (string) $item->pivot?->investment)->implode(',') }}
                    ],
                }]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                // stacked: false,
                plugins: {
                    // title: {
                    //     display: true,
                    //     text: 'Chart.js Line Chart - Multi Axis'
                    // }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',

                    },
                    // y1: {
                    //     // position: 'left',
                    //     // display: true,
                    //     type: 'logarithmic'
                    // },
                    // y2: {
                    //     // position: 'right',
                    //     // display: true,
                    //     type: 'logarithmic'

                    // }

                }
            }
        });
    };
    </script>
@endpush
