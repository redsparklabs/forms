<div class="mb-5">
    <header class="bg-gradient-to-r from-gray-800 to-gray-900 shadow-lg">
        <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold leading-tight text-white tracking-tight">
                        {{ __('Assessments')}}
                    </h2>
                    <p class="mt-2 text-gray-300 text-lg">
                        Schedule and manage growth board assessments
                    </p>
                </div>
                <div>
                    @if (Gate::check('addEvent', $organization) && $organization->teams->isNotEmpty())
                        <button wire:click="confirmCreate()" class="bg-white text-green-700 hover:bg-green-50 font-semibold px-6 py-3 rounded-lg shadow-md transition-all duration-200 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ __('Schedule Assessment') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">

        <x-jet-action-section :background="false">
            <x-slot name="title">
                {{ __('Assessments') }}
            </x-slot>

            <x-slot name="description">
                {{ __('All of the Assessments that are part of this organization.') }}
            </x-slot>

            <x-slot name="content">
                @if($organization->teams->isEmpty())
                    <div class="mb-10 overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <tr class="bg-white">
                                <td class="px-6 py-4 text-sm font-medium text-center text-gray-500 cursor-pointer whitespace-nowrap" colspan="6">
                                    {{ __('You need some Projects to Schedule a Growth Board.')}} {{ __('Go ahead and') }} <a class="text-blue-500 underline" href="{{ route('teams.index', 'create') }}">{{ __('add one') }}</a>!
                                </td>
                            </tr>
                        </table>
                    </div>
                @endif
                @if($organization->teams()->withTrashed()->get()->isNotEmpty() || $organization->teams->isNotEmpty())
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                                    <div class="px-6 py-4 border-b border-gray-200">
                                        <h2 class="text-lg font-semibold text-gray-900">{{ __('Assessment Portfolio') }}</h2>
                                        <p class="text-sm text-gray-500 mt-1">{{ __('Track progress and performance across all assessments') }}</p>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table class="min-w-full">
                                            <thead class="bg-gray-50 border-b border-gray-200">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        {{ __('Assessment Name') }}
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        {{ __('Progress') }}
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        {{ __('Department') }}
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        {{ __('Date') }}
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        {{ __('Review') }}
                                                    </th>
                                                    <th scope="col" class="relative px-6 py-3">
                                                        <span class="sr-only">{{ __('Actions') }}</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-100">
                                                @forelse ($events as $event)
                                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                        <td class="px-6 py-4">
                                                            <div class="flex items-center">
                                                                <div class="flex-shrink-0">
                                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center">
                                                                        <span class="text-sm font-semibold text-green-700">{{ substr($event->name, 0, 2) }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="ml-4">
                                                                    <div class="text-sm font-medium text-gray-900">{{ $event->name }}</div>
                                                                    <div class="text-sm text-gray-500">{{ $event->teams->count() }} {{ Str::plural('project', $event->teams->count()) }}</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <div class="flex items-center">
                                                                <div class="w-16 bg-gray-200 rounded-full h-2 mr-3">
                                                                    <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-2 rounded-full" style="width: {{ $event->date->isPast() ? '100' : '75' }}%"></div>
                                                                </div>
                                                                <span class="text-sm font-medium text-gray-900">{{ $event->date->isPast() ? '100' : '75' }}%</span>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-gray-900">
                                                            {{ $event->department ?: 'General' }}
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-gray-500">
                                                            {{ $event->date->format('M j, Y') }}
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <a href="{{ route('events.show', $event) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-700 to-emerald-700 border border-transparent rounded-lg text-sm font-medium text-white hover:from-green-800 hover:to-emerald-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600 transition-all duration-200 shadow-md">
                                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                                </svg>
                                                                {{ __('Open Assessment') }}
                                                            </a>
                                                        </td>
                                                        <td class="px-6 py-4 text-right">
                                                            <div class="inline-flex rounded-md shadow-sm">
                                                                <button wire:click="confirmUpdate({{ $event->id }})" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-l-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                                                    {{ __('Update') }}
                                                                </button>
                                                                <button wire:click="confirmDestroy({{ $event->id }})" class="inline-flex items-center px-3 py-1.5 border border-l-0 border-gray-300 rounded-r-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                                                    {{ __('Archive') }}
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="px-6 py-12 text-center">
                                                            <div class="flex flex-col items-center">
                                                                <svg class="h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h6a2 2 0 002-2V9a2 2 0 00-2-2h-2m0 0V3a2 2 0 10-4 0v2m4 0a2 2 0 104 0v2m-6 4h2m2 0h2"></path>
                                                                </svg>
                                                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No assessments yet') }}</h3>
                                                                <p class="text-gray-500 mb-4">{{ __('Get started by scheduling your first growth board assessment.') }}</p>
                                                                <button wire:click="$toggle('confirmingCreating')" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                                    </svg>
                                                                    {{ __('Schedule Assessment') }}
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </x-slot>
        </x-jet-action-section>

        <!-- Create Event Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingCreating" maxWidth="2xl">
            <x-slot name="title">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">{{ __('Schedule Assessment') }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Create a new growth board assessment session</p>
                    </div>
                </div>
            </x-slot>

            <x-slot name="description"></x-slot>

            <x-slot name="content">
                <div class="space-y-6">
                    <!-- Assessment Name -->
                    <div class="space-y-2">
                        <label for="name" class="flex items-center text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2m0 0h2m-2 0v4m6-6v-5a2 2 0 00-2-2H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('Assessment Name') }}
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input id="name" type="text" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" wire:model.defer="createForm.name" placeholder="Enter assessment name" />
                        <x-jet-input-error for="createForm.name" class="mt-1" />
                    </div>

                    <!-- Date and Department -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="date" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ __('Assessment Date') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input id="date" onkeydown="return false" type="date" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" required pattern="\d{4}-\d{2}-\d{2}" wire:model.defer="createForm.date" />
                            <x-jet-input-error for="createForm.date" class="mt-1" />
                        </div>

                        <div class="space-y-2">
                            <label for="department" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                {{ __('Department') }}
                            </label>
                            <input id="department" type="text" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" wire:model.defer="createForm.department" placeholder="Optional department name" />
                            <x-jet-input-error for="createForm.department" class="mt-1" />
                        </div>
                    </div>

                    <!-- Projects Selection -->
                    <div class="space-y-2">
                        <label class="flex items-center text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            {{ __('Select Projects') }}
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($organization->teams as $id => $team)
                                    <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-green-50 hover:border-green-200 cursor-pointer transition-colors duration-200">
                                        <input type="checkbox" name="team" id="team.{{ $id }}" wire:model="createForm.teams" value="{{ $team['id'] }}" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2" />
                                        <span class="ml-3 text-sm font-medium text-gray-700">{{ $team['name'] }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <x-jet-input-error for="createForm.teams" class="mt-1" />
                    </div>

                    <!-- Form Selection -->
                    <div class="space-y-2">
                        <label class="flex items-center text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            {{ __('Assessment Form') }}
                        </label>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="space-y-2">
                                @foreach($organization->forms as $id => $form)
                                    <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-green-50 hover:border-green-200 cursor-pointer transition-colors duration-200">
                                        <input type="radio" name="form" id="form.{{ $id }}" wire:model.defer="createForm.forms" value="{{ $form['id'] }}" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 focus:ring-2" />
                                        <div class="ml-3">
                                            <span class="text-sm font-medium text-gray-700">{{ $form['name'] }}</span>
                                            @if($form['description'])
                                                <p class="text-xs text-gray-500 mt-1">{{ Str::limit($form['description'], 60) }}</p>
                                            @endif
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <x-jet-input-error for="createForm.forms" class="mt-1" />
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <div class="text-sm text-gray-500">
                        <span class="text-red-500">*</span> Required fields
                    </div>
                    <div class="flex space-x-3">
                        <button type="button" wire:click="$toggle('confirmingCreating')" wire:loading.attr="disabled" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                            {{ __('Cancel') }}
                        </button>
                        <button type="button" wire:click="create" wire:loading.attr="disabled" class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm transition-all duration-200">
                            <svg wire:loading wire:target="create" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="create">{{ __('Schedule Assessment') }}</span>
                            <span wire:loading wire:target="create">{{ __('Scheduling...') }}</span>
                        </button>
                    </div>
                </div>
            </x-slot>
        </x-jet-dialog-modal>

        <!-- Update Event Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingUpdating" maxWidth="2xl">
            <x-slot name="title">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">{{ __('Update Assessment') }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Modify assessment details and settings</p>
                    </div>
                </div>
            </x-slot>

            <x-slot name="description"></x-slot>

            <x-slot name="content">
                <div class="space-y-6">
                    <!-- Assessment Name -->
                    <div class="space-y-2">
                        <label for="name" class="flex items-center text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2m0 0h2m-2 0v4m6-6v-5a2 2 0 00-2-2H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ __('Assessment Name') }}
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input id="name" type="text" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" wire:model.defer="updateForm.name" placeholder="Enter assessment name" />
                        <x-jet-input-error for="updateForm.name" class="mt-1" />
                    </div>

                    <!-- Date and Department -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="date" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ __('Assessment Date') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input id="date" onkeydown="return false" type="date" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" required pattern="\d{4}-\d{2}-\d{2}" wire:model.defer="updateForm.date" />
                            <x-jet-input-error for="updateForm.date" class="mt-1" />
                        </div>

                        <div class="space-y-2">
                            <label for="department" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                {{ __('Department') }}
                            </label>
                            <input id="department" type="text" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" wire:model.defer="updateForm.department" placeholder="Optional department name" />
                            <x-jet-input-error for="updateForm.department" class="mt-1" />
                        </div>
                    </div>

                    <!-- Projects Selection -->
                    <div class="space-y-2">
                        <label class="flex items-center text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            {{ __('Select Projects') }}
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($organization->teams as $id => $team)
                                    <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-green-50 hover:border-green-200 cursor-pointer transition-colors duration-200">
                                        <input type="checkbox" name="team" id="teams.{{ $team['id'] }}" wire:model="updateForm.teams.{{ $team['id'] }}" value="{{ $team['id'] }}" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2" />
                                        <span class="ml-3 text-sm font-medium text-gray-700">{{ $team['name'] }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <x-jet-input-error for="updateForm.teams" class="mt-1" />
                    </div>

                    <!-- Form Selection -->
                    <div class="space-y-2">
                        <label class="flex items-center text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            {{ __('Assessment Form') }}
                        </label>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="space-y-2">
                                @foreach($organization->forms as $id => $form)
                                    <label class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:bg-green-50 hover:border-green-200 cursor-pointer transition-colors duration-200">
                                        <input type="radio" name="form" id="forms.{{ $form['id'] }}" wire:model="updateForm.forms" value="{{ $form['id'] }}" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 focus:ring-2" />
                                        <div class="ml-3">
                                            <span class="text-sm font-medium text-gray-700">{{ $form['name'] }}</span>
                                            @if($form['description'])
                                                <p class="text-xs text-gray-500 mt-1">{{ Str::limit($form['description'], 60) }}</p>
                                            @endif
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <x-jet-input-error for="updateForm.forms" class="mt-1" />
                    </div>

                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <div class="text-sm text-gray-500">
                        <span class="text-red-500">*</span> Required fields
                    </div>
                    <div class="flex space-x-3">
                        <button type="button" wire:click="$toggle('confirmingUpdating')" wire:loading.attr="disabled" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                            {{ __('Cancel') }}
                        </button>
                        <button type="button" wire:click="update" wire:loading.attr="disabled" class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm transition-all duration-200">
                            <svg wire:loading wire:target="update" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="update">{{ __('Update Assessment') }}</span>
                            <span wire:loading wire:target="update">{{ __('Updating...') }}</span>
                        </button>
                    </div>
                </div>
            </x-slot>
        </x-jet-dialog-modal>

        <!-- Remove Event Confirmation Modal -->
        <x-jet-confirmation-modal wire:model="confirmingDestroying">
            <x-slot name="title">
                {{ __('Archive Growth Board') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you would like to archive this Growth Board from the organization?') }}
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
</div>
