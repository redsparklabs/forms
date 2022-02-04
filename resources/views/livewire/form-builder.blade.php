
<div class="px-4 py-4 mx-auto mt-5 max-w-7xl sm:px-6 lg:px-8">
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
            <div class="mb-4 bg-white border-b border-gray-200 rounded-md">
                <h3 class="p-3 text-lg font-medium leading-6 text-blue-900 bg-blue-100 rounded-t-md">Business Model Confidence Scoring</h3>
                 <div class="p-3">
                    {!! config('questions.overall_description') !!}
                </div>
            </div>

            <div class="pb-4 mb-4 bg-white border-b border-gray-200 rounded-md">
                <h3 class="p-3 text-lg font-medium leading-6 text-blue-900 bg-blue-100 rounded-t-md">Confidence Score Scale</h3>
                <img src="{{ url('img/confidence_store.png') }}" alt="Confidence Score"/>
            </div>

            <div class="mb-4 bg-white border-b border-gray-200 rounded-md">
                <h3 class="p-3 text-lg font-medium leading-6 text-blue-900 bg-blue-100 rounded-t-md">Email</h3>
                <div class="p-4">
                    <label for="email">
                        <x-jet-input id="email" type="email" class="block w-full mt-1" wire:model.defer="create_form.email" />
                    </label>
                    <x-jet-input-error for="email" class="mt-2" />
                </div>
            </div>

            @if($event && $event->teams->count() > 1)
                <div class="mb-4 bg-white border-b border-gray-200 rounded-md">
                    <h3 class="p-3 text-lg font-medium leading-6 text-blue-900 bg-blue-100 rounded-t-md">Team</h3>
                    <div class="p-4">
                        @foreach($event->teams->all() as $team)
                            <div class="p-3">
                                <x-radio name="team" id="{{ $team['name'] }}" wire:model.defer="create_form.team" value="{{ $team['id'] }}" :label="$team['name']"/>
                            </div>
                        @endforeach
                        <x-jet-input-error for="team" class="mt-2" />
                    </div>
                </div>
            @endif

            @foreach(config('questions.business-model') as $question)
                @php
                    $slug = Str::slug($question['question'])
                @endphp
                <div class="p-4 mb-4 bg-white border-b border-gray-200 rounded-md">
                    <h3 class="text-lg font-medium leading-6">{{ $question['question'] }}</h3>
                    <div>{{ $question['description'] }}</div>

                    <div class="flex items-center m-auto mt-5">
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
                <div class="p-4 mb-4 bg-white border-b border-gray-200 rounded-md">
                    <h3 class="text-lg font-medium leading-6">{{ $question['question'] }}</h3>
                    <div>{{ $question['description'] }}</div>

                    <div class="flex items-center m-auto mt-5">
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
                <div class="p-4 mb-4 bg-white border-b border-gray-200 rounded-md">
                    <h3 class="text-lg font-medium leading-6">{{ $question['question'] }}</h3>
                    <div>{{ $question['description'] }}</div>

                    <div class="flex items-center m-auto mt-5">
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
                <div class="p-4 mb-4 bg-white border-b border-gray-200 rounded-md">
                    <x-textarea label="{{ $question['question'] }}" tabindex="" wire:model.defer="create_form.questions.custom.{{ $slug }}" />
                    <x-jet-input-error for="questions.custom.{{ $slug }}" class="mt-2" />
                </div>
            @endforeach -->

            @foreach($form->questions->all() as $question)
                @php
                    $slug = Str::slug($question['question'])
                @endphp
                <div class="p-4 mb-4 bg-white border-b border-gray-200 rounded-md">
                    <x-textarea label="{{ $question['question'] }}" tabindex="" wire:model.defer="create_form.questions.custom.{{ $slug }}" :hint="$question['description']"/>
                    <x-jet-input-error for="questions.custom.{{ $slug }}" class="mt-2" />
                </div>
            @endforeach

            @if($event)
                <div class="pt-5">
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex justify-center px-4 py-2 ml-3 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Save') }}
                        </button>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>
