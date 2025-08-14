<div>
    <header class="bg-white shadow">
        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        {{ __('Organization Assessments')}}
                    </h2>
                </div>
                <div>
                    @if (Gate::check('addForm', $organization))
                        <x-buttons.green  wire:click="confirmCreate()">{{ __('Create') }}</x-buttons.green>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mt-10 sm:mt-0">
            <x-jet-action-section :background="false">
                <x-slot name="title">
                    {{ __('Assessments') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('All of the assessments that are part of this organization.') }}
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
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hover:text-gray-900 cursor-pointer" wire:click="sortBy('name')">
                                                    {{ __('Name') }}
                                                    @if($forms->count() > 1)
                                                        <x-sort :dir="$sortDirection" :active="$sortByField == 'name'"/>
                                                    @endif
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hover:text-gray-900 cursor-pointer" wire:click="sortBy('description')">
                                                    {{ __('Description') }}
                                                    @if($forms->count() > 1)
                                                        <x-sort :dir="$sortDirection" :active="$sortByField == 'description'"/>
                                                    @endif
                                                </th>
                                                <th scope="col" class="relative px-6 py-3">

                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($forms as $form)
                                                <tr @class([
                                                    'bg-white' => $loop->odd,
                                                    'bg-gray-50' => $loop->even
                                                ])>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                                        {{ $form->name}}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                                        {{ Str::of($form->description)->limit(60) }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        @if (Gate::check('updateForm', $organization))
                                                            <x-buttons.yellow wire:click="confirmUpdate('{{ $form->id }}')">{{ __('Update') }}</x-buttons.yellow>

                                                        @endif

                                                        @if (Gate::check('updateForm', $organization))
                                                           <x-buttons.green-link href="{{ route('form-builder', $form->id) }}" target="_blank">
                                                                {{ __('View') }}
                                                            </x-buttons.green-link>
                                                        @endif

                                                        {{-- @if (Gate::check('removeForm', $organization))
                                                            <button class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" wire:click="confirmDestroy('{{ $form->id }}')">
                                                                {{ __('Archive') }}
                                                            </button>
                                                        @endif --}}
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
                                    @if($forms->hasPages())
                                        <div class="p-4">
                                            {{ $forms->links() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </x-slot>
            </x-jet-action-section>
        </div>

        <x-jet-dialog-modal wire:model="confirmingCreating">
           <x-slot name="title">
                {{ __('Add Form') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Add a new form to your organization.') }}
            </x-slot>

            <x-slot name="content">
                <div class="col-span-6 mb-2 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.defer="createForm.name" />
                    <x-jet-input-error for="createForm.name" class="mt-2" />
                </div>


                <div class="col-span-6 mb-2 sm:col-span-4">
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

        <!-- Uodate Form Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingUpdating">
            <x-slot name="title">
                {{ __('Update Assessment') }}
            </x-slot>

            <x-slot name="content">
                <!-- Organization Name -->
                <div class="col-span-6 mb-4 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('Form Name') }}" />
                    <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.defer="updateForm.name" />
                    <x-jet-input-error for="name" class="mt-2" />
                </div>

                <div class="col-span-6 mb-4 sm:col-span-4">
                    <x-jet-label for="description" value="{{ __('Description') }}" />
                    <x-jet-textarea id="description" type="text" class="block w-full mt-1" wire:model.defer="updateForm.description" />
                    <x-jet-input-error for="description" class="mt-2" />
                </div>

                @if ($allQuestions->isNotEmpty())
                    @php
                        $counter = 0;
                    @endphp
                    <div class="col-span-6 lg:col-span-4">
                        <x-jet-label for="role" value="{{ __('Questions') }}" />
                        <x-jet-input-error for="Questions" class="mt-2" />
                        <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                            @foreach($allQuestions as $index => $question)
                                @php
                                    $counter++;
                                @endphp
                                <div class="flex">
                                    <button type="button" class="flex-initial relative px-4 py-3 w-full rounded-lg focus:z-10 focus:outline-none {{ $index > 0 ? 'border-t border-gray-200 rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}" wire:click="syncQuestion({{ $question->id }})">
                                        <div class="{{ $assignedQuestions->contains($question->id) ? '' : 'opacity-50 hover:opacity-100' }}">

                                            <div class="flex items-center text-left">
                                                @if ($assignedQuestions->contains($question->id))
                                                    <div class="flex-initial">
                                                        <svg class="w-8 h-8 mr-2 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    </div>
                                                @endif

                                                <div class="flex-1 text-left ">
                                                    <div class="flex">
                                                        <div class="text-sm text-gray-600 p-2 {{ $assignedQuestions->contains($question->id) ? 'font-semibold' : '' }}">
                                                            {{ $question->question }}
                                                        </div>

                                                         <div class="p-2 text-xs text-left text-gray-600">
                                                            {{ $question->description }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                    @if ($assignedQuestions->contains($question->id))
                                        @php
                                            $counter--;
                                        @endphp
                                        <div class="flex-1 relative pl-2 py-3 pr-4 w-full rounded-lg focus:z-10 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 {{ $index > 0 ? 'border-t border-gray-200 rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}">
                                            @if($index != $counter)
                                                <a class="block text-blue-500 hover:text-green-500" wire:click="moveQuestionUp({{ $idBeingUpdated }}, {{ $question->id }})" title="Move Up">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z" /></svg>
                                                </a>
                                            @endif
                                            @if(!$loop->last)
                                                <a class="block text-blue-500 hover:text-green-500" wire:click="moveQuestionDown({{ $idBeingUpdated }}, {{ $question->id }})" title="Move Down">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" /></svg>
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingUpdating')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-2" wire:click="update" spinner="update">
                    {{ __('Submit') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>

        <!-- Remove Form Confirmation Modal -->
        <x-jet-confirmation-modal wire:model="confirmingDestroying">
            <x-slot name="title">
                {{ __('Archive Assessment') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you would like to archive this assessment?') }}
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
