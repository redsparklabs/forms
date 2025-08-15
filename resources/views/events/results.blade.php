<div class="min-h-screen bg-gray-50">
    <!-- Clean Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="py-6 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $event->name }} Assessment Results</h1>
                    <p class="text-gray-600 mt-1">{{ $team->name }} Project Evaluation</p>
                </div>
                <div>
                    @can('update', $event)
                        <button wire:click="confirmUpdate('{{ $event->id }}', '{{ $form->id }}', '{{ $questions }}')" class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Update
                        </button>
                    @endcan
                </div>
            </div>
        </div>
    </header>

    <div class="py-6 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Project Overview with Featured Progress Metric -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 items-start">
                <!-- Featured Progress Metric (Left Side) -->
                <div class="lg:col-span-2">
                    <div class="text-center">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Overall Progress Metric</h2>
                        <div class="flex items-center justify-center">
                            @php
                                $progressValue = $event->progressMetric($team);
                                $circumference = 2 * 22 / 7 * 140;
                                $strokeDashoffset = $circumference - ($progressValue * 20) / 100 * $circumference;
                            @endphp
                            <div class="relative">
                                <svg class="transform -rotate-90 w-72 h-72">
                                    <circle cx="144" cy="144" r="120" stroke="currentColor" stroke-width="16" fill="transparent" class="text-gray-200" />
                                    <circle cx="144" cy="144" r="120" stroke="currentColor" stroke-width="16" fill="transparent"
                                        stroke-dasharray="{{ $circumference }}"
                                        stroke-dashoffset="{{ $strokeDashoffset }}"
                                        class="text-green-600 transition-all duration-1000 ease-out" 
                                        stroke-linecap="round" />
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="text-center">
                                        <div class="text-6xl font-bold text-green-600">{{ number_format($progressValue, 1) }}</div>
                                        <div class="text-xl text-gray-500 font-medium mt-2">Score</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Project Info Cards (Right Side) -->
                <div class="lg:col-span-3">
                    <div class="h-full flex flex-col justify-center">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-5">
                                <dt class="text-sm font-medium text-green-700">Project Name</dt>
                                <dd class="mt-2 text-2xl font-bold text-green-900">{{ $team->name }}</dd>
                            </div>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-5">
                                <dt class="text-sm font-medium text-green-700">Assessment Date</dt>
                                <dd class="mt-2 text-2xl font-bold text-green-900">{{ $event->date?->format('M j, Y') }}</dd>
                            </div>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-5">
                                <dt class="text-sm font-medium text-gray-600">Investment To Date</dt>
                                <dd class="mt-2 text-2xl font-bold text-gray-900">${{ number_format($event->teams()->find($team->id)->pivot->investment ?? 0, 0) }}</dd>
                            </div>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-5">
                                <dt class="text-sm font-medium text-gray-600">Net Projected Value</dt>
                                <dd class="mt-2 text-2xl font-bold text-gray-900">${{ number_format($event->teams()->find($team->id)->pivot->net_projected_value ?? 0, 0) }}</dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Assessment Scoring Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-visible mb-6 relative">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Assessment Scoring Matrix</h2>
                <p class="text-sm text-gray-600 mt-1">Hover over any row to see detailed question scores</p>
            </div>
            <div class="p-6 overflow-visible">
                <table class="min-w-full divide-y divide-gray-200 relative">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Assessor Name
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-green-50">
                                Progress Metric
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Desirability
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Feasibility
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Viability
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-green-50">
                                Intuitive Score
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $progressMetricTotal = 0;
                            $desirabilityTotal = 0;
                            $feasibilityTotal = 0;
                            $viabilityTotal = 0;
                            $intuitiveScoreTotal = 0;
                            $responseCount = 0;
                        @endphp
                        @foreach($responses as $response)
                            @php
                                // Use same weighted calculation as top metric for consistency
                                $desirabilityQuestions = ['opportunity-segments', 'customer-need', 'value-proposition'];
                                $feasibilityQuestions = ['solution', 'channels', 'competitive-advantage'];
                                $viabilityQuestions = ['key-metrics', 'revenue', 'costs'];
                                
                                // Calculate Desirability (Market) - 40% weight
                                $responseDesirabilityTotal = 0;
                                foreach ($desirabilityQuestions as $questionSlug) {
                                    $responseDesirabilityTotal += $response->questions[$questionSlug] ?? 0;
                                }
                                $desirabilityAvg = count($desirabilityQuestions) > 0 ? $responseDesirabilityTotal / count($desirabilityQuestions) : 0;
                                
                                // Calculate Feasibility (Technical) - 35% weight  
                                $responseFeasibilityTotal = 0;
                                foreach ($feasibilityQuestions as $questionSlug) {
                                    $responseFeasibilityTotal += $response->questions[$questionSlug] ?? 0;
                                }
                                $feasibilityAvg = count($feasibilityQuestions) > 0 ? $responseFeasibilityTotal / count($feasibilityQuestions) : 0;
                                
                                // Calculate Viability (Regulatory) - 25% weight
                                $responseViabilityTotal = 0;
                                foreach ($viabilityQuestions as $questionSlug) {
                                    $responseViabilityTotal += $response->questions[$questionSlug] ?? 0;
                                }
                                $viabilityAvg = count($viabilityQuestions) > 0 ? $responseViabilityTotal / count($viabilityQuestions) : 0;
                                
                                // Calculate weighted progress metric (1 decimal place for clean UI)
                                $weightedTotal = ($desirabilityAvg * 0.40) + ($feasibilityAvg * 0.35) + ($viabilityAvg * 0.25);
                                $lineItemProgressMetric = number_format($weightedTotal, 1);
                                
                                $progressMetricTotal += $lineItemProgressMetric;
                                $desirabilityTotal += $desirabilityAvg;
                                $feasibilityTotal += $feasibilityAvg;
                                $viabilityTotal += $viabilityAvg;
                                
                                // Calculate intuitive score as the average of Team Performance and Team Gameplan
                                $teamPerformanceScore = Arr::get($response->questions, 'team-performance', 0);
                                $teamGameplanScore = Arr::get($response->questions, 'team-gameplan', 0);
                                $intuitiveScore = ($teamPerformanceScore + $teamGameplanScore) / 2;
                                $intuitiveScoreTotal += $intuitiveScore;
                                $responseCount++;
                            @endphp
                            <tr class="hover:bg-gray-50 relative group cursor-pointer">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 relative">
                                    {{ $response->email }}
                                    
                                    <!-- Hover Popup with Detailed Scores -->
                                    <div class="absolute left-full top-1/2 transform -translate-y-1/2 z-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none group-hover:pointer-events-auto ml-4">
                                        <div class="bg-white border border-gray-300 rounded-lg shadow-2xl p-6 w-[600px]">
                                            <div class="text-base font-semibold text-gray-900 mb-4 border-b pb-2">{{ $response->email }} - Detailed Assessment Scores</div>
                                            
                                                    
                                            <!-- Key Metrics Summary -->
                                            <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-lg p-4 mb-4">
                                                <h4 class="text-sm font-semibold text-gray-700 mb-3">Key Performance Metrics</h4>
                                                <div class="grid grid-cols-4 gap-4">
                                                    <div class="text-center">
                                                        <div class="text-2xl font-bold text-blue-600">{{ number_format($desirabilityAvg, 1) }}</div>
                                                        <div class="text-xs text-blue-600 font-medium">Desirability</div>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="text-2xl font-bold text-purple-600">{{ number_format($feasibilityAvg, 1) }}</div>
                                                        <div class="text-xs text-purple-600 font-medium">Feasibility</div>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="text-2xl font-bold text-orange-600">{{ number_format($viabilityAvg, 1) }}</div>
                                                        <div class="text-xs text-orange-600 font-medium">Viability</div>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="text-2xl font-bold text-green-600">{{ $lineItemProgressMetric }}</div>
                                                        <div class="text-xs text-green-600 font-medium">Overall Progress</div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            @php
                                                $orderedQuestionNames = [
                                                    'Customer Need',
                                                    'Opportunity Segments',
                                                    'Value Proposition',
                                                    'Solution',
                                                    'Competitive Advantage',
                                                    'Channels',
                                                    'Key Metrics',
                                                    'Revenue',
                                                    'Costs'
                                                ];
                                            @endphp
                                            <div class="grid grid-cols-2 gap-6">
                                                <!-- Individual Questions -->
                                                <div>
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        Individual Questions
                                                    </h4>
                                                    <div class="space-y-2">
                                                        @foreach($orderedQuestionNames as $qName)
                                                            @php
                                                                $question = $questions->firstWhere('question', $qName);
                                                                $score = $question ? Arr::get($response->questions, Str::slug($qName), 0) : 0;
                                                            @endphp
                                                            @if($question)
                                                                <div class="flex justify-between items-center py-1 px-2 rounded hover:bg-gray-50">
                                                                    <span class="text-sm text-gray-700 flex-1 pr-3">{{ isset($question['abbrev']) ? $question['abbrev'] : Str::limit($qName, 25) }}</span>
                                                                    <span class="text-sm font-semibold text-gray-900 bg-gray-100 px-2 py-1 rounded">{{ $score }}</span>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                                
                                                <!-- Other Metrics -->
                                                <div>
                                                    <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                                        Other Metrics
                                                    </h4>
                                                    <div class="space-y-2">
                                                        <div class="flex justify-between items-center py-1 px-2 rounded hover:bg-gray-50">
                                                            <span class="text-sm text-gray-700 flex-1 pr-3">Team Performance</span>
                                                            <span class="text-sm font-semibold text-gray-900 bg-gray-100 px-2 py-1 rounded">{{ number_format($teamPerformanceScore, 1) }}</span>
                                                        </div>
                                                        <div class="flex justify-between items-center py-1 px-2 rounded hover:bg-gray-50">
                                                            <span class="text-sm text-gray-700 flex-1 pr-3">Team Gameplan</span>
                                                            <span class="text-sm font-semibold text-gray-900 bg-gray-100 px-2 py-1 rounded">{{ number_format($teamGameplanScore, 1) }}</span>
                                                        </div>
                                                        <div class="flex justify-between items-center py-2 px-3 rounded bg-orange-50 border border-orange-100 mt-2">
                                                            <span class="text-sm text-gray-700 font-medium">Intuitive Scoring</span>
                                                            <span class="text-sm font-bold text-orange-700 bg-orange-200 px-3 py-1 rounded-full">{{ number_format($intuitiveScore, 1) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $lineItemProgressMetric }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ number_format($desirabilityAvg, 1) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        {{ number_format($feasibilityAvg, 1) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        {{ number_format($viabilityAvg, 1) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ number_format($intuitiveScore, 1) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach

                        <!-- Team Average Row -->
                        @php
                            $responseCount = count($responses);
                            $desirabilityAvg = $responseCount > 0 ? $desirabilityTotal / $responseCount : 0;
                            $feasibilityAvg = $responseCount > 0 ? $feasibilityTotal / $responseCount : 0;
                            $viabilityAvg = $responseCount > 0 ? $viabilityTotal / $responseCount : 0;
                            $progressMetricAvg = $responseCount > 0 ? $progressMetricTotal / $responseCount : 0;
                            $intuitiveScoreAvg = $responseCount > 0 ? $intuitiveScoreTotal / $responseCount : 0;
                        @endphp
                        <tr class="bg-green-50 border-t-2 border-green-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-900">
                                Team Average
                            </td>
                            @if($progressMetricTotal > 0 && count($responses) > 0)
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-600 text-white">
                                        {{ number_format($progressMetricAvg, 1) }}
                                    </span>
                                </td>
                            @else
                                <td class="px-6 py-4 whitespace-nowrap text-center text-gray-500">N/A</td>
                            @endif
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-600 text-white">
                                    {{ number_format($desirabilityAvg, 1) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-600 text-white">
                                    {{ number_format($feasibilityAvg, 1) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-600 text-white">
                                    {{ number_format($viabilityAvg, 1) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-600 text-white">
                                    {{ number_format($intuitiveScoreAvg, 1) }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Qualitative Feedback Section -->
        <div class="bg-white rounded-lg shadow-sm mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Qualitative Feedback</h2>
                <p class="text-sm text-gray-600 mt-1">Feedback, questions, ideas, and follow-up items</p>
            </div>
            <div class="p-4">
                @if(collect($responses)->filter(fn($response) => Arr::get($response->response, 'questions.custom'))->isNotEmpty())
                    <div class="space-y-6">
                        @foreach($feedback_questions as $index => $question)
                            <div class="border-b border-gray-200 pb-6 last:border-b-0">
                                <h3 class="text-base font-semibold text-gray-900 mb-2">{{ $question['question'] }}</h3>
                                <p class="text-sm text-gray-600 mb-4">{{ $question['description'] }}</p>
                                
                                <div class="space-y-3">
                                    @foreach($responses as $response)
                                        @if(Arr::get($response->response, 'questions.custom'))
                                            @php $customResponses = Arr::get($response->response, 'questions.custom', []); @endphp
                                            @if(isset($customResponses[$index]) && !empty($customResponses[$index]))
                                                <div class="bg-gray-50 rounded-lg p-4">
                                                    <div class="text-sm font-medium text-gray-900 mb-1">{{ $response->email }}</div>
                                                    <div class="text-gray-700">{{ $customResponses[$index] }}</div>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-gray-500">No qualitative feedback was provided for this assessment.</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Business Model Canvas Visualization -->
        <div class="mb-6">
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Business Model Canvas</h2>
                    <p class="text-sm text-gray-600 mt-1">Visual assessment breakdown by business model components</p>
                </div>
                <div class="p-6">
                    @if($responses && $responses->count() > 0)
                    <div class="w-2/3 mx-auto">
                        <div class="grid grid-flow-col grid-rows-2 gap-1 w-full">
                            @foreach($questions->where('hidden', false)->sortBy('order')->take(7) as $i => $question)
                                @php
                                    $number = 0;
                                    $mappedResponses = collect($responses)->map(fn ($value) => $value->response['questions']);
                                    if($mappedResponses->pluck(Str::slug($question['question']))->sum() > 0) {
                                        $number = number_format( $mappedResponses->pluck(Str::slug($question['question']))->sum() / $mappedResponses->count(), 1);
                                    }
                                @endphp
                                <div x-data="{ tooltip{{$i}}: false }"
                                     class="{{ $question['classes'] }} bg-{{ colorize($number) }} rounded flex cursor-pointer hover:opacity-90 transition-opacity"
                                    >
                                        <div
                                            x-on:mouseover="tooltip{{$i}} = true"
                                            x-on:mouseleave="tooltip{{$i}} = false"
                                            class="text-center p-4 items-center justify-center flex w-full text-white font-bold py-8"
                                        >
                                            <div>{{ $question['abbrev'] }} <br/>{{ $number}}</div>
                                        </div>
                                        <div class="relative" x-cloak x-show.transition.origin.top="tooltip{{$i}}">
                                            <div class="absolute top-0 z-10 w-48 p-2 -mt-1 text-sm leading-tight text-white bg-gray-900 transform -translate-x-1/2 -translate-y-full rounded-lg">
                                                <div class="font-bold mb-2">{{ $question['question']}}</div>
                                                <div class="text-gray-300">{{ $question['description']}}</div>
                                                <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        </div>

                        <div class="grid grid-flow-col grid-rows-2 gap-1 mt-1 w-full">
                             @foreach($questions->where('hidden', false)->sortBy('order')->skip(7)->take(2) as $i => $question)
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
                                     class="{{ $question['classes'] }} bg-{{ colorize($number) }} rounded flex cursor-pointer hover:opacity-90 transition-opacity"
                                    >
                                        <div
                                            x-on:mouseover="tooltip2{{$i}} = true"
                                            x-on:mouseleave="tooltip2{{$i}} = false"
                                            class="text-center p-4 items-center justify-center flex w-full text-white font-bold py-8"
                                        >
                                            <div>{{ $question['abbrev'] }} <br/>{{ $number}}</div>
                                        </div>
                                        <div class="relative" x-cloak x-show.transition.origin.top="tooltip2{{$i}}">
                                            <div class="absolute top-0 z-10 w-48 p-2 -mt-1 text-sm leading-tight text-white bg-gray-900 transform -translate-x-1/2 -translate-y-full rounded-lg">
                                                <div class="font-bold mb-2">{{ $question['question']}}</div>
                                                <div class="text-gray-300">{{ $question['description']}}</div>
                                                <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                        
                        <!-- Note -->
                        <div class="mt-6 p-3 bg-gray-50 rounded-lg">
                            <p class="text-xs text-gray-600 italic">*Note: All scores are calculated based on the latest evaluation responses and represent team averages.</p>
                        </div>
                    </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-gray-500">No responses available to generate the business model canvas.</div>
                        </div>
                    @endif
                </div>
            </div>
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
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span class="inline-flex shadow-sm items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">$</span>
                    <x-jet-input id="net_projected_value" type="text" class="block w-full border-l-0 rounded-l-none" wire:model.defer="updateForm.net_projected_value" />
                </div>
                <x-jet-input-error for="updateForm.net_projected_value" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-label for="investment" value="{{ __('Investment') }}" />
                <div class="mt-1 flex rounded-md shadow-sm">
                    <span class="inline-flex shadow-sm items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">$</span>
                    <x-jet-input type="text" id="investment" class="block w-full border-l-0 rounded-l-none" wire:model.defer="updateForm.investment" />
                </div>
                <x-jet-input-error for="updateForm.investment" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-label for="priority_level" value="{{ __('Priority Level') }}" />
                <x-jet-input id="priority_level" type="text" class="block w-full mt-1" wire:model.defer="updateForm.priority_level" />
                <x-jet-input-error for="updateForm.priority_level" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-label for="start_date" value="{{ __('Start Date') }}" />
                <x-jet-input id="start_date" type="date" class="block w-full mt-1" wire:model.defer="updateForm.start_date" />
                <x-jet-input-error for="updateForm.start_date" class="mt-2" />
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
