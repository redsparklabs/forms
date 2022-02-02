<div>
    @if (Gate::check('addTeam', $organization))
        <div class="mt-10 sm:mt-0">
            <x-jet-form-section submit="create">
                <x-slot name="title">
                    {{ __('Add Project') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Add a new Project to your organization.') }}
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6">
                        <div class="max-w-xl text-sm text-gray-600">
                            {{ __('Please provide the name of the project you would like to add to this organization.') }}
                        </div>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="name" value="{{ __('Project Name') }}" />
                        <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.defer="createForm.name" />
                        <x-jet-input-error for="createForm.name" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
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

                <x-slot name="actions">
                    <x-jet-action-message class="mr-3" on="created">
                        {{ __('Added.') }}
                    </x-jet-action-message>

                    <x-jet-button spinner="create">
                        {{ __('Add') }}
                    </x-jet-button>
                </x-slot>
            </x-jet-form-section>
        </div>
    @endif
</div>
