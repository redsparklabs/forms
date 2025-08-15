<div class="mb-5">
    <header class="bg-gradient-to-r from-green-600 to-emerald-700 shadow-lg">
        <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold leading-tight text-white tracking-tight">
                        {{ __('Portfolio') }}
                    </h2>
                    <p class="mt-2 text-green-100 text-lg">
                        Manage and track your innovation projects
                    </p>
                </div>
                <div>
                    <button wire:click="confirmCreate()" class="bg-white text-green-700 hover:bg-green-50 font-semibold px-6 py-3 rounded-lg shadow-md transition-all duration-200 inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        {{ __('Add Project') }}
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Portfolio Summary Cards -->
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 pt-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-500 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Projects</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $teams->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-green-500 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Active Projects</p>
                        <p class="text-2xl font-bold text-green-600">{{ $teams->filter(fn($team) => $team->latestEvent())->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-500 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Investment</p>
                        <p class="text-2xl font-bold text-purple-600">${{ number_format($teams->sum(fn($team) => $team->latestEvent()?->pivot?->investment ?? 0), 0) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center">
                    <div class="p-3 bg-orange-500 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Avg Progress</p>
                        <p class="text-2xl font-bold text-orange-600">
                            @if($teams->count() > 0)
                                {{ number_format($teams->filter(fn($team) => $team->latestEvent())->avg(fn($team) => $team->latestEvent()?->progressMetric($team) ?? 0), 1) }}
                            @else
                                0
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Project Portfolio</h3>
                        <p class="text-sm text-gray-600">Track progress and performance across all projects</p>
                    </div>
                    <div class="w-1/4">
                        <x-jet-input id="keywords" type="text" class="block w-full" wire:model="keyword" :placeholder="__('Search projects...')"/>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900" wire:click="sortBy('name')">
                                {{ __('Project Name') }}
                                @if($teams->count() > 1)
                                    <x-sort :dir="$sortDirection" :active="$sortByField == 'name'"/>
                                @endif
                            </th>
                            <th scope="col" class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                {{ __('Progress') }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                {{ __('Development Stage') }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                {{ __('NPV') }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                {{ __('Investment') }}
                            </th>
                            <th scope="col" class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                {{ __('ROI Potential') }}
                            </th>
                            <th scope="col" class="relative px-6 py-4">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($teams as $team)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center">
                                                <span class="text-white font-semibold text-sm">{{ substr($team->name, 0, 2) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $team->name }}</div>
                                            <div class="text-sm text-gray-500">Created {{ $team->created_at?->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($team->latestEvent())
                                        <div class="flex items-center">
                                            <div class="flex-1 bg-gray-200 rounded-full h-2 mr-3">
                                                <div class="bg-gradient-to-r from-green-400 to-green-600 h-2 rounded-full" style="width: {{ ($team->latestEvent()->progressMetric($team) / 5) * 100 }}%"></div>
                                            </div>
                                            <span class="text-sm font-semibold text-gray-900">{{ $team->latestEvent()->progressMetric($team) }}/5</span>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400">No data</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($team->latestEvent())
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ stage($team->latestEvent()->progressMetric($team))->name }}
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Not Started</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    ${{ number_format($team->latestEvent()?->pivot?->net_projected_value ?? 0, 0) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${{ number_format($team->latestEvent()?->pivot?->investment ?? 0, 0) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $npv = $team->latestEvent()?->pivot?->net_projected_value ?? 0;
                                        $investment = $team->latestEvent()?->pivot?->investment ?? 0;
                                        $roi = $investment > 0 ? (($npv - $investment) / $investment) * 100 : 0;
                                    @endphp
                                    @if($roi > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3"/>
                                            </svg>
                                            +{{ number_format($roi, 0) }}%
                                        </span>
                                    @elseif($roi < 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3"/>
                                            </svg>
                                            {{ number_format($roi, 0) }}%
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-400">TBD</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <x-buttons.green-link href="{{ route('teams.show', $team->id) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                        View Details
                                    </x-buttons.green-link>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        @if(!$keyword)
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No projects yet</h3>
                                            <p class="text-gray-500 mb-4">Get started by creating your first innovation project</p>
                                            <button wire:click="confirmCreate()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Create First Project
                                            </button>
                                        @else
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No projects found</h3>
                                            <p class="text-gray-500">Try adjusting your search terms</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($teams->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        {{ $teams->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('teams._create')
</div>

