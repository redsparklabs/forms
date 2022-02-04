<div>
    <header class="bg-white shadow">
        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        {{ __('Organization Questions')}}
                    </h2>
                </div>
                <div>
                    @if (Gate::check('addQuestion', $organization))
                        <button class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" wire:click="confirmCreate()">
                            {{ __('Create') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
         <div class="mt-10 sm:mt-0">
                <!-- Manage Questions -->
            <div class="mt-10 sm:mt-0">
                <x-jet-action-section :background="false">
                    <x-slot name="title">
                        {{ __('Questions') }}
                    </x-slot>

                    <x-slot name="description">
                        {{ __('All of the questions that are part of this organization.') }}
                    </x-slot>

                    <x-slot name="content">
                        <div class="flex flex-col">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                     <div class="flex justify-end">
                                        <div class="w-1/4 mb-2">
                                            <x-jet-input id="keywords" type="text" class="block w-full mt-1" wire:model="keyword" :placeholder="__('Search')"/>
                                        </div>
                                    </div>
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                 <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hover:text-gray-900 cursor-pointer" wire:click="sortBy('question')">
                                                        {{ __('Question') }}
                                                        @if($questions->count() > 1)
                                                            <x-sort :dir="$sortDirection" :active="$sortByField == 'question'"/>
                                                        @endif
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hover:text-gray-900 cursor-pointer" wire:click="sortBy('description')">
                                                        {{ __('Description') }}
                                                        @if($questions->count() > 1)
                                                            <x-sort :dir="$sortDirection" :active="$sortByField == 'description'"/>
                                                        @endif
                                                    </th>
                                                    <th scope="col" class="relative px-6 py-3">

                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($questions as $question)
                                                    <tr @class([
                                                        'bg-white' => $loop->odd,
                                                        'bg-gray-50' => $loop->even
                                                    ])>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                                            {{ $question->question}}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                                            {{ Str::of($question->description)->limit(60) }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                            @if (Gate::check('updateQuestion', $organization))
                                                                <button class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" wire:click="confirmUpdate('{{ $question->id }}')">
                                                                    {{ __('Update') }}
                                                                </button>
                                                            @endif

                                                            @if (Gate::check('removeQuestion', $organization))
                                                                <button class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" wire:click="confirmDestroy('{{ $question->id }}')">
                                                                    {{ __('Archive') }}
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                     @if(!$keyword)
                                                        <tr class="bg-white">
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 text-center" colspan="6">
                                                                {{ __('No Questions created.')}} {{ __('Go ahead and') }} <a class="text-blue-500 underline" wire:click="confirmCreate()">{{ __('create one') }}</a>!
                                                            </td>
                                                        </tr>
                                                    @else
                                                        <tr class="bg-white">
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 text-center" colspan="4">
                                                                {{ __('No Questions found.') }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforelse
                                            </tbody>
                                        </table>
                                        @if($questions->hasPages())
                                            <div class="p-4">
                                                {{ $questions->links() }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-slot>
                </x-jet-action-section>
            </div>

            <!-- Create Question Confirmation Modal -->
            <x-jet-dialog-modal wire:model="confirmingCreating">
                <x-slot name="title">
                    {{ __('Create Question') }}
                </x-slot>

                <x-slot name="content">
                     <div class="col-span-6 sm:col-span-4 mb-4">
                        <x-jet-label for="question" value="{{ __('Question') }}" />
                        <x-jet-input id="question" type="text" class="block w-full mt-1" wire:model.defer="createForm.question" />
                        <x-jet-input-error for="createForm.question" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="description" value="{{ __('Description') }}" />
                        <x-jet-textarea id="description" type="text" class="block w-full mt-1" wire:model.defer="createForm.description" />
                        <x-jet-input-error for="createForm.description" class="mt-2" />
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

            <!-- Uodate Question Confirmation Modal -->
            <x-jet-dialog-modal wire:model="confirmingUpdating">
                <x-slot name="title">
                    {{ __('Update Question') }}
                </x-slot>

                <x-slot name="content">
                    <div class="col-span-6 mb-4 sm:col-span-4">
                        <x-jet-label for="question" value="{{ __('Question') }}" />
                        <x-jet-input id="question" type="text" class="block w-full mt-1" wire:model.defer="updateForm.question" />
                        <x-jet-input-error for="question" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="description" value="{{ __('Description') }}" />
                        <x-jet-textarea id="description" type="text" class="block w-full mt-1" wire:model.defer="updateForm.description" />
                        <x-jet-input-error for="description" class="mt-2" />
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

            <!-- Remove Question Confirmation Modal -->
            <x-jet-confirmation-modal wire:model="confirmingDestroying">
                <x-slot name="title">
                    {{ __('Archive Question') }}
                </x-slot>

                <x-slot name="content">
                    {{ __('Are you sure you would like to archive this question?') }}
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
</div>
