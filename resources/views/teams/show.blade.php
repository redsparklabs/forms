<div class="mb-5">
    <header class="bg-gradient-to-r from-green-600 to-emerald-700 shadow-lg">
        <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold leading-tight text-white tracking-tight">{{ __('Project') }} - {{ $team->name }}</h2>
                    <p class="mt-2 text-green-100 text-lg">{{ $team->description ?: 'Project overview and progress tracking' }}</p>
                </div>
                <div class="flex space-x-3">
                    @if (Gate::check('updateTeam', $organization))
                        <button wire:click="confirmUpdate('{{$team->id}}')" class="bg-white text-green-700 hover:bg-green-50 font-semibold px-6 py-3 rounded-lg shadow-md transition-all duration-200 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            {{ __('Update') }}
                        </button>
                    @endif
                    @if (Gate::check('removeTeam', $organization))
                        <button wire:click="confirmDestroy('{{$team->id}}')" class="bg-red-600 text-white hover:bg-red-700 font-semibold px-6 py-3 rounded-lg shadow-md transition-all duration-200 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            {{ __('Archive') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">

        <!-- Progress Metric Card -->
        <div class="mb-8 bg-white shadow-lg border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-6 py-5 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="h-10 w-10 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Latest Progress Metric</h3>
                        <p class="mt-1 text-sm text-gray-600">Current project development stage and scoring</p>
                    </div>
                </div>
            </div>
            <div class="p-8">
                <div class="flex items-center justify-center">
                    @php
                        $score = $team->latestEvent()?->progressMetric($team) ?? 0;
                        $percentage = ($score / 5) * 100;
                    @endphp
                    <div class="relative">
                        <svg class="transform -rotate-90 w-64 h-64">
                            <circle cx="128" cy="128" r="100" stroke="currentColor" stroke-width="20" fill="transparent" class="text-gray-200" />
                            <circle cx="128" cy="128" r="100" stroke="currentColor" stroke-width="20" fill="transparent"
                                stroke-dasharray="628"
                                stroke-dashoffset="{{ 628 - ($percentage * 6.28) }}"
                                class="text-green-500 transition-all duration-1000 ease-out" />
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <div class="text-5xl font-bold text-green-600">{{ number_format($score, 1) }}</div>
                                <div class="text-sm font-medium text-gray-500 mt-1">out of 5.0</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex mt-6 rounded-lg overflow-hidden shadow-sm">
                    <div class="flex-1 p-3 text-white font-bold text-center bg-gradient-to-r from-green-400 to-green-500 {{ $score >= 1 ? 'opacity-100' : 'opacity-40' }}">1</div>
                    <div class="flex-1 p-3 text-white font-bold text-center bg-gradient-to-r from-green-500 to-green-600 {{ $score >= 2 ? 'opacity-100' : 'opacity-40' }}">2</div>
                    <div class="flex-1 p-3 text-white font-bold text-center bg-gradient-to-r from-green-600 to-green-700 {{ $score >= 3 ? 'opacity-100' : 'opacity-40' }}">3</div>
                    <div class="flex-1 p-3 text-white font-bold text-center bg-gradient-to-r from-green-700 to-green-800 {{ $score >= 4 ? 'opacity-100' : 'opacity-40' }}">4</div>
                    <div class="flex-1 p-3 text-white font-bold text-center bg-gradient-to-r from-green-800 to-green-900 {{ $score >= 5 ? 'opacity-100' : 'opacity-40' }}">5</div>
                </div>
            </div>
        </div>


        <!-- Project Information Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-3">
                    <div class="h-8 w-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h4 class="text-sm font-medium text-gray-500">Project Start Date</h4>
                </div>
                <p class="text-lg font-semibold text-gray-900">{{ $team->start_date?->format('M j, Y') ?? 'N/A' }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-3">
                    <div class="h-8 w-8 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h4 class="text-sm font-medium text-gray-500">Estimated Launch</h4>
                </div>
                <p class="text-lg font-semibold text-gray-900">
                    @if($team->estimated_launch_date)
                        Q{{ $team->estimated_launch_date?->quarter }} {{ $team->estimated_launch_date?->format('Y') }}
                    @else
                        N/A
                    @endif
                </p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-3">
                    <div class="h-8 w-8 bg-gradient-to-r from-amber-500 to-amber-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h4 class="text-sm font-medium text-gray-500">Success Criteria</h4>
                </div>
                <p class="text-lg font-semibold text-gray-900">{{ Str::limit($team->minimum_success_criteria, 40) ?? 'N/A' }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-3">
                    <div class="h-8 w-8 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <h4 class="text-sm font-medium text-gray-500">Investment To Date</h4>
                </div>
                <p class="text-lg font-semibold text-gray-900">${{ number_format($team->latestEvent()?->pivot?->investment ?? 0, 2)}}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-3">
                    <div class="h-8 w-8 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <h4 class="text-sm font-medium text-gray-500">Net Present Value</h4>
                </div>
                <p class="text-lg font-semibold text-gray-900">${{ number_format($team->latestEvent()?->pivot?->net_projected_value ?? 0, 2)}}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-3">
                    <div class="h-8 w-8 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h4 class="text-sm font-medium text-gray-500">Project Sponsor</h4>
                </div>
                <p class="text-lg font-semibold text-gray-900">{{ $team->sponsor ?? 'N/A'}}</p>
            </div>
        </div>
    </div>


    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8" x-cloak x-data="{ activeTab: 0 }">
        <!-- Modern Tab Navigation -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-6" aria-label="Tabs">
                    <button @click="activeTab = 0" class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200" :class="activeTab === 0 ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Progress Metrics
                        </div>
                    </button>
                    <button @click="activeTab = 1" class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200" :class="activeTab === 1 ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Assessment History
                        </div>
                    </button>
                    <button @click="activeTab = 2" class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200" :class="activeTab === 2 ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Business Model
                        </div>
                    </button>
                    @can('viewMembers', $team)
                        <button @click="activeTab = 3" class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200" :class="activeTab === 3 ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                Team Members
                            </div>
                        </button>
                    @endcan
                </nav>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6" x-show.transition.in.opacity.duration.600="activeTab === 0">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Progress Metrics Chart</h3>
                <p class="text-sm text-gray-600">Track progress, investment, and NPV over time</p>
            </div>
            <canvas id="myChart" width="1025" role="img" aria-label=""></canvas>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6" x-show.transition.in.opacity.duration.600="activeTab === 1">
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Assessment History</h3>
                <p class="text-sm text-gray-600">Complete history of project assessments and results</p>
            </div>
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
                            <table class="min-w-full">
                                <thead class="bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-200">
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-900" wire:click="sortBy('name')">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2m0 0h2m-2 0v4m6-6v-5a2 2 0 00-2-2H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ __('Assessment Name') }}
                                            @if($events->count() > 1)
                                                <x-sort :dir="$sortDirection" :active="$sortByField == 'name'"/>
                                            @endif
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:text-gray-900" wire:click="sortBy('date')">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ __('Date') }}
                                            @if($events->count() > 1)
                                                <x-sort :dir="$sortDirection" :active="$sortByField == 'date'"/>
                                            @endif
                                        </div>
                                    </th>
                                     <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                            {{ __('Progress Score') }}
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                            </svg>
                                            {{ __('NPV') }}
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Actions') }}
                                    </th>
                                </thead>
                                <tbody>
                                    @forelse ($events as $event)
                                        <tr @class([
                                            'bg-white' => $loop->odd,
                                            'bg-gray-50' => $loop->even
                                        ])>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="h-8 w-8 bg-gradient-to-r from-green-100 to-emerald-100 rounded-lg flex items-center justify-center mr-3">
                                                        <span class="text-xs font-semibold text-green-700">{{ substr($event->name, 0, 2) }}</span>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">{{ $event->name }}</div>
                                                        <div class="text-sm text-gray-500">Assessment Session</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                {{ $event->date->format('M j, Y') }}
                                            </td>
                                             <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 mr-3">
                                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-sm font-bold text-white bg-gradient-to-r from-green-500 to-emerald-500">
                                                            {{ $event->progressMetric($team) }}
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <div class="w-16 bg-gray-200 rounded-full h-2">
                                                            <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-2 rounded-full" style="width: {{ min(100, ($event->progressMetric($team) / 5) * 100) }}%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                             <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                                ${{ number_format($event->teams->find($team->id)->pivot->net_projected_value ?? 0, 2) }}
                                            </td>
                                              <td class="px-6 py-4">
                                              @if($event->progressMetric($team) > 0)
                                                    <a href="{{ route('events.results', [$event->id, $team->id]) }}" class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-green-600 to-emerald-600 border border-transparent rounded-lg text-sm font-medium text-white hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                        View Results
                                                    </a>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-2 bg-yellow-100 border border-yellow-200 rounded-lg text-sm font-medium text-yellow-800">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        Awaiting Results
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        @if(!$keyword)
                                             <tr class="bg-white">
                                                <td class="px-6 py-12 text-center" colspan="5">
                                                    <div class="flex flex-col items-center">
                                                        <svg class="h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2m0 0h2m-2 0v4m6-6v-5a2 2 0 00-2-2H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No assessments yet</h3>
                                                        <p class="text-gray-500 mb-4">Get started by creating your first assessment.</p>
                                                        <a href="{{ route('events.index', 'create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                            </svg>
                                                            Create Assessment
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @else
                                            <tr class="bg-white">
                                                <td class="px-6 py-12 text-center" colspan="5">
                                                    <div class="flex flex-col items-center">
                                                        <svg class="h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                        </svg>
                                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No results found</h3>
                                                        <p class="text-gray-500">Try adjusting your search criteria.</p>
                                                    </div>
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
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6" x-show.transition.in.opacity.duration.600="activeTab === 2">
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Business Model Progression</h3>
                <p class="text-sm text-gray-600">Interactive business model components and development stage</p>
            </div>

            <div class="flex">
                <div class="mr-12 flex-1 gap-4 shadow p-4 rounded">
                    <div class="text-md font-medium text-gray-500 truncate mb-4">Business Model Development</div>
                    <div class="grid grid-flow-col grid-rows-2 gap-1 w-full">
                        @php
                        // @dd($team);
                            $latestEvent = $team->latestEvent();
                            $responses = $latestEvent?->responses()->where('team_id', $team->id)->get();
                        @endphp
                        @if($responses && $responses->count() > 0 && $latestEvent && $latestEvent->latestForm())
                            @foreach($latestEvent->latestForm()->allQuestions()->where('hidden', false)->sortBy('order')->take(7) as $i => $question)
                                @php
                                    $number = 0;
                                    $mappedResponses = collect($responses)->map(fn ($value) => $value->response['questions']);
                                    if($mappedResponses->count() > 0 && $mappedResponses->pluck(Str::slug($question['question']))->sum() > 0) {
                                        $number = number_format( $mappedResponses->pluck(Str::slug($question['question']))->sum() / $mappedResponses->count(), 1);
                                    }

                                @endphp
                                    <div x-data="{ tooltip{{$i}}: false }"
                                     class="{{ $question['classes'] }} bg-{{ colorize($number) }}  rounded flex cursor-pointer hover:opacity-80 transition-opacity"
                                     wire:click="showHistoricalChart('{{ Str::slug($question['question']) }}', '{{ $question['question'] }}', '{{ addslashes($question['description']) }}')"
                                    >
                                        <div
                                            x-on:mouseover="tooltip{{$i}} = true"
                                            x-on:mouseleave="tooltip{{$i}} = false"
                                            class="text-center p-4 items-center justify-center flex w-full text-white font-bold py-8"
                                        >
                                            <div>{{ $number}}</div>
                                        </div>
                                          <div class="relative" x-cloak x-show.transition.origin.top="tooltip{{$i}}">
                                            <div class="absolute top-0 z-10 w-32 p-2 -mt-1 text-sm leading-tight text-black transform -translate-x-1/2 -translate-y-full bg-white rounded-lg border border-black">
                                                <div class="font-bold text-center">{{ $question['question']}}</div>
                                                <div class="text-center text-xs mt-1 text-gray-600">View Details</div>
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
                                     class="{{ $question['classes'] }} bg-{{ colorize($number) }}  rounded flex cursor-pointer hover:opacity-80 transition-opacity"
                                     wire:click="showHistoricalChart('{{ Str::slug($question['question']) }}', '{{ $question['question'] }}', '{{ addslashes($question['description']) }}')"
                                    >
                                        <div
                                            x-on:mouseover="tooltip2{{$i}} = true"
                                            x-on:mouseleave="tooltip2{{$i}} = false"
                                            class="text-center p-4 items-center justify-center flex w-full text-white font-bold py-8"
                                        >
                                            <div>{{ $number}}</div>
                                        </div>
                                          <div class="relative" x-cloak x-show.transition.origin.top="tooltip2{{$i}}">
                                            <div class="absolute top-0 z-10 w-32 p-2 -mt-1 text-sm leading-tight text-black transform -translate-x-1/2 -translate-y-full bg-white rounded-lg border border-black">
                                                <div class="font-bold text-center">{{ $question['question']}}</div>
                                                <div class="text-center text-xs mt-1 text-gray-600">View Details</div>
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
                    <div>{!! $team->latestEvent()?->stage($team->latestEvent()->progressMetric($team))->description !!}</div>
                </div>
            </div>
        </div>
        
        <!-- Team Members Tab Content -->
        @can('viewMembers', $team)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6" x-show.transition.in.opacity.duration.600="activeTab === 3">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Team Members</h3>
                    <p class="text-sm text-gray-600">Manage project team members and their roles</p>
                </div>
                <livewire:team-member-manager :team="$team" />
            </div>
        @endcan
    </div>

    <!-- Historical Chart Modal -->
    <div x-data="{ showModal: @entangle('showHistoricalModal') }" 
         x-show="showModal" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="showModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
                 @click="$wire.closeHistoricalModal()"></div>

            <!-- Modal content -->
            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block w-full max-w-4xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-medium text-gray-900">
                        Historical Scoring: {{ $selectedQuestionTitle ?? 'Component' }}
                    </h3>
                    <button @click="$wire.closeHistoricalModal()" 
                            class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                @if($selectedQuestionDescription)
                    <div class="mb-6">
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $selectedQuestionDescription }}</p>
                    </div>
                @endif

                <div class="mb-4">
                    <canvas id="historicalChart" width="800" height="400"></canvas>
                </div>

                @if($historicalData && count($historicalData) > 0)
                    <div class="mt-4 text-sm text-gray-600">
                        <p><strong>Total Assessments:</strong> {{ count($historicalData) }}</p>
                        <p><strong>Score Range:</strong> {{ min(array_column($historicalData, 'score')) }} - {{ max(array_column($historicalData, 'score')) }}</p>
                        <p><strong>Latest Score:</strong> {{ end($historicalData)['score'] ?? 'N/A' }}</p>
                    </div>
                @else
                    <div class="mt-4 text-sm text-gray-500">
                        <p>No historical data available for this component.</p>
                    </div>
                @endif
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

    // Historical Chart functionality
    let historicalChart = null;

    // Listen for Livewire event to render historical chart
    window.livewire.on('renderHistoricalChart', (data) => {
        setTimeout(() => {
            renderHistoricalChart(data);
        }, 100); // Small delay to ensure modal is fully rendered
    });

    function renderHistoricalChart(data) {
        const ctx = document.getElementById('historicalChart');
        if (!ctx) return;

        // Destroy existing chart if it exists
        if (historicalChart) {
            historicalChart.destroy();
        }

        // Prepare data for Chart.js
        const labels = data.map(item => item.date);
        const scores = data.map(item => parseFloat(item.score));

        historicalChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Score',
                    data: scores,
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.1,
                    pointBackgroundColor: 'rgb(34, 197, 94)',
                    pointBorderColor: 'white',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 5,
                        ticks: {
                            stepSize: 1
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    }
                },
                elements: {
                    point: {
                        hoverRadius: 8
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    }
    </script>
@endpush
