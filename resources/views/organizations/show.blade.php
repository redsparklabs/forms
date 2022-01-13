<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Organization Settings') }}
        </h2>
    </x-slot>

    <div>
        <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">

            @livewire('organizations.update-organization-name-form', ['organization' => $organization])

            @livewire('organizations.organization-member-manager', ['organization' => $organization])

        </div>
    </div>
</x-app-layout>
