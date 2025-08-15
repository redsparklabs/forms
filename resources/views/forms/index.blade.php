<div>
    <header class="bg-gradient-to-r from-green-600 to-emerald-700 shadow-lg">
        <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold leading-tight text-white tracking-tight">
                        {{ __('Assessment Forms')}}
                    </h2>
                    <p class="mt-2 text-green-100 text-lg">
                        Create and manage assessment forms for your organization
                    </p>
                </div>
                <div>
                    @if (Gate::check('addForm', $organization))
                        <button wire:click="confirmCreate()" class="bg-white text-green-700 hover:bg-green-50 font-semibold px-6 py-3 rounded-lg shadow-md transition-all duration-200 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            {{ __('Create Form') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mt-10 sm:mt-0">
            <x-jet-action-section :background="false">
                <x-slot name="title">
                    {{ __('Assessments') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('All of the assessments that are part of this organization.') }}
                </x-slot>

                <x-slot name="content">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                                    <div class="px-6 py-4 border-b border-gray-200">
                                        <h2 class="text-lg font-semibold text-gray-900">{{ __('Form Portfolio') }}</h2>
                                        <p class="text-sm text-gray-500 mt-1">{{ __('Manage assessment form templates and question sets') }}</p>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table class="min-w-full">
                                            <thead class="bg-gray-50 border-b border-gray-200">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        {{ __('Form Name') }}
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        {{ __('Questions') }}
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
                                                @forelse($forms as $form)
                                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                        <td class="px-6 py-4">
                                                            <div class="flex items-center">
                                                                <div class="flex-shrink-0">
                                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center">
                                                                        <span class="text-sm font-semibold text-green-700">{{ substr($form->name, 0, 2) }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="ml-4">
                                                                    <div class="text-sm font-medium text-gray-900">{{ $form->name }}</div>
                                                                    <div class="text-sm text-gray-500">{{ Str::limit($form->description, 40) ?: 'No description' }}</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-gray-900">
                                                            {{ $form->questions->count() }} {{ Str::plural('question', $form->questions->count()) }}
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-gray-500">
                                                            {{ $form->created_at->format('M j, Y') }}
                                                        </td>
                                                        <td class="px-6 py-4 text-right">
                                                            <div class="inline-flex rounded-md shadow-sm">
                                                                <button wire:click="confirmUpdate({{ $form->id }})" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-l-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                                                    {{ __('Update') }}
                                                                </button>
                                                                <button wire:click="confirmDestroy({{ $form->id }})" class="inline-flex items-center px-3 py-1.5 border border-l-0 border-gray-300 rounded-r-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                                                    {{ __('Archive') }}
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="px-6 py-12 text-center">
                                                            <div class="flex flex-col items-center">
                                                                <svg class="h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                </svg>
                                                                <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No forms yet') }}</h3>
                                                                <p class="text-gray-500 mb-4">{{ __('Get started by creating your first assessment form.') }}</p>
                                                                <button wire:click="$toggle('confirmingCreating')" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                                    </svg>
                                                                    {{ __('Create Form') }}
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

        <x-jet-dialog-modal wire:model="confirmingCreating" maxWidth="2xl">
            <x-slot name="title">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">{{ __('Create Assessment Form') }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Build a new form template for growth board assessments</p>
                    </div>
                </div>
            </x-slot>

            <x-slot name="content">
                <div class="space-y-6">
                    <!-- Form Name -->
                    <div class="space-y-2">
                        <label for="name" class="flex items-center text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            {{ __('Form Name') }}
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input id="name" type="text" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" wire:model.defer="createForm.name" placeholder="Enter form name (e.g., Q4 Growth Assessment)" />
                        <x-jet-input-error for="createForm.name" class="mt-1" />
                    </div>

                    <!-- Form Description -->
                    <div class="space-y-2">
                        <label for="description" class="flex items-center text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                            {{ __('Description') }}
                        </label>
                        <textarea id="description" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200 resize-none" wire:model.defer="createForm.description" placeholder="Describe the purpose and scope of this assessment form..."></textarea>
                        <x-jet-input-error for="createForm.description" class="mt-1" />
                    </div>

                    <!-- Question Selection -->
                    @if ($allQuestions->isNotEmpty())
                        <div class="space-y-2">
                            <label class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ __('Select Questions') }}
                            </label>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 max-h-64 overflow-y-auto">
                                <div class="space-y-2">
                                    @foreach($allQuestions as $question)
                                        <label class="flex items-start p-3 bg-white rounded-lg border border-gray-200 hover:bg-green-50 hover:border-green-200 cursor-pointer transition-colors duration-200">
                                            <input type="checkbox" wire:model="createForm.questions" value="{{ $question->id }}" class="w-4 h-4 mt-1 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2" />
                                            <div class="ml-3 flex-1">
                                                <span class="text-sm font-medium text-gray-700">{{ $question->question }}</span>
                                                @if($question->description)
                                                    <p class="text-xs text-gray-500 mt-1">{{ Str::limit($question->description, 80) }}</p>
                                                @endif
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <p class="text-xs text-gray-500">Select the questions you want to include in this assessment form.</p>
                        </div>
                    @endif
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
                            <span wire:loading.remove wire:target="create">{{ __('Create Form') }}</span>
                            <span wire:loading wire:target="create">{{ __('Creating...') }}</span>
                        </button>
                    </div>
                </div>
            </x-slot>
        </x-jet-dialog-modal>

        <!-- Update Form Confirmation Modal -->
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
                        <h3 class="text-xl font-semibold text-gray-900">{{ __('Update Assessment Form') }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Modify form details and question selection</p>
                    </div>
                </div>
            </x-slot>

            <x-slot name="content">
                <div class="space-y-6">
                    <!-- Form Name -->
                    <div class="space-y-2">
                        <label for="name" class="flex items-center text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            {{ __('Form Name') }}
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input id="name" type="text" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200" wire:model.defer="updateForm.name" placeholder="Enter form name" />
                        <x-jet-input-error for="name" class="mt-1" />
                    </div>

                    <!-- Form Description -->
                    <div class="space-y-2">
                        <label for="description" class="flex items-center text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                            {{ __('Description') }}
                        </label>
                        <textarea id="description" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200 resize-none" wire:model.defer="updateForm.description" placeholder="Describe the purpose and scope of this assessment form..."></textarea>
                        <x-jet-input-error for="description" class="mt-1" />
                    </div>

                    <!-- Question Selection and Ordering -->
                    @if ($allQuestions->isNotEmpty())
                        @php
                            $counter = 0;
                        @endphp
                        <div class="space-y-2">
                            <label class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ __('Questions') }}
                            </label>
                            <x-jet-input-error for="Questions" class="mt-1" />
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 max-h-80 overflow-y-auto">
                                <div class="space-y-2">
                                @foreach($allQuestions as $index => $question)
                                    @php
                                        $counter++;
                                    @endphp
                                    <div class="flex items-center bg-white rounded-lg border border-gray-200 hover:bg-green-50 hover:border-green-200 transition-colors duration-200">
                                        <button type="button" class="flex-1 p-3 text-left focus:outline-none focus:ring-2 focus:ring-green-500 rounded-lg" wire:click="syncQuestion({{ $question->id }})">
                                            <div class="flex items-start {{ $assignedQuestions->contains($question->id) ? '' : 'opacity-50 hover:opacity-100' }}">
                                                @if ($assignedQuestions->contains($question->id))
                                                    <div class="flex-shrink-0 mr-3">
                                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </div>
                                                @else
                                                    <div class="flex-shrink-0 mr-3">
                                                        <div class="w-5 h-5 border-2 border-gray-300 rounded"></div>
                                                    </div>
                                                @endif
                                                <div class="flex-1">
                                                    <div class="text-sm font-medium text-gray-700 {{ $assignedQuestions->contains($question->id) ? 'font-semibold' : '' }}">
                                                        {{ $question->question }}
                                                    </div>
                                                    @if($question->description)
                                                        <div class="text-xs text-gray-500 mt-1">
                                                            {{ Str::limit($question->description, 80) }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </button>
                                        @if ($assignedQuestions->contains($question->id))
                                            @php
                                                $counter--;
                                            @endphp
                                            <div class="flex flex-col space-y-1 px-3 py-2">
                                                @if($index != $counter)
                                                    <button type="button" class="text-green-600 hover:text-green-800 transition-colors duration-200" wire:click="moveQuestionUp({{ $idBeingUpdated }}, {{ $question->id }})" title="Move Up">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                        </svg>
                                                    </button>
                                                @endif
                                                @if(!$loop->last)
                                                    <button type="button" class="text-green-600 hover:text-green-800 transition-colors duration-200" wire:click="moveQuestionDown({{ $idBeingUpdated }}, {{ $question->id }})" title="Move Down">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        </div>
                        <p class="text-xs text-gray-500">Click questions to select/deselect them. Use arrows to reorder selected questions.</p>
                    @endif
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
                            <span wire:loading.remove wire:target="update">{{ __('Update Form') }}</span>
                            <span wire:loading wire:target="update">{{ __('Updating...') }}</span>
                        </button>
                    </div>
                </div>
            </x-slot>
        </x-jet-dialog-modal>

        <!-- Remove Form Confirmation Modal -->
        <x-jet-confirmation-modal wire:model="confirmingDestroying">
            <x-slot name="title">
                {{ __('Archive Assessment') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you would like to archive this assessment?') }}
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
