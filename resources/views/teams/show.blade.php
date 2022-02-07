<div>
    <header class="bg-white shadow">
        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
             <div class="flex">
                <div class="w-full">
                    <div>
                        <div class="flex">
                            <h2 class="flex-1 text-xl leading-6 font-medium text-gray-900">Project - {{ $team->name }} {{ $team->id }} </h2>
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
                        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
                            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Project</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->name }}</dd>
                            </div>
                            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Progress Metric:</dt>
                                @if($team->latest_progress_metric)
                                    <dd class="mt-1 text-sm font-semibold text-blue-500">
                                        <div class="p-2 font-bold text-white bg-blue-500 w-10 text-center">
                                            {{ $team->latest_progress_metric }}
                                        </div>
                                    </dd>
                                @else
                                    <dd class="mt-1 text-sm font-semibold text-gray-900">{{ __('N/A') }}</dd>
                                @endif
                            </div>
                            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Project Start Date:</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->start_date->format('m/d/y') }}</dd>
                            </div>
                             <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Priority Level:</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->priority_level ?? 'N/A' }}</dd>
                            </div>

                            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Investment To Date:</dt>
                                <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $team->latestPivot()?->investment ?? 'N/A'}}</dd>
                            </div>
                            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
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
                   <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="flex justify-end">
                                    <div class="w-1/4 mb-2">
                                        <x-jet-input id="keywords" type="text" class="block w-full mt-1" wire:model="keyword" :placeholder="__('Search')"/>
                                    </div>
                                </div>
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hover:text-gray-900 cursor-pointer" wire:click="sortByEvent('name')">
                                                {{ __('Name') }}
                                                @if($events->count() > 1)
                                                    <x-sort :dir="$sortDirection" :active="$sortByField == 'name'"/>
                                                @endif
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hover:text-gray-900 cursor-pointer" wire:click="sortByEvent('name')">
                                                {{ __('Date') }}
                                                @if($events->count() > 1)
                                                    <x-sort :dir="$sortDirection" :active="$sortByField == 'date'"/>
                                                @endif
                                            </th>
                                             <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{ __('Progress Metric') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
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
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $event->name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $event->date->format('m/d/y') }}
                                                    </td>
                                                     <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        <div class="p-2 font-bold text-white bg-blue-500 w-10 text-center">
                                                            {{ $event->progressMetric($team) }}
                                                        </div>
                                                    </td>
                                                     <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $event->teams->find($team->id)->pivot->net_projected_value ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <a class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('events.results',[$event->id, $event->latestForm()->id, $team->id]) }}">
                                                            {{ __('View Results') }}
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

    <x-jet-dialog-modal wire:model="confirmingUpdating">
        <x-slot name="title">
            {{ __('Update Project') }}
        </x-slot>

        <x-slot name="content">
            <div>
                <x-jet-label for="name" value="{{ __('Project Name') }}" />
                <x-jet-input id="name" type="text" class="block w-full mt-1" model="updateForm.name" wire:model.defer="updateForm.name" />
                <x-jet-input-error for="name" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-label for="priority_level" value="{{ __('Priority Level') }}" />
                <x-jet-input id="priority_level" type="text" class="block w-full mt-1" wire:model.defer="updateForm.priority_level" />
                <x-jet-input-error for="priority_level" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-jet-label for="start_date" value="{{ __('Start Date') }}" />
                <x-jet-input type="date" id="start_date"  onkeydown="return false" required pattern="\d{4}-\d{2}-\d{2}" class="block w-full mt-1" wire:model.defer="updateForm.start_date" />
                <x-jet-input-error for="start_date" class="mt-2" />
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

    <x-jet-confirmation-modal wire:model="confirmingDestroying">
            <x-slot name="title">
                {{ __('Archive Project') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you would like to archive this project?') }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingDestroying')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="destroy" spinner="destroy">
                    {{ __('Archive') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal>

</div>
