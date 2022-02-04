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
                        <a class="text-sm text-blue-500 cursor-pointer focus:outline-none" href="{{ route('teams.index', 'create') }}">{{ __('Create a new Project') }}</a>
                    </x-slot>

                    <x-slot name="content">
                        <div class="flex flex-col">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                     <div class="flex justify-end">
                                        <div class="w-1/4 mb-2">
                                            <x-jet-input id="keywords" type="text" class="block w-full mt-1" wire:model="projectsKeyword" :placeholder="__('Search')"/>
                                        </div>
                                    </div>
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hover:text-gray-900 cursor-pointer" wire:click="sortByProject('name')">
                                                        {{ __('Name') }}
                                                        @if($teams->count() > 1)
                                                            <x-sort :dir="$projectsSortDirection" :active="$projectsSortByField == 'name'"/>
                                                        @endif
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        {{ __('Progress Metric') }}
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hover:text-gray-900 cursor-pointer" wire:click="sortByProject('priority_level')">
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
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            {{ $team->name }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                                            @if($team->progress_metric)
                                                                <div class="inline-block p-1 font-bold text-center text-white bg-blue-500 ">
                                                                    {{ $team->progress_metric }}
                                                                </div>
                                                            @else
                                                                {{ __('N/A') }}
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                                            {{ $team->priority_level }}
                                                        </td>
                                                         <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                            <a class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('teams.show', $team->id) }}">
                                                                {{ __('View') }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    @if(!$projectsKeyword)
                                                        <tr class="bg-white">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            {{ __('No Projects created.')}} {{ __('Go ahead and') }} <a class="text-blue-900 underline" href="{{ route('teams.create') }}">{{ __('create one') }}</a>!
                                                        </td>
                                                    </tr>
                                                    @else
                                                        <tr class="bg-white">
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 text-center" colspan="4">
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
                        <a class="text-sm text-blue-500 cursor-pointer focus:outline-none" href="{{ route('events.create') }}">{{ __('Create a new Growth Board') }}</a>
                    </x-slot>

                    <x-slot name="content">
                       <div class="flex flex-col">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="flex justify-end">
                                        <div class="w-1/4 mb-2">
                                            <x-jet-input id="keywords" type="text" class="block w-full mt-1" wire:model="eventsKeyword" :placeholder="__('Search')"/>
                                        </div>
                                    </div>
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hover:text-gray-900 cursor-pointer" wire:click="sortByEvent('name')">
                                                        {{ __('Growth Boards') }}
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
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            {{ $event->name }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                            <a class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('events.show', $event->id) }}">
                                                                {{ __('View') }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    @if(!$eventsKeyword)
                                                         <tr class="bg-white">
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 text-center" colspan="2">
                                                                No Growth Boards created. Go ahead and <a class="text-blue-500 underline" href="{{ route('events.create') }}">{{ __('create one') }}</a>!
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr class="bg-white">
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 text-center" colspan="2">
                                                                {{ __('No Growth Boards found.') }}
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

</div<>
