<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Team Settings') }}
        </h2>
    </x-slot>

    <div>
        <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
            @livewire('club-manager', ['team' => $team])
        </div>
    </div>
</x-app-layout>
