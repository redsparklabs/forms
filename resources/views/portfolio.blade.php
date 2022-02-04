<div>
    <x-slot name="header">

        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ Auth::user()->currentOrganization->name }} {{ __('Portfolio') }}
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
                        {{-- <a class="text-sm text-blue-500 cursor-pointer focus:outline-none" href="{{ route('teams.create') }}">{{ __('Create a new Project') }}</a> --}}
                    </x-slot>

                    <x-slot name="content">

                        <div class="flex flex-col">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hover:text-gray-900 cursor-pointer" wire:click="sortBy('name')">
                                                        {{ __('Name') }}<x-sort :dir="$sortDirection" :active="$sortByField == 'name'"/>
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        {{ __('Progress Metric') }}
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hover:text-gray-900 cursor-pointer" wire:click="sortBy('priority_level')"">
                                                        {{ __('Priority Level') }}<x-sort :dir="$sortDirection" :active="$sortByField == 'priority_level'"/>
                                                    </th>
                                                    <th scope="col" class="relative px-6 py-3">
                                                         <x-jet-input id="keywords" type="text" class="block w-full mt-1" wire:model="keyword" />
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
                                                     <tr class="bg-white">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            No Projects created. Go ahead and <a class="text-blue-900 underline" href="{{ route('teams.create') }}">{{ __('create one') }}</a>!
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        @if($teams->count() > 25)
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
                <x-jet-action-section>
                    <x-slot name="title">
                        {{ __('Growth Boards') }}
                    </x-slot>

                    <x-slot name="description">
                        <a class="text-sm text-blue-500 cursor-pointer focus:outline-none" href="{{ route('events.create') }}">{{ __('Create a new Growth Board') }}</a>
                    </x-slot>

                    <x-slot name="content">
                        <div class="space-y-6">
                            @forelse (Auth::user()->currentOrganization->events->sortBy('name') as $event)
                                <div class="flex items-center justify-between">
                                    <div>{{ $event->name }}</div>

                                    @if($team->latestEvent() && $team->latestform())
                                        <div>
                                            <a class="ml-2 text-sm text-blue-500 cursor-pointer focus:outline-none" href="{{ route('events.results', [$team->latestEvent()->id, $team->latestform()->id, $team->id]) }}">
                                                {{ __('View Results') }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                             @empty
                                <div class="text-center">
                                    <span class="text-md text-center text-gray-600">No Growth Boards created. Go ahead and <a class="text-blue-900 underline" href="{{ route('events.create') }}">create one</a>!</span>
                                </div>
                            @endforelse
                        </div>
                    </x-slot>
                </x-jet-action-section>
            </div>
        </div>
    </div>

</div<>
