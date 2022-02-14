<div>
    <header class="bg-white shadow">
        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <div class="flex justify-content">
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        {{ __('Growth Board - ' . $event->name) }} - {{ $event->date?->format('m/d/y') }}
                        <x-buttons.yellow wire:click="confirmUpdate('{{ $event->id }}')">
                            {{ __('Update') }}
                        </x-buttons.yellow>
                    </h2>
                    </div>
                <div>

                    <a class="mr-2 text-xs hover:text-karban-green-4" href="{{ route('form-builder', $event->slug) }}" target="_blank">{{ route('form-builder', $event->slug) }}</a>
                        <x-buttons.green data-clipboard-text="{{ route('form-builder', $event->slug) }}">
                            {{ __('Copy Link') }}
                        </x-buttons.green>
                </div>
            </div>
        </div>
    </header>

    <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <x-jet-action-section :background="false">
            <x-slot name="title">
                {{ __('Projects') }}
            </x-slot>

            <x-slot name="description">
                {{ __('All of the projects that are part of this Growth Board.') }}
            </x-slot>

            <x-slot name="content">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <div class="flex justify-end">
                                <div class="w-1/4 mb-2">
                                    <x-jet-input id="keywords" type="text" class="block w-full mt-1" wire:model="keyword" :placeholder="__('Search')"/>
                                </div>
                            </div>
                            <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900" wire:click="sortBy('name')">
                                                {{ __('Name') }}
                                                @if($teams->count() > 1)
                                                    <x-sort :dir="$sortDirection" :active="$sortByField == 'name'"/>
                                                @endif
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                {{ __('Progress Metric') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900" wire:click="sortBy('priority_level')">
                                                {{ __('Priority Level') }}
                                                @if($teams->count() > 1)
                                                    <x-sort :dir="$sortDirection" :active="$sortByField == 'priority_level'"/>
                                                @endif
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">

                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($teams as $team)
                                            <tr @class([
                                                'bg-white' => $loop->odd,
                                                'bg-gray-50' => $loop->even
                                            ])>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                    <a class="text-blue-500 underline" href="{{ route('teams.show', $team->id) }}">{{ $team->name }}</a>
                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-500 whitespace-nowrap">

                                                   <span class="font-bold text-lg text-{{ colorize($team->events()->find($event->id)->progressMetric($team)) }}">{{ $team->events()->find($event->id)->progressMetric($team) }}</span>
                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-500 whitespace-nowrap">
                                                    {{ $team->priority_level }}
                                                </td>
                                                 <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                                    <x-buttons.green-link href="{{ route('events.results', [$event->id, $team->id]) }}">  {{ __('View Results') }}</x-buttons.green-link>
                                                </td>
                                            </tr>
                                        @empty
                                            @if(!$keyword)
                                                <tr class="bg-white">
                                                    <td class="px-6 py-4 text-sm font-medium text-gray-500 whitespace-nowrap text-center" colspan="4">
                                                        {{ __('No Projects created.')}} {{ __('Go ahead and') }} <a class="text-blue-500 underline" href="{{ route('teams.index', 'create') }}">{{ __('add one') }}</a>!
                                                    </td>
                                                </tr>
                                            @else
                                                <tr class="bg-white">
                                                    <td class="px-6 py-4 text-sm font-medium text-center text-gray-500 whitespace-nowrap" colspan="4">
                                                        {{ __('No Projects found.') }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforelse
                                    </tbody>
                                </table>
                                @if($teams->hasPages())
                                    <div class="p-4">
                                        {{ $teams->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </x-slot>
        </x-jet-action-section>
    </div>

        <!-- Update Event Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingUpdating">
        <x-slot name="title">
            {{ __('Update Growth Board') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 mb-4 sm:col-span-4">
                <x-jet-label for="name" value="{{ __('Growth Board Name') }}" />
                <x-jet-input id="name" type="text" class="block w-full mt-1" model="updateForm.name" wire:model.defer="updateForm.name" />
                <x-jet-input-error for="updateForm.name" class="mt-2" />
            </div>

            <div class="col-span-6 mb-4 sm:col-span-4">
                <x-jet-label for="date" value="{{ __('Date') }}" />
                <x-jet-input id="date" onkeydown="return false" type="date" class="block w-full mt-1" required pattern="\d{4}-\d{2}-\d{2}" wire:model.defer="updateForm.date" />
                <x-jet-input-error for="updateForm.date" class="mt-2" />
            </div>

            <div class="col-span-6 mb-4 sm:col-span-4">
                <x-jet-label for="team" value="{{ __('Teams') }}" />
                <div class="grid grid-cols-4 gap-4">
                    @foreach($organization->teams as $id => $team)
                        <div class="py-2">
                            <x-jet-label for="teams.{{ $team['id'] }}">
                                <x-jet-checkbox name="team" id="teams.{{ $team['id'] }}" wire:model="updateForm.teams.{{ $team['id'] }}" :value="$team['id']" />
                                {{ $team['name'] }}
                            </x-jet-label>
                        </div>
                    @endforeach
                </div>
                <x-jet-input-error for="updateForm.teams" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="forms" value="{{ __('Attach Form') }}" />
                <div class="grid grid-cols-4 gap-4">
                    @foreach($organization->forms as $id => $form)
                        <div class="py-2">
                            <x-radio name="form" id="forms.{{ $form['id'] }}" wire:model="updateForm.forms" :value="$form['id']" :label="$form['name']" />
                        </div>
                    @endforeach
                </div>
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
</div>

