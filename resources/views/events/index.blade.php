<div>
    <header class="bg-white shadow">
        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        {{ __('Assessments')}}
                    </h2>
                </div>
                <div>
                    @if (Gate::check('addEvent', $organization) && $organization->teams->isNotEmpty())
                        <x-buttons.green :text="__('Schedule Assessment')" wire:click="confirmCreate()" />
                    @endif
                </div>
            </div>
        </div>
    </header>

    <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">

        <x-jet-action-section :background="false">
            <x-slot name="title">
                {{ __('Assessments') }}
            </x-slot>

            <x-slot name="description">
                {{ __('All of the Assessments that are part of this organization.') }}
            </x-slot>

            <x-slot name="content">
                @if($organization->teams->isEmpty())
                    <div class="mb-10 overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <tr class="bg-white">
                                <td class="px-6 py-4 text-sm font-medium text-center text-gray-500 cursor-pointer whitespace-nowrap" colspan="6">
                                    {{ __('You need some Projects to Schedule a Growth Board.')}} {{ __('Go ahead and') }} <a class="text-blue-500 underline" href="{{ route('teams.index', 'create') }}">{{ __('add one') }}</a>!
                                </td>
                            </tr>
                        </table>
                    </div>
                @endif
                @if($organization->teams()->withTrashed()->get()->isNotEmpty() || $organization->teams->isNotEmpty())
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
                                                <th scope="col" class="py-3 pl-6 pr-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900" wire:click="sortBy('name')">
                                                    {{ __('Name') }}
                                                    @if($events->count() > 1)
                                                        <x-sort :dir="$sortDirection" :active="$sortByField == 'name'"/>
                                                    @endif
                                                </th>
                                                <th scope="col" class="py-3 pl-6 pr-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900" wire:click="sortBy('date')">
                                                    {{ __('Date') }}
                                                    @if($events->count() > 1)
                                                        <x-sort :dir="$sortDirection" :active="$sortByField == 'date'"/>
                                                    @endif
                                                </th>
                                                <th scope="col" class="py-3 pl-6 pr-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($events as $event)
                                                <tr @class([
                                                    'bg-white' => $loop->odd,
                                                    'bg-gray-50' => $loop->even
                                                ])>
                                                    <td class="px-6 py-4 text-sm font-medium text-gray-500 whitespace-nowrap">
                                                        {{ $event->name }}
                                                    </td>


                                                    <td class="px-6 py-4 text-sm font-medium text-gray-500 whitespace-nowrap">
                                                        {{ $event->date?->format('m/d/y') }}
                                                    </td>

                                                    <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                                        @if(Gate::check('viewEvent', $organization))
                                                            <x-buttons.green-link :text="__('View Results')" href="{{ route('events.show', $event->id) }}" />
                                                        @endif


                                                        @if(Gate::check('updateEvent', $organization))
                                                            <x-buttons.yellow wire:click="confirmUpdate('{{ $event->id }}')">
                                                                {{ __('Update') }}
                                                            </x-buttons.yellow>
                                                        @endif

                                                        {{-- @if (Gate::check('removeEvent', $organization))
                                                            <button class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" wire:click="confirmDestroy('{{ $event->id }}')">
                                                                {{ __('Archive') }}
                                                            </button>
                                                        @endif --}}
                                                    </td>
                                                </tr>
                                            @empty
                                                @if(!$keyword)
                                                    <tr class="bg-white">
                                                        <td class="px-6 py-4 text-sm font-medium text-center text-gray-500 whitespace-nowrap" colspan="6">
                                                            {{ __('No Growth Boards created.')}} {{ __('Go ahead and') }} <a class="text-blue-500 underline cursor-pointer" wire:click="confirmCreate()">{{ __('schedule one') }}</a>!
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr class="bg-white">
                                                        <td class="px-6 py-4 text-sm font-medium text-center text-gray-500 whitespace-nowrap" colspan="6">
                                                            {{ __('No Growth Boards found.') }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforelse
                                        </tbody>
                                    </table>
                                    @if($events->hasPages())
                                        <div class="p-4">
                                            {{ $events->links() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </x-slot>
        </x-jet-action-section>

        <!-- Create Event Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingCreating">
            <x-slot name="title">
                {{ __('Add Assessment') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Add a new assessment to your organization.') }}
            </x-slot>

            <x-slot name="content">

                <div class="col-span-6 mb-4 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('Growth Board Name') }}" />
                    <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.defer="createForm.name" />
                    <x-jet-input-error for="createForm.name" class="mt-2" />
                </div>

                <div class="col-span-6 mb-4 sm:col-span-4">
                    <x-jet-label for="date" value="{{ __('Date') }}" />
                    <x-jet-input id="date" onkeydown="return false" type="date" class="block w-full mt-1" required pattern="\d{4}-\d{2}-\d{2}" wire:model.defer="createForm.date" />
                    <x-jet-input-error for="createForm.date" class="mt-2" />
                </div>

                <div class="col-span-6 mb-4 sm:col-span-4">
                    <x-jet-label for="team" value="{{ __('Projects') }}" />
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($organization->teams as $id => $team)
                            <div class="py-2">
                                <x-jet-label :for="'team.'.$id">
                                    <x-jet-checkbox name="team" :id="'team.'.$id" wire:model="createForm.teams" :value="$team['id']" />
                                    {{ $team['name'] }}
                                </x-jet-label>
                            </div>
                        @endforeach
                    </div>
                    <x-jet-input-error for="createForm.teams" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="forms" value="{{ __('Attach Form') }}" />
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($organization->forms as $id => $form)
                            <div class="py-2">
                                <x-radio name="form" :id="'form.'.$id" wire:model.defer="createForm.forms" :value="$form['id']" :label="$form['name']" />
                            </div>
                        @endforeach
                    </div>
                    <x-jet-input-error for="createForm.forms" class="mt-2" />
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
        </x-jet-form-section>

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

        <!-- Remove Event Confirmation Modal -->
        <x-jet-confirmation-modal wire:model="confirmingDestroying">
            <x-slot name="title">
                {{ __('Archive Growth Board') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you would like to archive this Growth Board from the organization?') }}
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
    </div>
</div>
