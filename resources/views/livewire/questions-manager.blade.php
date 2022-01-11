
<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Organization Questions') }}
    </h2>
</x-slot>

<div>
    <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
         <div class="mt-10 sm:mt-0">
            <x-jet-form-section submit="create">
                <x-slot name="title">
                    {{ __('Add Question') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Add a new question to your organization.') }}
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6">
                        <div class="max-w-xl text-sm text-gray-600">
                            {{ __('Please provide the name of the question you would like to add to this organization.') }}
                        </div>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="question" value="{{ __('Question') }}" />
                        <x-jet-input id="question" type="text" class="block w-full mt-1" wire:model.defer="createForm.question" />
                        <x-jet-input-error for="question" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="description" value="{{ __('Description') }}" />
                        <x-jet-textarea id="description" type="text" class="block w-full mt-1" wire:model.defer="createForm.description" />
                        <x-jet-input-error for="description" class="mt-2" />
                    </div>
                </x-slot>

                <x-slot name="actions">
                    <x-jet-action-message class="mr-3" on="created">
                        {{ __('Added.') }}
                    </x-jet-action-message>

                    <x-jet-button spinner="create">
                        {{ __('Add') }}
                    </x-jet-button>
                </x-slot>
            </x-jet-form-section>

             @if ($organization->questions->isNotEmpty())
                <x-jet-section-border />
                <!-- Manage Questions -->
                <div class="mt-10 sm:mt-0">
                    <x-jet-action-section>
                        <x-slot name="title">
                            {{ __('Questions') }}
                        </x-slot>

                        <x-slot name="description">
                            {{ __('All of the questions that are part of this organization.') }}
                        </x-slot>

                        <x-slot name="content">
                            <div class="space-y-6">
                                @foreach ($organization->questions->sortBy('name') as $question)
                                    <div class="flex items-center justify-between">
                                        <div class="">
                                            <div class="ml-4">{{ $question->question }}</div>
                                            <div class="ml-4">{{ $question->description }}</div>
                                        </div>

                                        <div class="flex items-center">

                                             @if (Gate::check('updateQuestion', $organization))
                                                <button class="ml-6 text-sm text-blue-500 cursor-pointer" wire:click="confirmUpdate('{{ $question->id }}')">
                                                    {{ __('Update') }}
                                                </button>
                                            @endif

                                            @if (Gate::check('removeQuestion', $organization))
                                                <button class="ml-6 text-sm text-red-500 cursor-pointer" wire:click="confirmDestroy('{{ $question->id }}')">
                                                    {{ __('Archive') }}
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </x-slot>
                    </x-jet-action-section>
                </div>
            @endif

            <!-- Uodate Question Confirmation Modal -->
            <x-jet-dialog-modal wire:model="confirmingUpdating">
                <x-slot name="title">
                    {{ __('Update Question') }}
                </x-slot>

                <x-slot name="content">
                    <div class="col-span-6 mb-4 sm:col-span-4">
                        <x-jet-label for="question" value="{{ __('Question') }}" />
                        <x-jet-input id="question" type="text" class="block w-full mt-1" wire:model.defer="updateForm.question" />
                        <x-jet-input-error for="question" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="description" value="{{ __('Description') }}" />
                        <x-jet-textarea id="description" type="text" class="block w-full mt-1" wire:model.defer="updateForm.description" />
                        <x-jet-input-error for="description" class="mt-2" />
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
