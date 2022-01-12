
<x-app-layout>

    @livewire('results-manager', [
        'event' => $event,
        'form' => $form,
        'team' => $team,
        'questions' => $questions,
        'sections' => $sections,
        'responses' => $responses,
        'progressMetricTotal' => $progressMetricTotal,
        'sectionTotals' => $sectionTotals,
        'totalSections' => $totalSections
    ])
</x-app-layout>
