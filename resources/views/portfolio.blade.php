<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $this->user->currentOrganization->name }} {{ __('Portfolio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mt-10 sm:mt-0">
                <x-jet-action-section :background="false">
                    <x-slot name="title">
                        {{ __('Projects') }}
                    </x-slot>

                    <x-slot name="description">
                        <a class="text-sm text-karban-green-4 cursor-pointer focus:outline-none" href="{{ route('teams.index', 'create') }}">{{ __('Add Project') }}</a>
                    </x-slot>

                    <x-slot name="content">
                        <div class="flex flex-col">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                     <div class="flex justify-end">
                                        <div class="w-1/4 mb-2">
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
                                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                        {{ __('Progress Metric') }}
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900" wire:click="sortByProject('priority_level')">
                                                        {{ __('Priority Level') }}
                                                        @if($teams->count() > 1)
                                                            <x-sort :dir="$projectsSortDirection" :active="$projectsSortByField == 'priority_level'"/>
                                                        @endif
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
                                                        <td class="px-6 py-4 text-sm font-medium text-gray-500 whitespace-nowrap">
                                                            <span class="font-bold text-lg text-{{ colorize($team->latestEvent()->progressMetric($team)) }}">{{ $team->latestEvent()->progressMetric($team) }}</span>
                                                        </td>
                                                        <td class="px-6 py-4 text-sm font-medium text-gray-500 whitespace-nowrap">
                                                            {{ $team->priority_level }}
                                                        </td>
                                                         <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                                            <x-buttons.green-link href="{{ route('teams.show', $team->id) }}">{{ __('View') }}</x-buttons.green-link>
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
                    </x-slot>
                </x-jet-action-section>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mt-10 sm:mt-0">
                <x-jet-action-section :background="false">
                    <x-slot name="title">
                        {{ __('Growth Boards') }}
                    </x-slot>

                    <x-slot name="description">
                        <a class="text-sm text-karban-green-4 cursor-pointer focus:outline-none" href="{{ route('events.index', 'create') }}">
                            {{ __('Schedule Growth Board') }}
                        </a>
                    </x-slot>

                    <x-slot name="content">
                       <div class="flex flex-col">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                    <div class="flex justify-end">
                                        <div class="w-1/4 mb-2">
                                            <x-jet-input id="keywords" type="text" class="block w-full mt-1" wire:model="eventsKeyword" :placeholder="__('Search')"/>
                                        </div>
                                    </div>
                                    <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900" wire:click="sortByEvent('name')">
                                                        {{ __('Name') }}
                                                        @if($events->count() > 1)
                                                            <x-sort :dir="$eventsSortDirection" :active="$eventsSortByField == 'name'"/>
                                                        @endif
                                                </th>
                                                 <th scope="col" class="relative px-6 py-3 text-right">

                                                </th>
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
                                                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                                            <x-buttons.green-link href="{{ route('events.show', $team->id) }}">{{ __('View') }}</x-buttons.green-link>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    @if(!$eventsKeyword)
                                                         <tr class="bg-white">
                                                            <td class="px-6 py-4 text-sm font-medium text-center text-gray-500 whitespace-nowrap" colspan="2">
                                                                No Growth Boards created. Go ahead and <a class="text-blue-500 underline" href="{{ route('events.index', 'create') }}">{{ __('schedule one') }}</a>!
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr class="bg-white">
                                                            <td class="px-6 py-4 text-sm font-medium text-center text-gray-500 whitespace-nowrap" colspan="2">
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
    </div>

</div<>
