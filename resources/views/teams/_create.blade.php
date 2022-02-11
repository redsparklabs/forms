<x-jet-dialog-modal wire:model="confirmingCreating">
    <x-slot name="title">
        {{ __('Create Project') }}
    </x-slot>

    <x-slot name="description"></x-slot>

    <x-slot name="content">
        <div class="col-span-6 mb-4 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Project Name') }}" required/>
            <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.defer="createForm.name" />
            <x-jet-input-error for="createForm.name" class="mt-2" />
        </div>

        <div class="col-span-6 mb-4 sm:col-span-4">
            <x-jet-label for="start_date" value="{{ __('Start Date') }}" required/>
            <x-jet-input id="start_date" onkeydown="return false" type="date" class="block w-full mt-1" required pattern="\d{4}-\d{2}-\d{2}" wire:model.defer="createForm.start_date" />
            <x-jet-input-error for="createForm.start_date" class="mt-2" />
        </div>

        <div class="col-span-6 mb-4 sm:col-span-4">
            <x-jet-label for="description" value="{{ __('Description') }}" required/>
            <x-jet-textarea id="description" type="text" class="block w-full mt-1" wire:model.defer="createForm.description" />
            <x-jet-input-error for="createForm.description" class="mt-2" />
        </div>

        <div class="col-span-6 mb-4 sm:col-span-4">
            <x-jet-label for="priority_level" value="{{ __('Priority Level') }}" />
            <x-jet-input id="priority_level" type="text" class="block w-full mt-1" wire:model.defer="createForm.priority_level" />
            <x-jet-input-error for="createForm.priority_level" class="mt-2" />
        </div>


        <div class="col-span-6 mb-4 sm:col-span-4">
            <x-jet-label for="minimum_success_criteria" value="{{ __('Minimum Success Criteria') }}" />
            <x-jet-input id="minimum_success_criteria" type="text" class="block w-full mt-1" wire:model.defer="createForm.minimum_success_criteria" />
            <x-jet-input-error for="createForm.minimum_success_criteria" class="mt-2" />
        </div>

        <div class="col-span-6 mb-4 sm:col-span-4">
            <x-jet-label for="sponsor" value="{{ __('Sponsor') }}" />
            <x-jet-input id="sponsor" type="text" class="block w-full mt-1" wire:model.defer="createForm.sponsor" />
            <x-jet-input-error for="createForm.sponsor" class="mt-2" />
        </div>

        <div class="col-span-6 mb-4 sm:col-span-4">
            <x-jet-label for="estimated_launch_date" value="{{ __('Estimated Launch Date') }}" />
            <x-jet-input id="estimated_launch_date" onkeydown="return false" type="date" class="block w-full mt-1" pattern="\d{4}-\d{2}-\d{2}" wire:model.defer="createForm.estimated_launch_date" />
            <x-jet-input-error for="createForm.estimated_launch_date" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('confirmingCreating')" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-2" wire:click="create" spinner="create">
            {{ __('Create') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>
