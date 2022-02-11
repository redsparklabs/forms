<x-jet-confirmation-modal wire:model="confirmingDestroying">
    <x-slot name="title">
        {{ __('Archive Project') }}
    </x-slot>

    <x-slot name="content">
        {{ __('Are you sure you would like to archive this project?') }}
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
