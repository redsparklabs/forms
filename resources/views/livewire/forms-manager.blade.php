
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Organization Forms') }}
    </h2>
</x-slot>

<div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
         <div class="mt-10 sm:mt-0">

            @if($team->clubs->isEmpty())
                <div class="bg-white text-center p-6 rounded-md">Please <a href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" class="text-blue-900 underline">add</a> at least one team before creating a form.</div>
            @else
                <x-jet-form-section submit="create">
                    <x-slot name="title">
                        {{ __('Add Form') }}
                    </x-slot>

                    <x-slot name="description">
                        {{ __('Add a new form to your organization.') }}
                    </x-slot>

                    <x-slot name="form">
                        <div class="col-span-6">
                            <div class="max-w-xl text-sm text-gray-600">
                                {{ __('Please provide the name of the form you would like to add to this organization.') }}
                            </div>
                        </div>

                        <div class="col-span-6 sm:col-span-4 mb-2">
                            <x-jet-label for="name" value="{{ __('Name') }}" />
                            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="create_form.name" />
                            <x-jet-input-error for="create_form.name" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4 mb-2">
                            <x-jet-label for="events" value="{{ __('Event') }}" />
                            <x-jet-input id="events" type="text" class="mt-1 block w-full" wire:model.defer="create_form.events" />
                            <x-jet-input-error for="create_form.events" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4 mb-2">
                            <x-jet-label for="description" value="{{ __('Description') }}" />
                            <x-jet-textarea id="description" type="text" class="mt-1 block w-full" wire:model.defer="create_form.description" />
                            <x-jet-input-error for="create_form.description" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="clubs" value="{{ __('Teams') }}" />
                            @foreach($team->clubs as $id => $club)
                            <div class="py-2">
                                <x-jet-label for="club-{{ $club['name'] }}">
                                    <x-jet-checkbox id="club-{{$club['name']}}" wire:model="create_form.clubs.{{ $club['id'] }}" value="{{ $club['id'] }}" />
                                    {{ $club['name'] }}
                                </x-jet-label>

                            </div>
                            @endforeach
                            <x-jet-input-error for="create_form.clubs" class="mt-2" />
                        </div>
                    </x-slot>

                    <x-slot name="actions">
                        <x-jet-action-message class="mr-3" on="created">
                            {{ __('Added') }}
                        </x-jet-action-message>

                        <x-jet-button spinner="create">
                            {{ __('Add') }}
                        </x-jet-button>
                    </x-slot>
                </x-jet-form-section>
            @endif

            @if ($team->forms->isNotEmpty())
                <x-jet-section-border />
                <!-- Manage Forms -->
                <div class="mt-10 sm:mt-0">
                    <x-jet-action-section>
                        <x-slot name="title">
                            {{ __('Forms') }}
                        </x-slot>

                        <x-slot name="description">
                            {{ __('All of the forms that are part of this organization.') }}
                        </x-slot>

                        <x-slot name="content">
                            <div class="space-y-6">
                                @foreach ($team->forms->sortBy('name') as $form)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="ml-4">{{ $form->name }}</div>
                                        </div>

                                        <div class="flex items-center">
                                            <a class="cursor-pointer ml-6 text-sm text-blue-500 hover:text-blue-700 focus:outline-none" href="{{ route('form-builder', $form->slug) }}">
                                                {{ __('View') }}
                                            </a>

                                            <a class="cursor-pointer ml-6 text-sm text-blue-500 hover:text-blue-700 focus:outline-none" href="{{ route('form-results', [$team->id, $form->id]) }}">
                                                {{ __('Results') }}
                                            </a>

                                             @if (Gate::check('updateForm', $team))
                                                <button class="cursor-pointer ml-6 text-sm text-blue-500 hover:text-blue-700 focus:outline-none" wire:click="confirmUpdate('{{ $form->id }}')">
                                                    {{ __('Update') }}
                                                </button>
                                            @endif

                                            @if (Gate::check('removeForm', $team))
                                                <button class="cursor-pointer ml-6 text-sm text-red-500 hover:text-red-700 focus:outline-none" wire:click="confirmDestroy('{{ $form->id }}')">
                                                    {{ __('Remove') }}
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

            <!-- Uodate Form Confirmation Modal -->
            <x-jet-dialog-modal wire:model="confirmingUpdating">
                <x-slot name="title">
                    {{ __('Update Form') }}
                </x-slot>

                <x-slot name="content">
                    <!-- Team Name -->
                    <div class="col-span-6 sm:col-span-4 mb-4">
                        <x-jet-label for="name" value="{{ __('Form Name') }}" />
                        <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="updateForm.name" />
                        <x-jet-input-error for="name" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-4 mb-4">
                        <x-jet-label for="events" value="{{ __('Event') }}" />
                        <x-jet-input id="events" type="text" class="mt-1 block w-full" wire:model.defer="updateForm.events" />
                        <x-jet-input-error for="event" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4 mb-4">
                        <x-jet-label for="description" value="{{ __('Description') }}" />
                        <x-jet-textarea id="description" type="text" class="mt-1 block w-full" wire:model.defer="updateForm.description" />
                        <x-jet-input-error for="description" class="mt-2" />
                    </div>

                     <div class="col-span-6 sm:col-span-4 mb-4">
                        <x-jet-label for="clubs" value="{{ __('Teams') }}" />
                        @foreach($team->clubs as $club)
                            <x-jet-label for="update-club-{{ $club['name'] }}">
                                <x-jet-checkbox id="update-club-{{$club['name']}}" wire:model="updateForm.clubs.{{ $club['id'] }}" value="{{ $club['id'] }}" />
                                {{ $club['name'] }}
                            </x-jet-label>
                            <x-jet-input-error for="update-club-{{ $club['name'] }}" class="mt-2" />
                        @endforeach
                    </div>
                    @if ($allQuestions->isNotEmpty())
                        @php
                            $counter = 0;
                        @endphp
                        <div class="col-span-6 lg:col-span-4">
                            <x-jet-label for="role" value="{{ __('Questions') }}" />
                            <x-jet-input-error for="Questions" class="mt-2" />
                            <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                                @foreach($allQuestions as $index => $question)
                                    @php
                                        $counter++;
                                    @endphp
                                    <div class="flex">
                                        <button type="button" class="flex-initial relative px-4 py-3 w-full rounded-lg focus:z-10 focus:outline-none {{ $index > 0 ? 'border-t border-gray-200 rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}" wire:click="syncQuestion('{{ $question->id }}')">
                                            <div class="{{ $assignedQuestions->contains($question->id) ? '' : 'opacity-50 hover:opacity-100' }}">

                                                <div class="flex items-center text-left">
                                                    @if ($assignedQuestions->contains($question->id))
                                                        <div class="flex-initial">
                                                            <svg class="mr-2 h-8 w-8 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        </div>
                                                    @endif

                                                    <div class="text-left flex-1 ">
                                                        <div class="flex">
                                                            <div class="text-sm text-gray-600 p-2 {{ $assignedQuestions->contains($question->id) ? 'font-semibold' : '' }}">
                                                                {{ $question->question }}
                                                            </div>

                                                             <div class="text-xs text-gray-600 text-left p-2">
                                                                {{ $question->description }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                        @if ($assignedQuestions->contains($question->id))
                                            @php
                                                $counter--;
                                            @endphp
                                            <div class="flex-1 relative pl-2 py-3 pr-4 w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 {{ $index > 0 ? 'border-t border-gray-200 rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}">
                                                @if($index != $counter)
                                                    <a class="text-blue-500 block hover:text-green-500" wire:click="moveQuestionUp({{ $idBeingUpdated }}, {{ $question->id }})" title="Move Up">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z" /></svg>
                                                    </a>
                                                @endif
                                                @if(!$loop->last)
                                                    <a class="text-blue-500 block hover:text-green-500" wire:click="moveQuestionDown({{ $idBeingUpdated }}, {{ $question->id }})" title="Move Down">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" /></svg>
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
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

            <!-- Remove Form Confirmation Modal -->
            <x-jet-confirmation-modal wire:model="confirmingDestroying">
                <x-slot name="title">
                    {{ __('Remove Form') }}
                </x-slot>

                <x-slot name="content">
                    {{ __('Are you sure you would like to remove this form from the organization?') }}
                </x-slot>

                <x-slot name="footer">
                    <x-jet-secondary-button wire:click="$toggle('confirmingRemoval')" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>

                    <x-jet-danger-button class="ml-2" wire:click="destroy" spinner="destroy">
                        {{ __('Remove') }}
                    </x-jet-danger-button>
                </x-slot>
            </x-jet-confirmation-modal>
        </div>
    </div>
</div>
