
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
            <div class="mb-6 bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                <h3 class="px-6 py-4 text-xl font-bold text-gray-900 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">Business Model Confidence Scoring</h3>
                <div class="p-6 prose prose-sm max-w-none">
                    {!! config('questions.overall_description') !!}
                </div>
            </div>

            <div class="mb-6 bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                <h3 class="px-6 py-4 text-xl font-bold text-gray-900 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">Confidence Score Scale</h3>
                <div class="p-4">
                    <!-- Dynamic SVG Confidence Score Scale -->
                    <div class="w-full overflow-x-auto">
                        <svg viewBox="0 0 800 400" class="w-full h-auto min-w-[600px] max-w-4xl mx-auto">
                            <!-- Title -->
                            <text x="400" y="30" text-anchor="middle" class="text-2xl font-bold fill-blue-600">Confidence Score</text>
                            
                            <!-- Score numbers -->
                            <text x="50" y="80" text-anchor="middle" class="text-xl font-bold fill-blue-600">0</text>
                            <text x="175" y="80" text-anchor="middle" class="text-lg font-semibold fill-gray-700">1</text>
                            <text x="300" y="80" text-anchor="middle" class="text-lg font-semibold fill-gray-700">2</text>
                            <text x="425" y="80" text-anchor="middle" class="text-xl font-bold fill-blue-600">3</text>
                            <text x="550" y="80" text-anchor="middle" class="text-lg font-semibold fill-gray-700">4</text>
                            <text x="675" y="80" text-anchor="middle" class="text-xl font-bold fill-blue-600">5</text>
                            
                            <!-- Main scale line -->
                            <line x1="50" y1="100" x2="675" y2="100" stroke="#374151" stroke-width="3"/>
                            
                            <!-- Scale points -->
                            <circle cx="50" cy="100" r="8" fill="#374151"/>
                            <circle cx="175" cy="100" r="8" fill="#374151"/>
                            <circle cx="300" cy="100" r="8" fill="#374151"/>
                            <circle cx="425" cy="100" r="8" fill="#374151"/>
                            <circle cx="550" cy="100" r="8" fill="#374151"/>
                            <circle cx="675" cy="100" r="8" fill="#374151"/>
                            
                            <!-- Vertical dashed lines -->
                            <line x1="50" y1="110" x2="50" y2="280" stroke="#d1d5db" stroke-width="1" stroke-dasharray="5,5"/>
                            <line x1="175" y1="110" x2="175" y2="280" stroke="#d1d5db" stroke-width="1" stroke-dasharray="5,5"/>
                            <line x1="300" y1="110" x2="300" y2="280" stroke="#d1d5db" stroke-width="1" stroke-dasharray="5,5"/>
                            <line x1="425" y1="110" x2="425" y2="280" stroke="#d1d5db" stroke-width="1" stroke-dasharray="5,5"/>
                            <line x1="550" y1="110" x2="550" y2="280" stroke="#d1d5db" stroke-width="1" stroke-dasharray="5,5"/>
                            <line x1="675" y1="110" x2="675" y2="280" stroke="#d1d5db" stroke-width="1" stroke-dasharray="5,5"/>
                            
                            <!-- Description text boxes -->
                            <foreignObject x="10" y="120" width="80" height="160">
                                <div class="text-xs text-center text-gray-700 leading-tight">
                                    <div class="font-semibold mb-1">Not addressed yet;</div>
                                    <div>Not within scope of this evaluation</div>
                                </div>
                            </foreignObject>
                            
                            <foreignObject x="135" y="120" width="80" height="160">
                                <div class="text-xs text-center text-gray-700 leading-tight">
                                    <div class="font-semibold mb-1">The team has</div>
                                    <div>provided little evidence, there is low confidence in the evidence</div>
                                </div>
                            </foreignObject>
                            
                            <foreignObject x="260" y="120" width="80" height="160">
                                <div class="text-xs text-center text-gray-700 leading-tight">
                                    <div class="font-semibold mb-1">The team has</div>
                                    <div>provided some evidence, there is medium to low confidence in the evidence</div>
                                </div>
                            </foreignObject>
                            
                            <foreignObject x="385" y="120" width="80" height="160">
                                <div class="text-xs text-center text-gray-700 leading-tight">
                                    <div class="font-semibold mb-1">The team has</div>
                                    <div>provided partial evidence not adequate to make a decision; neutral/moderate confidence</div>
                                </div>
                            </foreignObject>
                            
                            <foreignObject x="510" y="120" width="80" height="160">
                                <div class="text-xs text-center text-gray-700 leading-tight">
                                    <div class="font-semibold mb-1">The team has</div>
                                    <div>provided evidence to make a premature decision, there is medium to medium high confidence in the evidence</div>
                                </div>
                            </foreignObject>
                            
                            <foreignObject x="635" y="120" width="80" height="160">
                                <div class="text-xs text-center text-gray-700 leading-tight">
                                    <div class="font-semibold mb-1">The team has</div>
                                    <div>provided adequate evidence to make a decision, there is high confidence in the evidence</div>
                                </div>
                            </foreignObject>
                            
                            <!-- Confidence level labels -->
                            <rect x="10" y="290" width="80" height="25" fill="#9ca3af" rx="3"/>
                            <text x="50" y="307" text-anchor="middle" class="text-xs font-semibold fill-white">Not Addressed</text>
                            
                            <rect x="135" y="290" width="80" height="25" fill="#ef4444" rx="3"/>
                            <text x="175" y="307" text-anchor="middle" class="text-xs font-semibold fill-white">No Confidence</text>
                            
                            <rect x="260" y="290" width="80" height="25" fill="#f97316" rx="3"/>
                            <text x="300" y="307" text-anchor="middle" class="text-xs font-semibold fill-white">Low Confidence</text>
                            
                            <rect x="385" y="290" width="80" height="25" fill="#eab308" rx="3"/>
                            <text x="425" y="307" text-anchor="middle" class="text-xs font-semibold fill-black">Moderate Confidence</text>
                            
                            <rect x="510" y="290" width="80" height="25" fill="#84cc16" rx="3"/>
                            <text x="550" y="307" text-anchor="middle" class="text-xs font-semibold fill-black">Reasonable Confidence</text>
                            
                            <rect x="635" y="290" width="80" height="25" fill="#22c55e" rx="3"/>
                            <text x="675" y="307" text-anchor="middle" class="text-xs font-semibold fill-white">High Confidence</text>
                            
                            <!-- Risk gradient bar -->
                            <defs>
                                <linearGradient id="riskGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" style="stop-color:#ef4444;stop-opacity:1" />
                                    <stop offset="16.67%" style="stop-color:#f97316;stop-opacity:1" />
                                    <stop offset="33.33%" style="stop-color:#eab308;stop-opacity:1" />
                                    <stop offset="50%" style="stop-color:#84cc16;stop-opacity:1" />
                                    <stop offset="66.67%" style="stop-color:#22c55e;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#16a34a;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                            <rect x="10" y="330" width="705" height="20" fill="url(#riskGradient)" rx="3"/>
                            
                            <!-- Risk labels -->
                            <text x="200" y="365" text-anchor="middle" class="text-sm font-bold fill-gray-700">High Risk</text>
                            <text x="400" y="365" text-anchor="middle" class="text-sm font-bold fill-gray-700">Mitigated Risk</text>
                            <text x="600" y="365" text-anchor="middle" class="text-sm font-bold fill-gray-700">Low Risk</text>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="mb-6 bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                <h3 class="px-6 py-4 text-lg font-semibold text-gray-900 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">Email Address</h3>
                <div class="p-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Please enter your email address
                    </label>
                    <input id="email" type="email" wire:model.defer="create_form.email" 
                           class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 placeholder-gray-500" 
                           placeholder="your.email@example.com">
                    <x-jet-input-error for="email" class="mt-2" />
                </div>
            </div>

            @if($event && $event->teams->count() > 1)
                <div class="mb-6 bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                    <h3 class="px-6 py-4 text-lg font-semibold text-gray-900 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">Select Team</h3>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($event->teams->all() as $team)
                                <div class="flex items-center">
                                    <input type="radio" id="team-{{ $team['id'] }}" name="team" wire:model.defer="create_form.team" value="{{ $team['id'] }}" 
                                           class="w-5 h-5 text-blue-600 border-2 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer transition-all duration-200">
                                    <label for="team-{{ $team['id'] }}" class="ml-3 text-sm font-medium text-gray-700 cursor-pointer">{{ $team['name'] }}</label>
                                </div>
                            @endforeach
                        </div>
                        <x-jet-input-error for="team" class="mt-4" />
                    </div>
                </div>
            @endif

            @foreach(config('questions.business-model') as $question)
                @php
                    $slug = Str::slug($question['question'])
                @endphp
                <div class="mb-6 bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $question['question'] }}</h3>
                        <p class="mt-2 text-sm text-gray-600">{{ $question['description'] }}</p>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0 sm:space-x-4">
                            <div class="flex-shrink-0 text-xs font-medium text-gray-500 text-center sm:text-left">
                                Not Applicable<br>(N/A)
                            </div>
                            
                            <div class="flex flex-wrap justify-center gap-4 sm:gap-6">
                                <div class="flex flex-col items-center space-y-2">
                                    <label for="score-[{{ $slug }}]-0" class="text-sm font-semibold text-blue-600 cursor-pointer">0</label>
                                    <input type="radio" id="score-[{{ $slug }}]-0" wire:model.defer="create_form.questions.{{ $slug }}" value="0" 
                                           class="w-5 h-5 text-blue-600 border-2 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer transition-all duration-200" />
                                </div>
                                <div class="flex flex-col items-center space-y-2">
                                    <label for="score-[{{ $slug }}]-1" class="text-sm font-medium text-gray-700 cursor-pointer">1</label>
                                    <input type="radio" id="score-[{{ $slug }}]-1" wire:model.defer="create_form.questions.{{ $slug }}" value="1" 
                                           class="w-5 h-5 text-blue-600 border-2 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer transition-all duration-200" />
                                </div>
                                <div class="flex flex-col items-center space-y-2">
                                    <label for="score-[{{ $slug }}]-2" class="text-sm font-medium text-gray-700 cursor-pointer">2</label>
                                    <input type="radio" id="score-[{{ $slug }}]-2" wire:model.defer="create_form.questions.{{ $slug }}" value="2" 
                                           class="w-5 h-5 text-blue-600 border-2 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer transition-all duration-200" />
                                </div>
                                <div class="flex flex-col items-center space-y-2">
                                    <label for="score-[{{ $slug }}]-3" class="text-sm font-semibold text-blue-600 cursor-pointer">3</label>
                                    <input type="radio" id="score-[{{ $slug }}]-3" wire:model.defer="create_form.questions.{{ $slug }}" value="3" 
                                           class="w-5 h-5 text-blue-600 border-2 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer transition-all duration-200" />
                                </div>
                                <div class="flex flex-col items-center space-y-2">
                                    <label for="score-[{{ $slug }}]-4" class="text-sm font-medium text-gray-700 cursor-pointer">4</label>
                                    <input type="radio" id="score-[{{ $slug }}]-4" wire:model.defer="create_form.questions.{{ $slug }}" value="4" 
                                           class="w-5 h-5 text-blue-600 border-2 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer transition-all duration-200" />
                                </div>
                                <div class="flex flex-col items-center space-y-2">
                                    <label for="score-[{{ $slug }}]-5" class="text-sm font-semibold text-blue-600 cursor-pointer">5</label>
                                    <input type="radio" id="score-[{{ $slug }}]-5" wire:model.defer="create_form.questions.{{ $slug }}" value="5" 
                                           class="w-5 h-5 text-blue-600 border-2 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer transition-all duration-200" />
                                </div>
                            </div>
                            
                            <div class="flex-shrink-0 text-xs font-medium text-gray-500 text-center sm:text-right">
                                High<br>Confidence
                            </div>
                        </div>
                        <x-jet-input-error for="questions.{{ $slug }}" class="mt-4" />
                    </div>
                </div>
            @endforeach

            @foreach(config('questions.qualitative-intuitive-scoring') as $question)
                @php
                    $slug = Str::slug($question['question'])
                @endphp
                <div class="mb-6 bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $question['question'] }}</h3>
                        <p class="mt-2 text-sm text-gray-600">{{ $question['description'] }}</p>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0 sm:space-x-4">
                            <div class="flex-shrink-0 text-xs font-medium text-gray-500 text-center sm:text-left">
                                Not Applicable<br>(N/A)
                            </div>
                            
                            <div class="flex flex-wrap justify-center gap-4 sm:gap-6">
                                <div class="flex flex-col items-center space-y-2">
                                    <label for="score-[{{ $slug }}]-1" class="text-sm font-medium text-gray-700 cursor-pointer">1</label>
                                    <input type="radio" id="score-[{{ $slug }}]-1" wire:model.defer="create_form.questions.{{ $slug }}" value="1" 
                                           class="w-5 h-5 text-blue-600 border-2 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer transition-all duration-200" />
                                </div>
                                <div class="flex flex-col items-center space-y-2">
                                    <label for="score-[{{ $slug }}]-2" class="text-sm font-medium text-gray-700 cursor-pointer">2</label>
                                    <input type="radio" id="score-[{{ $slug }}]-2" wire:model.defer="create_form.questions.{{ $slug }}" value="2" 
                                           class="w-5 h-5 text-blue-600 border-2 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer transition-all duration-200" />
                                </div>
                                <div class="flex flex-col items-center space-y-2">
                                    <label for="score-[{{ $slug }}]-3" class="text-sm font-semibold text-blue-600 cursor-pointer">3</label>
                                    <input type="radio" id="score-[{{ $slug }}]-3" wire:model.defer="create_form.questions.{{ $slug }}" value="3" 
                                           class="w-5 h-5 text-blue-600 border-2 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer transition-all duration-200" />
                                </div>
                                <div class="flex flex-col items-center space-y-2">
                                    <label for="score-[{{ $slug }}]-4" class="text-sm font-medium text-gray-700 cursor-pointer">4</label>
                                    <input type="radio" id="score-[{{ $slug }}]-4" wire:model.defer="create_form.questions.{{ $slug }}" value="4" 
                                           class="w-5 h-5 text-blue-600 border-2 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer transition-all duration-200" />
                                </div>
                                <div class="flex flex-col items-center space-y-2">
                                    <label for="score-[{{ $slug }}]-5" class="text-sm font-semibold text-blue-600 cursor-pointer">5</label>
                                    <input type="radio" id="score-[{{ $slug }}]-5" wire:model.defer="create_form.questions.{{ $slug }}" value="5" 
                                           class="w-5 h-5 text-blue-600 border-2 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer transition-all duration-200" />
                                </div>
                            </div>
                            
                            <div class="flex-shrink-0 text-xs font-medium text-gray-500 text-center sm:text-right">
                                High<br>Confidence
                            </div>
                        </div>
                        <x-jet-input-error for="questions.{{ $slug }}" class="mt-4" />
                    </div>
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
                <div class="mb-6 bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $question['question'] }}</h3>
                        @if($question['description'])
                            <p class="mt-2 text-sm text-gray-600">{{ $question['description'] }}</p>
                        @endif
                    </div>
                    <div class="p-6">
                        <textarea wire:model.defer="create_form.questions.custom.{{ $slug }}" rows="4" 
                                  class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 placeholder-gray-500 resize-vertical" 
                                  placeholder="Please provide your detailed response here..."></textarea>
                        <x-jet-input-error for="questions.custom.{{ $slug }}" class="mt-2" />
                    </div>
                </div>
            @endforeach

            @if($event)
                <div class="pt-8 pb-6">
                    <div class="flex justify-center">
                        <button type="submit" class="inline-flex items-center px-8 py-4 text-base font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-lg shadow-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform transition-all duration-200 hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ __('Submit Assessment') }}
                        </button>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>
