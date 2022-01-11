<x-app-layout>
    <x-slot name="header">

        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ Auth::user()->currentOrganization->name }} {{ __('Portfolio') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-jet-section-border />
            <!-- Manage Organizations -->
            <div class="mt-10 sm:mt-0">
                <x-jet-action-section>
                    <x-slot name="title">
                        {{ __('Events') }}
                    </x-slot>

                    <x-slot name="description"></x-slot>

                    <x-slot name="content">
                        <div class="space-y-6">
                            @foreach (Auth::user()->currentOrganization->events->sortBy('name') as $event)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center w-full">
                                        <div class="ml-4 w-1/2">{{ $event->name }}</div>

                                        <div class="ml-4 w-1/2">{{ $event->created_at->format('m-d-Y') }}</div>
                                    </div>

                                    <div class="flex items-center">
                                        <a class="ml-6 text-sm text-blue-500 cursor-pointer focus:outline-none" href="{{ route('events.show', $event->id) }}">
                                            {{ __('View') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-slot>
                </x-jet-action-section>
            </div>
        </div>
    </div>
</x-app-layout>