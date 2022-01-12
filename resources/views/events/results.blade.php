
<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Results &middot; {{ $event->name }} &middot; {{ $form->name }} &middot; @if($team) {{ $team->name }} @endif
        </h2>
    </x-slot>

    @livewire('results-manager', [
        'event' => $event,
        'form' => $form,
        'team' => $team,
        'questions' => $questions,
        'sections' => $sections,
        'responses' => $responses,
        'progressMetricTotal' => $progressMetricTotal,
        'sectionTotals' => $sectionTotals,
        'totalSections => $totalSections'
    ])
</x-app-layout>
