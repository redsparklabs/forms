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
                <h3 class="text-xl font-semibold text-gray-900">{{ __('Update Project') }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ __('Update project details and scheduling information') }}</p>
            </div>
        </div>
    </x-slot>

    <x-slot name="description"></x-slot>

    <x-slot name="content">
        <div class="space-y-6">
            <!-- Project Name -->
            <div class="space-y-2">
                <label for="name" class="flex items-center text-sm font-medium text-gray-700">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    {{ __('Project Name') }}
                    <span class="text-red-500 ml-1">*</span>
                </label>
                <input id="name" type="text" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" wire:model.defer="updateForm.name" placeholder="Enter a descriptive project name" />
                <x-jet-input-error for="updateForm.name" class="mt-1" />
            </div>

            <!-- Date Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label for="start_date" class="flex items-center text-sm font-medium text-gray-700">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ __('Start Date') }}
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input id="start_date" onkeydown="return false" type="date" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" required pattern="\d{4}-\d{2}-\d{2}" wire:model.defer="updateForm.start_date" />
                    <x-jet-input-error for="updateForm.start_date" class="mt-1" />
                </div>

                <div class="space-y-2">
                    <label for="estimated_launch_date" class="flex items-center text-sm font-medium text-gray-700">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        {{ __('Target Launch Date') }}
                    </label>
                    <input id="estimated_launch_date" onkeydown="return false" type="date" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" pattern="\d{4}-\d{2}-\d{2}" wire:model.defer="updateForm.estimated_launch_date" />
                    <x-jet-input-error for="updateForm.estimated_launch_date" class="mt-1" />
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="flex items-center text-sm font-medium text-gray-700">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    {{ __('Project Description') }}
                    <span class="text-red-500 ml-1">*</span>
                </label>
                <textarea id="description" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200 resize-none" wire:model.defer="updateForm.description" placeholder="Describe the project goals, scope, and expected outcomes..."></textarea>
                <x-jet-input-error for="updateForm.description" class="mt-1" />
            </div>

            <!-- Priority and Sponsor -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label for="priority_level" class="flex items-center text-sm font-medium text-gray-700">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"></path>
                        </svg>
                        {{ __('Priority Level') }}
                    </label>
                    <select id="priority_level" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" wire:model.defer="updateForm.priority_level">
                        <option value="">Select priority...</option>
                        <option value="High">🔴 High Priority</option>
                        <option value="Medium">🟡 Medium Priority</option>
                        <option value="Low">🟢 Low Priority</option>
                    </select>
                    <x-jet-input-error for="updateForm.priority_level" class="mt-1" />
                </div>

                <div class="space-y-2">
                    <label for="sponsor" class="flex items-center text-sm font-medium text-gray-700">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ __('Project Sponsor') }}
                    </label>
                    <input id="sponsor" type="text" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" wire:model.defer="updateForm.sponsor" placeholder="Executive or department sponsor" />
                    <x-jet-input-error for="updateForm.sponsor" class="mt-1" />
                </div>
            </div>

            <!-- Success Criteria -->
            <div class="space-y-2">
                <label for="minimum_success_criteria" class="flex items-center text-sm font-medium text-gray-700">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                    {{ __('Success Criteria') }}
                </label>
                <textarea id="minimum_success_criteria" rows="2" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200 resize-none" wire:model.defer="updateForm.minimum_success_criteria" placeholder="Define measurable success criteria for this project..."></textarea>
                <x-jet-input-error for="updateForm.minimum_success_criteria" class="mt-1" />
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <div class="text-sm text-gray-500">
                <span class="text-red-500">*</span> Required fields
            </div>
            <div class="flex space-x-3">
                <button type="button" wire:click.stop="closeModal" wire:loading.attr="disabled" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                    {{ __('Cancel') }}
                </button>
                <button type="button" wire:click="update" wire:loading.attr="disabled" class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm transition-all duration-200">
                    <svg wire:loading wire:target="update" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="update">{{ __('Update Project') }}</span>
                    <span wire:loading wire:target="update">{{ __('Updating...') }}</span>
                </button>
            </div>
        </div>
    </x-slot>
</x-jet-dialog-modal>
