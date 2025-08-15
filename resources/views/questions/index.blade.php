<div>
    <header class="bg-gradient-to-r from-gray-800 to-gray-900 shadow-lg">
        <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold leading-tight text-white tracking-tight">
                        {{ __('Organization Questions')}}
                    </h2>
                    <p class="mt-2 text-gray-300 text-lg">
                        Manage assessment questions for your organization
                    </p>
                </div>
                <div>
                    @if (Gate::check('addQuestion', $organization))
                        <button wire:click="confirmCreate()" class="bg-white text-green-700 hover:bg-green-50 font-semibold px-6 py-3 rounded-lg shadow-md transition-all duration-200 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            {{ __('Create Question') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
         <div class="mt-10 sm:mt-0">
                <!-- Manage Questions -->
            <div class="mt-10 sm:mt-0">
                <x-jet-action-section :background="false">
                    <x-slot name="title">
                        {{ __('Questions') }}
                    </x-slot>

                    <x-slot name="description">
                        {{ __('All of the questions that are part of this organization.') }}
                    </x-slot>

                    <x-slot name="content">
                        <div class="flex flex-col">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                                        <div class="px-6 py-4 border-b border-gray-200">
                                            <h2 class="text-lg font-semibold text-gray-900">{{ __('Question Portfolio') }}</h2>
                                            <p class="text-sm text-gray-500 mt-1">{{ __('Manage assessment questions and evaluation criteria') }}</p>
                                        </div>

                                        <div class="overflow-x-auto">
                                            <table class="min-w-full">
                                                <thead class="bg-gray-50 border-b border-gray-200">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            {{ __('Question Name') }}
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            {{ __('Description') }}
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            {{ __('Type') }}
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            {{ __('Created') }}
                                                        </th>
                                                        <th scope="col" class="relative px-6 py-3">
                                                            <span class="sr-only">{{ __('Actions') }}</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-100">
                                                    @forelse($questions as $question)
                                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                            <td class="px-6 py-4">
                                                                <div class="flex items-center">
                                                                    <div class="flex-shrink-0">
                                                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
                                                                            <span class="text-sm font-semibold text-purple-700">{{ substr($question->question, 0, 2) }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ml-4">
                                                                        <div class="text-sm font-medium text-gray-900">{{ $question->question }}</div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                <div class="text-sm text-gray-900">
                                                                    {{ $question->description ?: 'No description' }}
                                                                </div>
                                                            </td>
                                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                                Assessment Question
                                                            </td>
                                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                                {{ $question->created_at->format('M j, Y') }}
                                                            </td>
                                                            <td class="px-6 py-4 text-right">
                                                                <div class="inline-flex rounded-md shadow-sm">
                                                                    <button wire:click="confirmUpdate({{ $question->id }})" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-l-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                                                        {{ __('Update') }}
                                                                    </button>
                                                                    <button wire:click="confirmDestroy({{ $question->id }})" class="inline-flex items-center px-3 py-1.5 border border-l-0 border-gray-300 rounded-r-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
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
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                    </svg>
                                                                    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No questions yet') }}</h3>
                                                                    <p class="text-gray-500 mb-4">{{ __('Get started by creating your first assessment question.') }}</p>
                                                                    <button wire:click="$toggle('confirmingCreating')" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                                        </svg>
                                                                        {{ __('Create Question') }}
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
                    </x-slot>
                </x-jet-action-section>
            </div>

            <!-- Create Question Confirmation Modal -->
            <x-jet-dialog-modal wire:model="confirmingCreating" maxWidth="xl">
                <x-slot name="title">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">{{ __('Create Question') }}</h3>
                            <p class="text-sm text-gray-500 mt-1">Add a new assessment question to your organization</p>
                        </div>
                    </div>
                </x-slot>

                <x-slot name="content">
                    <div class="space-y-6">
                        <!-- Question Text -->
                        <div class="space-y-2">
                            <label for="question" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ __('Question Text') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input id="question" type="text" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" wire:model.defer="createForm.question" placeholder="Enter your assessment question" />
                            <x-jet-input-error for="createForm.question" class="mt-1" />
                        </div>

                        <!-- Description -->
                        <div class="space-y-2">
                            <label for="description" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                {{ __('Description') }}
                            </label>
                            <textarea id="description" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200 resize-none" wire:model.defer="createForm.description" placeholder="Provide additional context or instructions for this question..."></textarea>
                            <x-jet-input-error for="createForm.description" class="mt-1" />
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
                                <span wire:loading.remove wire:target="create">{{ __('Create Question') }}</span>
                                <span wire:loading wire:target="create">{{ __('Creating...') }}</span>
                            </button>
                        </div>
                    </div>
                </x-slot>
            </x-jet-dialog-modal>

            <!-- Update Question Confirmation Modal -->
            <x-jet-dialog-modal wire:model="confirmingUpdating" maxWidth="xl">
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
                            <h3 class="text-xl font-semibold text-gray-900">{{ __('Update Question') }}</h3>
                            <p class="text-sm text-gray-500 mt-1">Modify assessment question details</p>
                        </div>
                    </div>
                </x-slot>

                <x-slot name="content">
                    <div class="space-y-6">
                        <!-- Question Text -->
                        <div class="space-y-2">
                            <label for="question" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ __('Question Text') }}
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input id="question" type="text" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" wire:model.defer="updateForm.question" placeholder="Enter your assessment question" />
                            <x-jet-input-error for="question" class="mt-1" />
                        </div>

                        <!-- Description -->
                        <div class="space-y-2">
                            <label for="description" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                {{ __('Description') }}
                            </label>
                            <textarea id="description" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200 resize-none" wire:model.defer="updateForm.description" placeholder="Provide additional context or instructions for this question..."></textarea>
                            <x-jet-input-error for="description" class="mt-1" />
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
                                <span wire:loading.remove wire:target="update">{{ __('Update Question') }}</span>
                                <span wire:loading wire:target="update">{{ __('Updating...') }}</span>
                            </button>
                        </div>
                    </div>
                </x-slot>
            </x-jet-dialog-modal>

            <!-- Remove Question Confirmation Modal -->
            <x-jet-confirmation-modal wire:model="confirmingDestroying">
                <x-slot name="title">
                    {{ __('Archive Question') }}
                </x-slot>

                <x-slot name="content">
                    {{ __('Are you sure you would like to archive this question?') }}
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
</div>
