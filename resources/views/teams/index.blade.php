
<div>
    <header class="bg-white shadow">
        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        {{ __('Projects') }}
                    </h2>
                </div>
                <div>
                    <x-buttons.green wire:click="confirmCreate()">{{ __('Add Project') }}</x-buttons.green>
                </div>
            </div>
        </div>
    </header>

    <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <x-jet-action-section :background="false">
            <x-slot name="title">
                {{ __('Projects') }}
            </x-slot>

            <x-slot name="description">
                {{ __('All of the projects that are part of this organization.') }}
            </x-slot>

            <x-slot name="content">
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
                                        <tr>
                                            <th scope="col" class="px-6 py-3 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900" wire:click="sortBy('name')">
                                                {{ __('Name') }}
                                                @if($teams->count() > 1)
                                                    <x-sort :dir="$sortDirection" :active="$sortByField == 'name'"/>
                                                @endif
                                            </th>

                                            <th scope="col" class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900" wire:click="sortBy('name')">
                                                {{ __('Progress Metric') }}
                                               {{--  @if($teams->count() > 1)
                                                    <x-sort :dir="$sortDirection" :active="$sortByField == 'name'"/>
                                                @endif --}}
                                            </th>

                                            <th scope="col" class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900" wire:click="sortBy('priority_level')">
                                                {{ __('Priority Level') }}
                                                @if($teams->count() > 1)
                                                    <x-sort :dir="$sortDirection" :active="$sortByField == 'priority_level'"/>
                                                @endif
                                            </th>

                                            <th scope="col" class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900" wire:click="sortBy('start_date')">
                                                {{ __('Start Date') }}
                                                @if($teams->count() > 1)
                                                    <x-sort :dir="$sortDirection" :active="$sortByField == 'start_date'"/>
                                                @endif
                                            </th>

                                            <th scope="col" class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900">
                                                {{ __('Net Project Value') }}
                                                {{-- @if($teams->count() > 1)
                                                    <x-sort :dir="$sortDirection" :active="$sortByField == 'priority_level'"/>
                                                @endif --}}
                                            </th>
                                            <th scope="col" class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900">
                                                {{ __('Investment') }}
                                              {{--   @if($teams->count() > 1)
                                                    <x-sort :dir="$sortDirection" :active="$sortByField == 'priority_level'"/>
                                                @endif --}}
                                            </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($teams as $team)
                                            <tr @class([
                                                'bg-white' => $loop->odd,
                                                'bg-gray-50' => $loop->even
                                            ])>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-500 whitespace-nowrap">
                                                    {{ $team->name }}
                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-500 whitespace-nowrap">
                                                    @if($team->latestEvent())
                                                        <span class="font-bold text-lg text-{{ colorize($team->latestEvent()->progressMetric($team)) }}">
                                                            {{ $team->latestEvent()->progressMetric($team) }}
                                                        </span>
                                                    @else
                                                        {{ __('N/A') }}
                                                    @endif

                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-500 whitespace-nowrap">
                                                    {{ $team->priority_level ? $team->priority_level : 'N/A' }}
                                                </td>

                                                 <td class="px-6 py-4 text-sm font-medium text-gray-500 whitespace-nowrap">
                                                    {{ $team->start_date?->format('m/d/y') ?? 'N/A' }}
                                                </td>

                                                <td class="px-6 py-4 text-sm font-medium text-gray-500 whitespace-nowrap">
                                                    ${{ number_format($team->latestEvent()?->pivot?->net_projected_value, 2)}}
                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-500 whitespace-nowrap">
                                                    ${{ number_format($team->latestEvent()?->pivot?->investment, 2) }}
                                                </td>

                                                 <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                                    <x-buttons.green-link href="{{ route('teams.show', $team->id) }}">{{ __('View') }}</x-buttons.green-link>
                                                </td>
                                            </tr>
                                        @empty
                                         @if(!$keyword)
                                            <tr class="bg-white">
                                                <td class="px-6 py-4 text-sm font-medium text-center text-gray-500 cursor-pointer whitespace-nowrap" colspan="6">
                                                    {{ __('No Projects created.')}} {{ __('Go ahead and') }} <a class="text-blue-500 underline" wire:click="confirmCreate()">{{ __('add one') }}</a>!
                                                </td>
                                            </tr>
                                            @else
                                                <tr class="bg-white">
                                                    <td class="px-6 py-4 text-sm font-medium text-center text-gray-500 whitespace-nowrap" colspan="6">
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
            </x-slot>
        </x-jet-action-section>
    </div>
    @include('teams._create')
</div>

