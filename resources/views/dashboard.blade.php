<div class="mb-5">
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
       <div class="grid grid-cols-3 gap-4 mt-5">
            <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Total Net Present Value (NPV)</dt>
                <dd class="text-lg font-semibold text-gray-900 flex items-center m-6 justify-center">
                    ${{ number_format($teams->get()->map(fn($team) => $team->latestEvent()?->pivot->net_projected_value)->sum(), 2) }}
                </dd>
                <dt class="text-sm font-medium text-gray-500 truncate">Average NPV</dt>
                <dd class="text-lg font-semibold text-gray-900 flex items-center m-6 justify-center">
                    ${{ number_format($teams->get()->map(fn($team) => $team->latestEvent()?->pivot->net_projected_value)->sum() / $teams->count(), 2) }}
                </dd>

            </div>
            <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Total Investment To Date</dt>
                <dd class="text-lg font-semibold text-gray-900 flex items-center m-6 justify-center">
                    ${{ number_format($teams->get()->map(fn($team) => $team->latestEvent()?->pivot->investment)->sum(), 2) }}
                </dd>
                <dt class="text-sm font-medium text-gray-500 truncate">Average Investment To Date</dt>
                <dd class="text-lg font-semibold text-gray-900 flex items-center m-6 justify-center">
                    ${{ number_format($teams->get()->map(fn($team) => $team->latestEvent()?->pivot->investment)->sum() / $teams->count(), 2) }}
                </dd>
            </div>

             <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Investment to NPV Ratio</dt>
                <dd class="text-lg font-semibold text-gray-900 flex items-center m-6 justify-center">
                    @php
                        $avg_npv = $teams->get()->map(fn($team) => $team->latestEvent()?->pivot->net_projected_value)->sum() / $teams->count();
                        $avg_investment = $teams->get()->map(fn($team) => $team->latestEvent()?->pivot->investment)->sum() / $teams->count();
                        if( $avg_npv > 0 && $avg_investment > $avg_npv) {
                            $f = farey($avg_investment / $avg_npv);
                            echo $f[0]. ':' .$f[1];
                        } else {
                            echo 'N/A';
                        }

                    @endphp

                </dd>
            </div>

            <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Average Portfolio Progress Metric</dt>
                <dd class="text-lg font-semibold text-gray-900 flex items-center m-6 justify-center">
                    {{ number_format($teams->get()->map(fn($team) => $team->latestEvent()?->progressMetric($team))->sum() / $teams->count(), 2) }}
                </dd>
            </div>

            <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Average Stage of Development</dt>
                <dd class="text-lg font-semibold text-gray-900 flex items-center m-6 justify-center">
                    {{  stage($teams->get()->map(fn($team) => $team->latestEvent()?->progressMetric($team))->sum() / $teams->count())?->name }}<br/>
                </dd>
            </div>

             <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Next Estimated Launch</dt>
                <dd class="text-lg font-semibold text-gray-900 flex items-center m-6 justify-center">
                    {{ $teams->get()->first()?->name }}<br/>
                    Q{{ $teams->get()->first()?->estimated_launch_date?->quarter }} | {{ $teams->get()->first()?->estimated_launch_date?->format('Y') }}

                </dd>
            </div>

        </div>
    </div>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 pt-5" x-cloak x-data="{ activeTab:  0 }">
        <div class="flex z-0 relative top-0.5 ">
            <a @click="activeTab = 0;" class="shadow border-gray-100 border-l border-t border-r border-gray-200  px-4 py-2 cursor-pointer rounded-tl-md rounded-tr-md text-sm font-medium text-gray-500 truncate" :class="activeTab == 0 ? 'text-gray-900' : 'border-b'">Projects</a>

            <a @click="activeTab = 1" class="shadow relative border-l border-t border-r border-gray-200 px-4 py-2 cursor-pointer rounded-tl-md rounded-tr-md ml-1 text-sm font-medium text-gray-500 truncate" :class="activeTab == 1 ? 'text-gray-900' : 'border-b'">Assessment History</a>

        </div>

        <div class="border-gray-100 border-l border-b border-r shadow relative rounded-tr-md rounded-b-md p-4 z-10 bg-white" :class="{ 'active': activeTab === 0 }" x-show.transition.in.opacity.duration.600="activeTab === 0">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                             <div class="flex items-center">
                                <div class="flex-1">
                                    <h2 class="font-semibold text-md text-gray-500 leading-tight">
                                        {{-- {{ __('Projects') }} --}}
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
                                                @if($teamsPaginated->count() > 1)
                                                    <x-sort :dir="$projectsSortDirection" :active="$projectsSortByField == 'name'"/>
                                                @endif
                                            </th>
                                             <th scope="col" class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900" wire:click="sortByProject('start_date')">
                                                {{ __('Start Date') }}
                                                @if($teamsPaginated->count() > 1)
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
                                        @forelse ($teamsPaginated as $team)
                                            <tr @class([
                                                'bg-white' => $loop->odd,
                                                'bg-gray-50' => $loop->even
                                            ])>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-500 whitespace-nowrap">
                                                    {{ $team->name }}
                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-500 whitespace-nowrap">
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
                                @if($teamsPaginated->hasPages())
                                    <div class="p-4">
                                        {{ $teamsPaginated->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-gray-100 border-l border-b border-r shadow relative rounded-tr-md rounded-b-md p-4 z-10 bg-white" :class="{ 'active': activeTab === 1 }" x-show.transition.in.opacity.duration.600="activeTab === 1">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                             <div class="flex items-center">
                                <div class="flex-1">
                                    <h2 class="font-semibold text-md text-gray-500 leading-tight">
                                        {{-- {{ __('Assessment History') }} --}}
                                    </h2>
                                </div>
                                <div class="w-1/4 mb-2 justify-end">
                                    <x-jet-input id="keywords" type="text" class="block w-full mt-1" wire:model="eventsKeyword" :placeholder="__('Search')"/>
                                </div>
                            </div>
                            <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900" wire:click="sortByEvent('name')">
                                                {{ __('Name') }}
                                                @if($events->count() > 1)
                                                    <x-sort :dir="$eventsSortDirection" :active="$eventsSortByField == 'name'"/>
                                                @endif
                                            </th>
                                             <th scope="col" class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900" wire:click="sortByEvent('start_date')">
                                                {{ __('Start Date') }}
                                                @if($events->count() > 1)
                                                    <x-sort :dir="$eventsSortDirection" :active="$eventsSortByField == 'start_date'"/>
                                                @endif
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900">
                                                {{ __('Location') }}
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">

                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($events as $event)
                                            <tr @class([
                                                'bg-white' => $loop->odd,
                                                'bg-gray-50' => $loop->even
                                            ])>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-500 whitespace-nowrap">
                                                    {{ $event->name }}
                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-500 whitespace-nowrap">
                                                    {{ $event->date?->format('m/d/y') ?? 'N/A' }}
                                                </td>

                                                <td class="px-6 py-4 text-sm font-medium text-gray-500 whitespace-nowrap">
                                                    {{ $event->department ? $event->department : 'N/A' }}
                                                </td>
                                                 <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                                    <x-buttons.green-link href="{{ route('events.show', $event->id) }}">{{ __('View Details') }}</x-buttons.green-link>
                                                </td>
                                            </tr>
                                        @empty
                                            @if(!$eventsKeyword)
                                                <tr class="bg-white">
                                                <td class="px-6 py-4 text-sm font-medium text-center text-gray-500 whitespace-nowrap" colspan="4">
                                                    {{ __('No Projects created.')}} {{ __('Go ahead and') }} <a class="text-blue-500 underline" href="{{route('events.index', 'create') }}">{{ __('add one') }}</a>!
                                                </td>
                                            </tr>
                                            @else
                                                <tr class="bg-white">
                                                    <td class="px-6 py-4 text-sm font-medium text-center text-gray-500 whitespace-nowrap" colspan="4">
                                                        {{ __('No Assessments found found.') }}
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
    </div>
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
                    {{-- "{!! $teams->sortBy('date')->map(fn($team) => $team->events()->pluck('date')->date->format('M'))->implode('","') !!}" --}}
                ],
                datasets: [
                    @foreach($teams->get() as $team)
                    {
                        label: "{!! $team->name !!}",
                        tension: .5,
                        borderColor: '{{ array_rand(array_flip(['#67cc58', '#b8d99b', '#93c66e', '#6a9e4a', '#11af3b', '#00c241'])) }}',
                        borderWidth: 3,
                        backgroundColor: '{{ array_rand(array_flip(['#67cc58', '#b8d99b', '#93c66e', '#6a9e4a', '#11af3b', '#00c241'])) }}',
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
                        title: {
                          display: true,
                          text: 'Progress Metric'
                        }
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
