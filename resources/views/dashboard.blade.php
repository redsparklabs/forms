<div class="mb-5">
    <header class="bg-gradient-to-r from-green-600 to-emerald-700 shadow-lg">
        <div class="px-4 pt-8 pb-6 mx-auto max-w-7xl sm:px-10 lg:px-8">
            <div class="flex">
                <h2 class="flex-1 text-3xl font-bold leading-6 text-white tracking-tight">
                    @if(isset($isProjectScopedUser) && $isProjectScopedUser)
                        {{ __('My Projects Dashboard') }}
                    @else
                        {{ $this->user->currentOrganization->name }} {{ __('Portfolio Dashboard') }}
                    @endif
                </h2>
            </div>
            <p class="mt-2 text-green-100 text-lg">
                Business Model Evidence Assessment Overview
            </p>
        </div>
    </header>

    <!-- Key Metrics Above Chart -->
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 pt-6">
       <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="px-6 py-8 overflow-hidden bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gray-600 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="h-1 w-16 bg-gray-500 rounded-full"></div>
                </div>
                <dt class="text-sm font-medium text-gray-600 truncate mb-2">Average Portfolio Progress Metric</dt>
                <dd class="text-3xl font-bold text-gray-700">
                    @if($teams->count() > 0)
                        {{ number_format($teams->get()->map(fn($team) => $team->latestEvent()?->progressMetric($team))->sum() / $teams->count(), 2)
                        }}
                    @endif
                </dd>
            </div>

            <div class="px-6 py-8 overflow-hidden bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gray-700 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="h-1 w-16 bg-gray-600 rounded-full"></div>
                </div>
                <dt class="text-sm font-medium text-gray-600 truncate mb-2">Average Stage of Development</dt>
                <dd class="text-2xl font-bold text-gray-700">
                    @if($teams->count() > 0)
                        {{  stage($teams->get()->map(fn($team) => $team->latestEvent()?->progressMetric($team))->sum() / $teams->count())?->name }}
                    @endif
                </dd>
            </div>

            <div class="px-6 py-8 overflow-hidden bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-green-700 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="h-1 w-16 bg-green-600 rounded-full"></div>
                </div>
                <dt class="text-sm font-medium text-gray-600 truncate mb-2">Total Investment To Date</dt>
                <dd class="text-3xl font-bold text-green-700 mb-4">
                    ${{ number_format($teams->get()->map(fn($team) => $team->latestEvent()?->pivot->investment)->sum(), 2) }}
                </dd>
                <dt class="text-sm font-medium text-gray-500 truncate mb-1">Average Investment To Date</dt>
                <dd class="text-xl font-semibold text-gray-700">
                    @if( $teams->count() > 0)
                        ${{ number_format($teams->get()->map(fn($team) => $team->latestEvent()?->pivot->investment)->sum() / $teams->count(), 2) }}
                    @endif
                </dd>
            </div>
        </div>
    </div>

     <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="bg-white border border-gray-200 shadow-lg relative rounded-xl p-4 hover:shadow-xl transition-shadow duration-300">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Portfolio Progress Timeline</h3>
                <p class="text-sm text-gray-600">Track your projects' development progress over time</p>
            </div>
            <canvas id="myChart" width="1025" height="300" role="img" aria-label="" ></canvas>
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

    @php
        $period = \Carbon\CarbonPeriod::create(now()->subMonths(12), ' 1 month', now());
    @endphp
    function loadGraph() {
        const chart = new Chart(document.getElementById("myChart"), {
            type: "line",
            data: {
                labels: [
                    "{!!collect($period)->map(fn($date) => $date->format('M / Y'))->implode('","') !!}"
                ],
                datasets: [

                    @foreach($teams->get() as $team)
                    {
                        @php
                            $thedata = [];

                            $data = $team->events()
                            ->orderBy('date')
                            ->get()
                            ->mapWithkeys(function($e) use($team)  {
                                return [$e->date->format('M/y') => $e->progressMetric($team)];
                            });

                            foreach ($period as $time) {
                                $thedata[$time->format('M/y')] = '';
                                foreach($data as $date => $score) {
                                    if($date == $time->format('M/y')) {
                                        $thedata[$date] = $score;
                                    }
                                }
                            }

                        @endphp
                        label: "{!! $team->name !!}",
                        tension: .5,
                        borderColor: '{{ array_rand(array_flip(['#67cc58', '#b8d99b', '#93c66e', '#6a9e4a', '#11af3b', '#00c241'])) }}',
                        borderWidth: 3,
                        backgroundColor: '{{ array_rand(array_flip(['#67cc58', '#b8d99b', '#93c66e', '#6a9e4a', '#11af3b', '#00c241'])) }}',
                        data: [

                            {{ collect($thedata)->implode(',') }}
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
                spanGaps: true,
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
