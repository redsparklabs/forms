
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
                <h3 class="px-6 py-4 text-xl font-bold text-gray-900 bg-gray-50 border-b border-gray-200">Evaluate Business Model Readiness Using Evidence-Based Scoring</h3>
                <div class="p-6 prose prose-sm max-w-none">
                    <p class="mb-4">Rate each business model component based on the strength of supporting evidence available for investment decisions.</p>
                    
                    <h4 class="text-lg font-semibold text-gray-900 mb-3">Why Early-Stage Evidence Evaluation Matters</h4>
                    <p class="mb-4">Traditional ROI metrics often fail in early-stage innovation because they rely on historical data and established market patterns. Growth boards require a different approach—one that balances speed-to-market with evidence-based decision making. This assessment helps leadership teams:</p>
                    
                    <ul class="mb-4 space-y-2">
                        <li><strong>Avoid the "build it and they will come" trap</strong> by validating assumptions before major resource commitments</li>
                        <li><strong>Make informed go/no-go decisions</strong> at critical funding gates without waiting for complete market data</li>
                        <li><strong>Allocate resources strategically</strong> across a portfolio of initiatives based on evidence strength</li>
                        <li><strong>Reduce innovation risk</strong> while maintaining competitive speed and agility</li>
                    </ul>
                    
                    <h4 class="text-lg font-semibold text-gray-900 mb-3">Growth Board Responsibilities</h4>
                    <p class="mb-4">As stewards of innovation investment, growth boards must evaluate opportunities using forward-looking indicators rather than backward-looking financial metrics. This evidence-based scoring enables boards to:</p>
                    
                    <ul class="mb-4 space-y-2">
                        <li><strong>Prioritize initiatives</strong> with the strongest validation relative to their stage of development</li>
                        <li><strong>Identify knowledge gaps</strong> that require additional investment before scaling</li>
                        <li><strong>Balance portfolio risk</strong> by mixing high-confidence opportunities with strategic bets</li>
                        <li><strong>Establish clear evidence thresholds</strong> for advancing projects through funding stages</li>
                    </ul>
                    
                    <h4 class="text-lg font-semibold text-gray-900 mb-3">Evidence Quality Framework</h4>
                    <p class="mb-2">Evaluate evidence strength across these business-critical dimensions:</p>
                    <ul class="space-y-2">
                        <li><strong>Market Research vs. Customer Behavior:</strong> Survey data vs. actual purchasing patterns</li>
                        <li><strong>Controlled Testing vs. Market Reality:</strong> Lab/pilot results vs. real-world performance</li>
                        <li><strong>Assumptions vs. Validated Data:</strong> Expert opinions vs. measurable business metrics</li>
                        <li><strong>Concept Testing vs. Market-Ready Solution:</strong> Early prototypes vs. production-ready offerings</li>
                    </ul>
                </div>
            </div>

            <div class="mb-6 bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                <h3 class="px-6 py-4 text-xl font-bold text-gray-900 bg-gray-50 border-b border-gray-200">Confidence Score Scale</h3>
                <div class="p-4">
                    <!-- Dynamic SVG Confidence Score Scale -->
                    <div class="w-full flex justify-center">
                        <svg viewBox="0 0 1000 400" class="w-full h-auto max-w-6xl">
                            <!-- Title -->
                            <text x="500" y="30" text-anchor="middle" class="text-2xl font-bold fill-blue-600">Confidence Score</text>
                            
                            <!-- Score numbers -->
                            <text x="83" y="80" text-anchor="middle" class="text-xl font-bold fill-blue-600">0</text>
                            <text x="233" y="80" text-anchor="middle" class="text-lg font-semibold fill-gray-700">1</text>
                            <text x="383" y="80" text-anchor="middle" class="text-lg font-semibold fill-gray-700">2</text>
                            <text x="533" y="80" text-anchor="middle" class="text-xl font-bold fill-blue-600">3</text>
                            <text x="683" y="80" text-anchor="middle" class="text-lg font-semibold fill-gray-700">4</text>
                            <text x="833" y="80" text-anchor="middle" class="text-xl font-bold fill-blue-600">5</text>
                            
                            <!-- Main scale line -->
                            <line x1="83" y1="100" x2="833" y2="100" stroke="#374151" stroke-width="3"/>
                            
                            <!-- Scale points -->
                            <circle cx="83" cy="100" r="8" fill="#374151"/>
                            <circle cx="233" cy="100" r="8" fill="#374151"/>
                            <circle cx="383" cy="100" r="8" fill="#374151"/>
                            <circle cx="533" cy="100" r="8" fill="#374151"/>
                            <circle cx="683" cy="100" r="8" fill="#374151"/>
                            <circle cx="833" cy="100" r="8" fill="#374151"/>
                            
                            <!-- Vertical dashed lines -->
                            <line x1="83" y1="110" x2="83" y2="280" stroke="#d1d5db" stroke-width="1" stroke-dasharray="5,5"/>
                            <line x1="233" y1="110" x2="233" y2="280" stroke="#d1d5db" stroke-width="1" stroke-dasharray="5,5"/>
                            <line x1="383" y1="110" x2="383" y2="280" stroke="#d1d5db" stroke-width="1" stroke-dasharray="5,5"/>
                            <line x1="533" y1="110" x2="533" y2="280" stroke="#d1d5db" stroke-width="1" stroke-dasharray="5,5"/>
                            <line x1="683" y1="110" x2="683" y2="280" stroke="#d1d5db" stroke-width="1" stroke-dasharray="5,5"/>
                            <line x1="833" y1="110" x2="833" y2="280" stroke="#d1d5db" stroke-width="1" stroke-dasharray="5,5"/>
                            
                            <!-- Description text boxes -->
                            <foreignObject x="33" y="120" width="100" height="160">
                                <div class="text-xs text-center text-gray-700 leading-tight">
                                    <div class="font-semibold mb-1">Not addressed yet;</div>
                                    <div>Not within scope of this evaluation</div>
                                </div>
                            </foreignObject>
                            
                            <foreignObject x="183" y="120" width="100" height="160">
                                <div class="text-xs text-center text-gray-700 leading-tight">
                                    <div class="font-semibold mb-1">The team has</div>
                                    <div>provided little evidence, there is low confidence in the evidence</div>
                                </div>
                            </foreignObject>
                            
                            <foreignObject x="333" y="120" width="100" height="160">
                                <div class="text-xs text-center text-gray-700 leading-tight">
                                    <div class="font-semibold mb-1">The team has</div>
                                    <div>provided some evidence, there is medium to low confidence in the evidence</div>
                                </div>
                            </foreignObject>
                            
                            <foreignObject x="483" y="120" width="100" height="160">
                                <div class="text-xs text-center text-gray-700 leading-tight">
                                    <div class="font-semibold mb-1">The team has</div>
                                    <div>provided partial evidence not adequate to make a decision; neutral/moderate confidence</div>
                                </div>
                            </foreignObject>
                            
                            <foreignObject x="633" y="120" width="100" height="160">
                                <div class="text-xs text-center text-gray-700 leading-tight">
                                    <div class="font-semibold mb-1">The team has</div>
                                    <div>provided evidence to make a premature decision, there is medium to medium high confidence in the evidence</div>
                                </div>
                            </foreignObject>
                            
                            <foreignObject x="783" y="120" width="100" height="160">
                                <div class="text-xs text-center text-gray-700 leading-tight">
                                    <div class="font-semibold mb-1">The team has</div>
                                    <div>provided adequate evidence to make a decision, there is high confidence in the evidence</div>
                                </div>
                            </foreignObject>
                            
                            <!-- Confidence level labels - seamless bars -->
                            <rect x="33" y="290" width="150" height="25" fill="#9ca3af"/>
                            <text x="108" y="307" text-anchor="middle" class="text-xs font-semibold fill-white">Not Addressed</text>
                            
                            <rect x="183" y="290" width="150" height="25" fill="#ef4444"/>
                            <text x="258" y="307" text-anchor="middle" class="text-xs font-semibold fill-white">No Confidence</text>
                            
                            <rect x="333" y="290" width="150" height="25" fill="#f97316"/>
                            <text x="408" y="307" text-anchor="middle" class="text-xs font-semibold fill-white">Low Confidence</text>
                            
                            <rect x="483" y="290" width="150" height="25" fill="#eab308"/>
                            <text x="558" y="307" text-anchor="middle" class="text-xs font-semibold fill-black">Moderate Confidence</text>
                            
                            <rect x="633" y="290" width="150" height="25" fill="#84cc16"/>
                            <text x="708" y="307" text-anchor="middle" class="text-xs font-semibold fill-black">Reasonable Confidence</text>
                            
                            <rect x="783" y="290" width="150" height="25" fill="#22c55e"/>
                            <text x="858" y="307" text-anchor="middle" class="text-xs font-semibold fill-white">High Confidence</text>
                            
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
                            <rect x="183" y="330" width="650" height="15" fill="url(#riskGradient)" rx="7"/>
                            
                            <!-- Risk labels -->
                            <text x="280" y="360" text-anchor="middle" class="text-sm font-semibold fill-red-600">High Risk</text>
                            <text x="508" y="360" text-anchor="middle" class="text-sm font-semibold fill-yellow-600">Mitigated Risk</text>
                            <text x="736" y="360" text-anchor="middle" class="text-sm font-semibold fill-green-600">Low Risk</text>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="mb-6 bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                <h3 class="px-6 py-4 text-lg font-semibold text-gray-900 bg-gray-50 border-b border-gray-200">Email Address</h3>
                <div class="p-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Please enter your email address
                    </label>
                    <input id="email" type="email" wire:model.defer="create_form.email" 
                           class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 placeholder-gray-500" 
                           placeholder="your.email@example.com">
                    <x-jet-input-error for="email" bag="addFormSubmission" class="mt-2" />
                </div>
            </div>

            @if($event && $event->teams->count() > 1)
                <div class="mb-6 bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                    <h3 class="px-6 py-4 text-lg font-semibold text-gray-900 bg-gray-50 border-b border-gray-200">Select Team</h3>
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
                        <x-jet-input-error for="team" bag="addFormSubmission" class="mt-4" />
                    </div>
                </div>
            @endif

            @foreach(config('questions.business-model') as $question)
                @php
                    $slug = Str::slug($question['question'])
                @endphp
                <div class="mb-6 bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $question['question'] }}</h3>
                        <p class="mt-2 text-sm text-gray-600">{{ $question['description'] }}</p>
                    </div>
                    <div class="p-6" x-data="{ sliderValue: 0 }">
                        <div class="space-y-4">
                            <!-- Slider with labels -->
                            <div class="flex items-center justify-between text-xs font-medium text-gray-500 px-2">
                                <span>Not Addressed</span>
                                <span>High Confidence</span>
                            </div>
                            
                            <!-- Slider container -->
                            <div class="relative">
                                <input type="range" 
                                       id="slider-{{ $slug }}" 
                                       min="0" 
                                       max="5" 
                                       step="1"
                                       x-model="sliderValue"
                                       wire:model.defer="create_form.questions.{{ $slug }}"
                                       class="w-full h-3 bg-gradient-to-r from-red-500 via-orange-500 via-yellow-500 via-lime-500 to-green-500 rounded-lg appearance-none cursor-pointer slider-thumb">
                                
                                <!-- Slider value labels -->
                                <div class="flex justify-between items-center mt-2 px-1">
                                    <span class="text-sm font-semibold text-blue-600">0</span>
                                    <span class="text-sm font-medium text-gray-700">1</span>
                                    <span class="text-sm font-medium text-gray-700">2</span>
                                    <span class="text-sm font-semibold text-blue-600">3</span>
                                    <span class="text-sm font-medium text-gray-700">4</span>
                                    <span class="text-sm font-semibold text-blue-600">5</span>
                                </div>
                                
                                <!-- Current value display -->
                                <div class="mt-3 text-center">
                                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                                        Current Score: <span x-text="sliderValue"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <style>
                            .slider-thumb::-webkit-slider-thumb {
                                appearance: none;
                                height: 24px;
                                width: 24px;
                                border-radius: 50%;
                                background: #3b82f6;
                                border: 2px solid #ffffff;
                                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
                                cursor: pointer;
                            }
                            
                            .slider-thumb::-moz-range-thumb {
                                height: 24px;
                                width: 24px;
                                border-radius: 50%;
                                background: #3b82f6;
                                border: 2px solid #ffffff;
                                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
                                cursor: pointer;
                                border: none;
                            }
                        </style>
                        <x-jet-input-error for="questions.{{ $slug }}" bag="addFormSubmission" class="mt-4" />
                    </div>
                </div>
            @endforeach

            @foreach(config('questions.qualitative-intuitive-scoring') as $question)
                @php
                    $slug = Str::slug($question['question'])
                @endphp
                <div class="mb-6 bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $question['question'] }}</h3>
                        <p class="mt-2 text-sm text-gray-600">{{ $question['description'] }}</p>
                    </div>
                    <div class="p-6" x-data="{ sliderValue: 1 }">
                        <div class="space-y-4">
                            <!-- Slider with labels -->
                            <div class="flex items-center justify-between text-xs font-medium text-gray-500 px-2">
                                <span>Low Confidence</span>
                                <span>High Confidence</span>
                            </div>
                            
                            <!-- Slider container -->
                            <div class="relative">
                                <input type="range" 
                                       id="slider-{{ $slug }}" 
                                       min="1" 
                                       max="5" 
                                       step="1"
                                       x-model="sliderValue"
                                       wire:model.defer="create_form.questions.{{ $slug }}"
                                       class="w-full h-3 bg-gradient-to-r from-red-500 via-orange-500 via-yellow-500 via-lime-500 to-green-500 rounded-lg appearance-none cursor-pointer slider-thumb">
                                
                                <!-- Slider value labels -->
                                <div class="flex justify-between items-center mt-2 px-1">
                                    <span class="text-sm font-medium text-gray-700">1</span>
                                    <span class="text-sm font-medium text-gray-700">2</span>
                                    <span class="text-sm font-semibold text-blue-600">3</span>
                                    <span class="text-sm font-medium text-gray-700">4</span>
                                    <span class="text-sm font-semibold text-blue-600">5</span>
                                </div>
                                
                                <!-- Current value display -->
                                <div class="mt-3 text-center">
                                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                                        Current Score: <span x-text="sliderValue"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <x-jet-input-error for="questions.{{ $slug }}" bag="addFormSubmission" class="mt-4" />
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
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $question['question'] }}</h3>
                        @if($question['description'])
                            <p class="mt-2 text-sm text-gray-600">{{ $question['description'] }}</p>
                        @endif
                    </div>
                    <div class="p-6">
                        <textarea wire:model.defer="create_form.questions.custom.{{ $slug }}" rows="4" 
                                  class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 placeholder-gray-500 resize-vertical" 
                                  placeholder="Please provide your detailed response here..."></textarea>
                        <x-jet-input-error for="questions.custom.{{ $slug }}" bag="addFormSubmission" class="mt-2" />
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
