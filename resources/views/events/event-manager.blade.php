<div>
    @if (Gate::check('addEvent', $organization))
        <div class="mt-10 sm:mt-0">
            @if($organization->teams->isEmpty())
                <div class="p-6 text-center bg-white rounded-md">Please <a href="{{ route('teams.index', Auth::user()->currentOrganization->id) }}" class="text-blue-900 underline">add</a> at least one team before creating a form.</div>
            @else
                <x-jet-form-section submit="create">
                    <x-slot name="title">
                        {{ __('Add Growth Board') }}
                    </x-slot>

                    <x-slot name="description">
                        {{ __('Add a new Growth Board to your organization.') }}
                    </x-slot>

                    <x-slot name="form">

                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="name" value="{{ __('Growth Board Name') }}" />
                            <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.defer="createForm.name" />
                            <x-jet-input-error for="name" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="team" value="{{ __('Teams') }}" />
                            @foreach($organization->teams as $id => $team)
                                <div class="py-2">
                                    <x-jet-label :for="Str::slug('createTeam-'.$team['name'])">
                                        <x-jet-checkbox :name="Str::slug('createTeam-'.$team['name'])" :id="Str::slug('createTeam-'.$team['name'])" wire:model="createForm.teams.{{ $team['id'] }}" :value="$team['id']" />
                                        {{ $team['name'] }}
                                    </x-jet-label>
                                </div>
                            @endforeach
                            <x-jet-input-error for="createForm.teams" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="forms" value="{{ __('Attach Form') }}" />
                            @foreach($organization->forms as $id => $form)
                                <div class="py-2">
                                    <x-radio :name="Str::slug('createForm-'.$team['name'])" :id="Str::slug('createForm-'.$team['name'])" wire:model="createForm.forms.{{ $form['id'] }}" :value="$form['id']" :label="$form['name']" />
                                </div>
                            @endforeach
                            <x-jet-input-error for="createForm.forms" class="mt-2" />
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
            @endif
        </div>
    @endif

    @if ($organization->events->isNotEmpty())
        <x-jet-section-border />
        <div class="mt-10 sm:mt-0">
            <x-jet-action-section>
                <x-slot name="title">
                    {{ __('Growth Boards') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('All of the Growth Boards that are part of this organization.') }}
                </x-slot>

                <!-- Organization Organization List -->
                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($organization->events->sortBy('name') as $event)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="ml-4">{{ $event->name }}</div>
                                </div>

                                <div class="flex items-center">

                                    @if (Gate::check('viewEvent', $organization))
                                        <a class="ml-6 text-sm text-blue-500 cursor-pointer focus:outline-none" href="{{ route('events.show', $event->id) }}">
                                            {{ __('View') }}
                                        </a>
                                    @endif

                                    @if (Gate::check('updateEvent', $organization))
                                        <button class="ml-6 text-sm text-blue-500 cursor-pointer focus:outline-none" wire:click="confirmUpdate('{{ $event->id }}')">
                                            {{ __('Update') }}
                                        </button>
                                    @endif

                                    @if (Gate::check('removeEvent', $organization))
                                        <button class="ml-6 text-sm text-red-500 cursor-pointer focus:outline-none" wire:click="confirmDestroy('{{ $event->id }}')">
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

    <!-- Uodate Event Confirmation Modal -->
    <x-jet-dialog-modal wire:model="confirmingUpdating">
        <x-slot name="title">
            {{ __('Update Growth Board') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 mb-4 sm:col-span-4">
                <x-jet-label for="name" value="{{ __('Growth Board Name') }}" />
                <x-jet-input id="name" type="text" class="block w-full mt-1" model="updateForm.name" wire:model.defer="updateForm.name" />
                <x-jet-input-error for="name" class="mt-2" />
            </div>

            <div class="col-span-6 mb-4 sm:col-span-4">
                <x-jet-label for="team" value="{{ __('Teams') }}" />
                @foreach($organization->teams as $id => $team)
                    <div class="py-2">
                        <x-jet-label :for="Str::slug('updateTeam-'.$team['name'])">
                            <x-jet-checkbox :name="Str::slug('updateTeam-'.$team['name'])" :id="Str::slug('updateTeam-'.$team['name'])" wire:model="updateForm.teams.{{ $team['id'] }}" :value="$team['id']" />
                            {{ $team['name'] }}
                        </x-jet-label>
                    </div>
                @endforeach
                <x-jet-input-error for="updateForm.teams" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="forms" value="{{ __('Attach Form') }}" />
                @foreach($organization->forms as $id => $form)
                    <div class="py-2">
                        <x-radio :name="Str::slug('updateForm-'.$form['name'])" :id="Str::slug('updateForm-'.$form['name'])" wire:model="updateForm.forms.{{ $form['id'] }}" :value="$form['id']" :label="$form['name']" />
                    </div>
                @endforeach
                <x-jet-input-error for="updateForm.forms" class="mt-2" />
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

    <!-- Remove Event Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingDestroying">
        <x-slot name="title">
            {{ __('Remove Growth Board') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to remove this Growth Board from the organization?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingDestroying')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="destroy" spinner="destroy">
                {{ __('Remove') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
