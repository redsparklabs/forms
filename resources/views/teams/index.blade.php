
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
                    <a class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 cursor-pointer" wire:click="confirmCreate()">
                        {{ __('Create') }}
                    </a>
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
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="flex justify-end">
                                <div class="w-1/4 mb-2">
                                    <x-jet-input id="keywords" type="text" class="block w-full mt-1" wire:model="keyword" :placeholder="__('Search')"/>
                                </div>
                            </div>
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="pl-6 pr-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hover:text-gray-900 cursor-pointer" wire:click="sortBy('name')">
                                                {{ __('Name') }}
                                                @if($teams->count() > 1)
                                                    <x-sort :dir="$sortDirection" :active="$sortByField == 'name'"/>
                                                @endif
                                            </th>

                                            <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hover:text-gray-900 cursor-pointer" wire:click="sortBy('name')">
                                                {{ __('Progress Metric') }}
                                               {{--  @if($teams->count() > 1)
                                                    <x-sort :dir="$sortDirection" :active="$sortByField == 'name'"/>
                                                @endif --}}
                                            </th>

                                            <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hover:text-gray-900 cursor-pointer" wire:click="sortBy('priority_level')">
                                                {{ __('Priority Level') }}
                                                @if($teams->count() > 1)
                                                    <x-sort :dir="$sortDirection" :active="$sortByField == 'priority_level'"/>
                                                @endif
                                            </th>

                                            <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hover:text-gray-900 cursor-pointer" wire:click="sortBy('start_date')">
                                                {{ __('Start Date') }}
                                                @if($teams->count() > 1)
                                                    <x-sort :dir="$sortDirection" :active="$sortByField == 'start_date'"/>
                                                @endif
                                            </th>

                                            <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hover:text-gray-900 cursor-pointer" wire:click="sortBy('start_date')">
                                                {{ __('Net Project Value') }}
                                                {{-- @if($teams->count() > 1)
                                                    <x-sort :dir="$sortDirection" :active="$sortByField == 'priority_level'"/>
                                                @endif --}}
                                            </th>
                                            <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hover:text-gray-900 cursor-pointer" wire:click="sortBy('start_date')">
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
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                                    {{ $team->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                                    @if($team->progress_metric )
                                                        <div class="p-2 font-bold text-white bg-blue-500 w-10 text-center">
                                                            {{ $team->progress_metric }}
                                                        </div>
                                                    @else
                                                        {{ __('N/A') }}
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                                    {{ $team->priority_level }}
                                                </td>

                                                 <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                                    {{ $team->start_date->format('m/d/y') }}
                                                </td>

                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                                    {{ $team->pivot()?->net_projected_value }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                                    {{ $team->pivot()?->investment }}
                                                </td>

                                                 <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('teams.show', $team->id) }}">
                                                        {{ __('View') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                         @if(!$keyword)
                                            <tr class="bg-white">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 text-center" colspan="6">
                                                    {{ __('No Projects created.')}} {{ __('Go ahead and') }} <a class="text-blue-500 underline" wire:click="confirmCreate()">{{ __('create one') }}</a>!
                                                </td>
                                            </tr>
                                            @else
                                                <tr class="bg-white">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 text-center" colspan="6">
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

        <x-jet-dialog-modal wire:model="confirmingCreating">
            <x-slot name="title">
                {{ __('Create Project') }}
            </x-slot>

            <x-slot name="description"></x-slot>

            <x-slot name="content">
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="name" value="{{ __('Project Name') }}" />
                    <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.defer="createForm.name" />
                    <x-jet-input-error for="createForm.name" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="priority_level" value="{{ __('Priority Level') }}" />
                    <x-jet-input id="priority_level" type="text" class="block w-full mt-1" wire:model.defer="createForm.priority_level" />
                    <x-jet-input-error for="createForm.priority_level" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="start_date" value="{{ __('Start Date') }}" />
                    <x-jet-input id="start_date" onkeydown="return false" type="date" class="block w-full mt-1" required pattern="\d{4}-\d{2}-\d{2}" wire:model.defer="createForm.start_date" />
                    <x-jet-input-error for="createForm.start_date" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingCreating')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-2" wire:click="create" spinner="create">
                    {{ __('Create') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>

    </div>
</div>

