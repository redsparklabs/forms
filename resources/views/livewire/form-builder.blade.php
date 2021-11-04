
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 mt-5">
    <div class="max-w-3xl mx-auto">
        <div x-data="{ shown: false }"
            x-init="@this.on('created', () => {shown = true})"
            x-show.transition.out.opacity.duration.1500ms="shown"
            style="display: none;">
            Thanks
        </div>

        <form x-data="{ shown: true }"
            x-init="@this.on('created', () => {shown = false})"
            x-show.transition.out.opacity.duration.1500ms="shown"
            wire:submit.prevent="create"
        >
            <div class="bg-white border-b border-gray-200 rounded-md mb-4">
                <h3 class="text-lg leading-6 font-medium text-blue-900 bg-blue-100 p-3 rounded-t-md">Business Model Confidence Scoring</h3>
                 <div class="p-3">
                    {!! config('questions.overall_description') !!}
                </div>
            </div>

            <div class="bg-white border-b border-gray-200 rounded-md mb-4 pb-4">
                <h3 class="text-lg leading-6 font-medium text-blue-900 bg-blue-100 p-3 rounded-t-md">Confidence Score Scale</h3>
                <img src="{{ url('img/confidence_store.png') }}" alt="Confidence Score"/>
            </div>

            <div class="bg-white border-b border-gray-200 rounded-md mb-4">
                <h3 class="text-lg leading-6 font-medium text-blue-900 bg-blue-100 p-3 rounded-t-md">Email</h3>
                <div class="p-4">
                    <label for="email">
                        <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="create_form.email" />
                    </label>
                    <x-jet-input-error for="email" class="mt-2" />
                </div>
            </div>

            @if($form->clubs->count() > 1)
                <div class="bg-white border-b border-gray-200 rounded-md mb-4">
                    <h3 class="text-lg leading-6 font-medium text-blue-900 bg-blue-100 p-3 rounded-t-md">Team</h3>
                    <div class="p-4">
                        @foreach($form->clubs->all() as $club)
                            <div class="p-3">
                                <x-jet-label for="{{ $club['name'] }}">
                                    <x-jet-checkbox name="{{ $club['name'] }}" id="{{ $club['name'] }}" wire:model.defer="create_form.club.{{ $club['id'] }}" value="{{ $club['id'] }}" /> {{ $club['name'] }}
                                </x-jet-label>
                            </div>
                        @endforeach
                        <x-jet-input-error for="club" class="mt-2" />
                    </div>
                </div>
            @endif

            @foreach(config('questions.business-model') as $question)
                @php
                    $slug = Str::slug($question['question'])
                @endphp
                <div class="bg-white border-b border-gray-200 rounded-md mb-4 p-4">
                    <h3 class="text-lg leading-6 font-medium">{{ $question['question'] }}</h3>
                    <div>{{ $question['description'] }}</div>

                    <div class="flex items-center mt-5 m-auto">
                        <div class="flex-initial">
                            Not Applicable (N/A)
                        </div>
                        <div class="flex-1 text-center">
                            <div><label for="score-[{{ $slug }}]-1" name="score-[{{ $slug }}]-1">1</label></div>
                            <x-radio id="score-[{{ $slug }}]-1" tabindex="" class="m-auto" wire:model.defer="create_form.questions.{{ $slug }}" value="1" />
                        </div>
                        <div class="flex-1 text-center">
                            <div><label for="score-[{{ $slug }}]-2" name="score-[{{ $slug }}]-2">2</label></div>
                            <x-radio id="score-[{{ $slug }}]-2" class="m-auto" wire:model.defer="create_form.questions.{{ $slug }}" value="2" />
                        </div>
                        <div class="flex-1 text-center">
                            <div><label for="score-[{{ $slug }}]-3" name="score-[{{ $slug }}]-3">3</label></div>
                            <x-radio id="score-[{{ $slug }}]-3" class="m-auto" wire:model.defer="create_form.questions.{{ $slug }}" value="3" />
                        </div>
                        <div class="flex-1 text-center">
                            <div><label for="score-[{{ $slug }}]-4" name="score-[{{ $slug }}]-4">4</label></div>
                            <x-radio id="score-[{{ $slug }}]-4" class="m-auto" wire:model.defer="create_form.questions.{{ $slug }}" value="4" />
                        </div>
                        <div class="flex-1 text-center">
                            <div><label for="score-[{{ $slug }}]-5" name="score-[{{ $slug }}]-5">5</label></div>
                            <x-radio id="score-[{{ $slug }}]-5" class="m-auto" wire:model.defer="create_form.questions.{{ $slug }}" value="5" />
                        </div>
                        <div class="flex-initial">
                            High Confidence
                        </div>
                    </div>
                    <x-jet-input-error for="questions.{{ $slug }}" class="mt-2" />
                </div>
            @endforeach

            @foreach(config('questions.qualitative-intuitive-scoring') as $question)
                @php
                    $slug = Str::slug($question['question'])
                @endphp
                <div class="bg-white border-b border-gray-200 rounded-md mb-4 p-4">
                    <h3 class="text-lg leading-6 font-medium">{{ $question['question'] }}</h3>
                    <div>{{ $question['description'] }}</div>

                    <div class="flex items-center mt-5 m-auto">
                        <div class="flex-initial">
                            Not Applicable (N/A)
                        </div>
                        <div class="flex-1 text-center">
                            <div><label for="score-[{{ $slug }}]-1" tabindex="" name="score-[{{ $slug }}]-1">1</label></div>
                            <x-radio id="score-[{{ $slug }}]-1" class="m-auto" wire:model.defer="create_form.questions.{{ $slug }}" value="1" />
                        </div>
                        <div class="flex-1 text-center">
                            <div><label for="score-[{{ $slug }}]-2" name="score-[{{ $slug }}]-2">2</label></div>
                            <x-radio id="score-[{{ $slug }}]-2" class="m-auto" wire:model.defer="create_form.questions.{{ $slug }}" value="2" />
                        </div>
                        <div class="flex-1 text-center">
                            <div><label for="score-[{{ $slug }}]-3" name="score-[{{ $slug }}]-3">3</label></div>
                            <x-radio id="score-[{{ $slug }}]-3" class="m-auto" wire:model.defer="create_form.questions.{{ $slug }}" value="3" />
                        </div>
                        <div class="flex-1 text-center">
                            <div><label for="score-[{{ $slug }}]-4" name="score-[{{ $slug }}]-4">4</label></div>
                            <x-radio id="score-[{{ $slug }}]-4" class="m-auto" wire:model.defer="create_form.questions.{{ $slug }}" value="4" />
                        </div>
                        <div class="flex-1 text-center">
                            <div><label for="score-[{{ $slug }}]-5" name="score-[{{ $slug }}]-5">5</label></div>
                            <x-radio id="score-[{{ $slug }}]-5" class="m-auto" wire:model.defer="create_form.questions.{{ $slug }}" value="5" />
                        </div>
                        <div class="flex-initial">
                            High Confidence
                        </div>
                    </div>

                    <x-jet-input-error for="questions.{{ $slug }}" class="mt-2" />
                </div>
            @endforeach

            <!-- @foreach($form->questions->all() as $question)
                @php
                    $slug = Str::slug($question['question'])
                @endphp
                <div class="bg-white border-b border-gray-200 rounded-md mb-4 p-4">
                    <h3 class="text-lg leading-6 font-medium">{{ $question['question'] }}</h3>
                    <div>{{ $question['description'] }}</div>

                    <div class="flex items-center mt-5 m-auto">
                        <div class="flex-initial">
                            Not Applicable (N/A)
                        </div>
                        <div class="flex-1 text-center">
                            <div><label for="score-[{{ $slug }}]-1" tabindex="" name="score-[{{ $slug }}]-1">1</label></div>
                            <x-radio id="score-[{{ $slug }}]-1" class="m-auto" wire:model.defer="create_form.questions.{{ $slug }}" value="1" />
                        </div>
                        <div class="flex-1 text-center">
                            <div><label for="score-[{{ $slug }}]-2" name="score-[{{ $slug }}]-2">2</label></div>
                            <x-radio id="score-[{{ $slug }}]-2" class="m-auto" wire:model.defer="create_form.questions.{{ $slug }}" value="2" />
                        </div>
                        <div class="flex-1 text-center">
                            <div><label for="score-[{{ $slug }}]-3" name="score-[{{ $slug }}]-3">3</label></div>
                            <x-radio id="score-[{{ $slug }}]-3" class="m-auto" wire:model.defer="create_form.questions.{{ $slug }}" value="3" />
                        </div>
                        <div class="flex-1 text-center">
                            <div><label for="score-[{{ $slug }}]-4" name="score-[{{ $slug }}]-4">4</label></div>
                            <x-radio id="score-[{{ $slug }}]-4" class="m-auto" wire:model.defer="create_form.questions.{{ $slug }}" value="4" />
                        </div>
                        <div class="flex-1 text-center">
                            <div><label for="score-[{{ $slug }}]-5" name="score-[{{ $slug }}]-5">5</label></div>
                            <x-radio id="score-[{{ $slug }}]-5" class="m-auto" wire:model.defer="create_form.questions.{{ $slug }}" value="5" />
                        </div>
                        <div class="flex-initial">
                            High Confidence
                        </div>
                    </div>

                    <x-jet-input-error for="questions.{{ $slug }}" class="mt-2" />
                </div>
            @endforeach -->

            <!-- @foreach(config('questions.qualitative-intuitive-scoring-feedback') as $question)
                @php
                    $slug = Str::slug($question['question'])
                @endphp
                <div class="bg-white border-b border-gray-200 rounded-md mb-4 p-4">
                    <x-textarea label="{{ $question['question'] }}" tabindex="" wire:model.defer="create_form.questions.custom.{{ $slug }}" />
                    <x-jet-input-error for="questions.custom.{{ $slug }}" class="mt-2" />
                </div>
            @endforeach -->

            @foreach($form->questions->all() as $question)
                @php
                    $slug = Str::slug($question['question'])
                @endphp
                <div class="bg-white border-b border-gray-200 rounded-md mb-4 p-4">
                    <x-textarea label="{{ $question['question'] }}" tabindex="" wire:model.defer="create_form.questions.custom.{{ $slug }}" :hint="$question['description']"/>
                    <x-jet-input-error for="questions.custom.{{ $slug }}" class="mt-2" />
                </div>
            @endforeach

            <div class="pt-5">
                <div class="flex justify-end">
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
