<div class="mb-5">
    <header class="bg-gradient-to-r from-green-600 to-emerald-600 shadow-lg">
        <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="h-12 w-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h6a2 2 0 002-2V9a2 2 0 00-2-2h-2m0 0V3a2 2 0 10-4 0v2m4 0a2 2 0 104 0v2m-6 4h2m2 0h2"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $event->name }}</h1>
                        <p class="text-green-100 text-sm mt-1">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 112 0v1m-2 0h4m-4 0a2 2 0 00-2 2v10a2 2 0 002 2h4a2 2 0 002-2V9a2 2 0 00-2-2m-4 0V8a2 2 0 012-2h4a2 2 0 012 2v1"></path>
                            </svg>
                            Assessment scheduled for {{ $event->date?->format('F j, Y') }}
                        </p>
                    </div>
                </div>
                @can('update', $event)
                    <button wire:click="confirmUpdate('{{ $event->id }}')" class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 border border-white border-opacity-30 rounded-lg text-sm font-medium text-white hover:bg-opacity-30 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        {{ __('Update Assessment') }}
                    </button>
                @endcan
            </div>
        </div>
    </header>

    <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- QR Code Section for Mobile Access -->
        <div class="mb-8 bg-white shadow-lg border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-6 py-5 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="h-10 w-10 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Mobile Assessment Access</h3>
                        <p class="mt-1 text-sm text-gray-600">Scan the QR code below to access the assessment form on mobile devices</p>
                    </div>
                </div>
            </div>
            <div class="p-8">
                <div class="flex flex-col lg:flex-row items-center lg:items-start space-y-8 lg:space-y-0 lg:space-x-12">
                    <!-- QR Code -->
                    <div class="flex-shrink-0">
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-6 rounded-2xl border-2 border-gray-200 shadow-lg">
                            <canvas id="qr-code" class="w-48 h-48 bg-white rounded-xl shadow-inner"></canvas>
                        </div>
                        <p class="text-sm text-gray-600 text-center mt-3 font-medium">QR Code for Assessment Form</p>
                    </div>
                    
                    <!-- Instructions -->
                    <div class="flex-1 space-y-6">
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                How to Use:
                            </h4>
                            <div class="space-y-3">
                                <div class="flex items-start space-x-3">
                                    <span class="flex-shrink-0 w-6 h-6 bg-green-100 text-green-800 rounded-full flex items-center justify-center text-sm font-bold">1</span>
                                    <p class="text-gray-700">Open your phone or tablet camera</p>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <span class="flex-shrink-0 w-6 h-6 bg-green-100 text-green-800 rounded-full flex items-center justify-center text-sm font-bold">2</span>
                                    <p class="text-gray-700">Point the camera at the QR code</p>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <span class="flex-shrink-0 w-6 h-6 bg-green-100 text-green-800 rounded-full flex items-center justify-center text-sm font-bold">3</span>
                                    <p class="text-gray-700">Tap the notification that appears to open the assessment form</p>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <span class="flex-shrink-0 w-6 h-6 bg-green-100 text-green-800 rounded-full flex items-center justify-center text-sm font-bold">4</span>
                                    <p class="text-gray-700">Complete the assessment directly on your mobile device</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-5">
                            <div class="flex items-start">
                                <div class="h-8 w-8 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="text-base font-bold text-green-900">Assessment Tips</h5>
                                    <p class="text-sm text-green-800 mt-2 leading-relaxed">The form is optimized for mobile devices with touch-friendly sliders and responsive design. Assessors can complete evaluations efficiently on any device.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Alternative Access -->
                        <div class="border-t border-gray-200 pt-6">
                            <h5 class="text-base font-bold text-gray-900 mb-3 flex items-center">
                                <svg class="w-4 h-4 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                                Alternative Access:
                            </h5>
                            <div class="flex items-center space-x-3">
                                <input type="text" readonly value="{{ route('form-builder', $event->slug) }}" 
                                       id="assessment-url"
                                       class="flex-1 text-sm bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 text-gray-700 font-mono">
                                <button onclick="copyAssessmentUrl()" 
                                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 shadow-md">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    Copy Link
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-5 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="h-10 w-10 bg-gradient-to-r from-gray-600 to-gray-700 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Project Portfolio</h2>
                            <p class="text-sm text-gray-600 mt-1">All projects participating in this assessment</p>
                        </div>
                    </div>
                    <div class="w-64">
                        <x-jet-input id="keywords" type="text" class="block w-full" wire:model="keyword" :placeholder="__('Search projects...')"/>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900" wire:click="sortBy('name')">
                                {{ __('Project Name') }}
                                @if($teams->count() > 1)
                                    <x-sort :dir="$sortDirection" :active="$sortByField == 'name'"/>
                                @endif
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                {{ __('Progress Score') }}
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer hover:text-gray-900" wire:click="sortBy('priority_level')">
                                {{ __('Priority Level') }}
                                @if($teams->count() > 1)
                                    <x-sort :dir="$sortDirection" :active="$sortByField == 'priority_level'"/>
                                @endif
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($teams as $team)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center">
                                                <span class="text-sm font-semibold text-green-700">{{ substr($team->name, 0, 2) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <a class="text-green-600 hover:text-green-800 font-semibold" href="{{ route('teams.show', $team->id) }}">{{ $team->name }}</a>
                                            </div>
                                            <div class="text-sm text-gray-500">Active Project</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 mr-3">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-sm font-bold text-white bg-gradient-to-r from-green-500 to-emerald-500">
                                                {{ $team->events()->find($event->id)->progressMetric($team) }}
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="w-16 bg-gray-200 rounded-full h-2">
                                                <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-2 rounded-full" style="width: {{ min(100, ($team->events()->find($event->id)->progressMetric($team) / 5) * 100) }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $team->priority_level }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($team->events()->find($event->id)->progressMetric($team) > 0)
                                        <a href="{{ route('events.results', [$event->id, $team->id]) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 border border-transparent rounded-lg text-sm font-medium text-white hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 shadow-md">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                            View Results
                                        </a>
                                    @else
                                        <span class="inline-flex items-center px-4 py-2 bg-yellow-100 border border-yellow-200 rounded-lg text-sm font-medium text-yellow-800">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Awaiting Results
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        @if(!$keyword)
                                            <svg class="h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No projects yet') }}</h3>
                                            <p class="text-gray-500 mb-4">{{ __('Get started by adding projects to this assessment.') }}</p>
                                            <a href="{{ route('teams.index', 'create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                {{ __('Add Project') }}
                                            </a>
                                        @else
                                            <svg class="h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No projects found') }}</h3>
                                            <p class="text-gray-500">{{ __('Try adjusting your search criteria.') }}</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($teams->hasPages())
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        {{ $teams->links() }}
                    </div>
                @endif
            </div>
        </div>
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

<!-- QR Code Generation Script -->
<script>
    // Use Google Charts API as fallback - no external library needed
    document.addEventListener('DOMContentLoaded', function() {
        const qrCodeContainer = document.getElementById('qr-code');
        const assessmentUrl = '{{ route("form-builder", $event->slug) }}';
        
        console.log('Generating QR code for URL:', assessmentUrl);
        
        // Create QR code using Google Charts API
        const qrSize = 192;
        const qrApiUrl = `https://api.qrserver.com/v1/create-qr-code/?size=${qrSize}x${qrSize}&data=${encodeURIComponent(assessmentUrl)}&color=374151&bgcolor=FFFFFF&margin=10`;
        
        // Replace canvas with img element
        const qrImage = document.createElement('img');
        qrImage.src = qrApiUrl;
        qrImage.className = 'w-48 h-48 rounded';
        qrImage.alt = 'QR Code for Assessment Form';
        
        qrImage.onload = function() {
            console.log('QR Code loaded successfully');
        };
        
        qrImage.onerror = function() {
            console.error('QR Code loading failed');
            // Create fallback div
            const fallbackDiv = document.createElement('div');
            fallbackDiv.className = 'w-48 h-48 flex items-center justify-center bg-yellow-50 text-yellow-700 text-sm text-center rounded border-2 border-yellow-200';
            fallbackDiv.innerHTML = 'QR Code unavailable<br>Please use the link below';
            qrCodeContainer.parentNode.replaceChild(fallbackDiv, qrCodeContainer);
            return;
        };
        
        // Replace the canvas with the image
        qrCodeContainer.parentNode.replaceChild(qrImage, qrCodeContainer);
    });

    // Copy URL function
    function copyAssessmentUrl() {
        const urlInput = document.getElementById('assessment-url');
        urlInput.select();
        urlInput.setSelectionRange(0, 99999); // For mobile devices
        
        try {
            document.execCommand('copy');
            // Visual feedback
            const button = event.target;
            const originalText = button.textContent;
            button.textContent = 'Copied!';
            button.classList.add('bg-green-700');
            
            setTimeout(() => {
                button.textContent = originalText;
                button.classList.remove('bg-green-700');
            }, 2000);
        } catch (err) {
            console.error('Copy failed:', err);
            // Fallback: select the text for manual copy
            urlInput.focus();
            urlInput.select();
        }
    }
</script>

