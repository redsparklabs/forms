
<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Organization Forms') }}
    </h2>
</x-slot>

<div>
    <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
         <div class="mt-10 sm:mt-0">

            @if($organization->teams->isEmpty())
                <div class="p-6 text-center bg-white rounded-md">Please <a href="{{ route('organizations.show', Auth::user()->currentOrganization->id) }}" class="text-blue-900 underline">add</a> at least one team before creating a form.</div>
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

                        <div class="col-span-6 mb-2 sm:col-span-4">
                            <x-jet-label for="name" value="{{ __('Name') }}" />
                            <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.defer="create_form.name" />
                            <x-jet-input-error for="create_form.name" class="mt-2" />
                        </div>

                        <div class="col-span-6 mb-2 sm:col-span-4">
                            <x-jet-label for="events" value="{{ __('Event') }}" />
                            <x-jet-input id="events" type="text" class="block w-full mt-1" wire:model.defer="create_form.events" />
                            <x-jet-input-error for="create_form.events" class="mt-2" />
                        </div>

                        <div class="col-span-6 mb-2 sm:col-span-4">
                            <x-jet-label for="description" value="{{ __('Description') }}" />
                            <x-jet-textarea id="description" type="text" class="block w-full mt-1" wire:model.defer="create_form.description" />
                            <x-jet-input-error for="create_form.description" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="team" value="{{ __('Teams') }}" />
                            @foreach($organization->teams as $id => $team)
                            <div class="py-2">
                                <x-jet-label for="team-{{ $team['name'] }}">
                                    <x-jet-checkbox id="team-{{$team['name']}}" wire:model="create_form.team.{{ $team['id'] }}" value="{{ $team['id'] }}" />
                                    {{ $club['name'] }}
                                </x-jet-label>

                            </div>
                            @endforeach
                            <x-jet-input-error for="create_form.teams" class="mt-2" />
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

            @if ($organization->forms->isNotEmpty())
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
                                @foreach ($organization->forms->sortBy('name') as $form)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="ml-4">{{ $form->name }}</div>
                                        </div>

                                        <div class="flex items-center">
                                            <a class="ml-6 text-sm text-blue-500 cursor-pointer hover:text-blue-700 focus:outline-none" href="{{ route('form-builder', $form->slug) }}">
                                                {{ __('View') }}
                                            </a>

                                            <a class="ml-6 text-sm text-blue-500 cursor-pointer hover:text-blue-700 focus:outline-none" href="{{ route('form-results', [$organization->id, $form->id]) }}">
                                                {{ __('Results') }}
                                            </a>

                                             @if (Gate::check('updateForm', $organization))
                                                <button class="ml-6 text-sm text-blue-500 cursor-pointer hover:text-blue-700 focus:outline-none" wire:click="confirmUpdate('{{ $form->id }}')">
                                                    {{ __('Update') }}
                                                </button>
                                            @endif

                                            @if (Gate::check('removeForm', $organization))
                                                <button class="ml-6 text-sm text-red-500 cursor-pointer hover:text-red-700 focus:outline-none" wire:click="confirmDestroy('{{ $form->id }}')">
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
                    <!-- Organization Name -->
                    <div class="col-span-6 mb-4 sm:col-span-4">
                        <x-jet-label for="name" value="{{ __('Form Name') }}" />
                        <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.defer="updateForm.name" />
                        <x-jet-input-error for="name" class="mt-2" />
                    </div>
                    <div class="col-span-6 mb-4 sm:col-span-4">
                        <x-jet-label for="events" value="{{ __('Event') }}" />
                        <x-jet-input id="events" type="text" class="block w-full mt-1" wire:model.defer="updateForm.events" />
                        <x-jet-input-error for="event" class="mt-2" />
                    </div>

                    <div class="col-span-6 mb-4 sm:col-span-4">
                        <x-jet-label for="description" value="{{ __('Description') }}" />
                        <x-jet-textarea id="description" type="text" class="block w-full mt-1" wire:model.defer="updateForm.description" />
                        <x-jet-input-error for="description" class="mt-2" />
                    </div>

                     <div class="col-span-6 mb-4 sm:col-span-4">
                        <x-jet-label for="teams" value="{{ __('Organizations') }}" />
                        @foreach($organization->teams as $team)
                            <x-jet-label for="update-team-{{ $club['name'] }}">
                                <x-jet-checkbox id="update-club-{{$team['name']}}" wire:model="updateForm.teams.{{ $team['id'] }}" value="{{ $team['id'] }}" />
                                {{ $team['name'] }}
                            </x-jet-label>
                            <x-jet-input-error for="update-team-{{ $team['name'] }}" class="mt-2" />
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
                                                            <svg class="w-8 h-8 mr-2 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        </div>
                                                    @endif

                                                    <div class="flex-1 text-left ">
                                                        <div class="flex">
                                                            <div class="text-sm text-gray-600 p-2 {{ $assignedQuestions->contains($question->id) ? 'font-semibold' : '' }}">
                                                                {{ $question->question }}
                                                            </div>

                                                             <div class="p-2 text-xs text-left text-gray-600">
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
                                                    <a class="block text-blue-500 hover:text-green-500" wire:click="moveQuestionUp({{ $idBeingUpdated }}, {{ $question->id }})" title="Move Up">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z" /></svg>
                                                    </a>
                                                @endif
                                                @if(!$loop->last)
                                                    <a class="block text-blue-500 hover:text-green-500" wire:click="moveQuestionDown({{ $idBeingUpdated }}, {{ $question->id }})" title="Move Down">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" /></svg>
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
