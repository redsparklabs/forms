<div>
    @if (Gate::check('addEvent', $organization))
        <div class="mt-10 sm:mt-0">
             @if($organization->forms->isEmpty())
                <div class="p-6 text-center bg-white rounded-md">Please <a href="{{ route('form-manager', Auth::user()->currentOrganization->id) }}" class="text-blue-900 underline">add</a> at least one Form before creating a Growth Board.</div>

            @elseif($organization->teams->isEmpty())
                <div class="p-6 text-center bg-white rounded-md">Please <a href="{{ route('teams.create', Auth::user()->currentOrganization->id) }}" class="text-blue-900 underline">add</a> at least one Project before creating a Growth Board.</div>
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
                            <x-jet-label for="team" value="{{ __('Projects') }}" />
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

</div>
