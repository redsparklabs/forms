<?php

use App\Models\Team;
use Illuminate\Support\Str;

if (!function_exists('colorize')) {
    /**
     * Colorize
     *
     * @param integer $number
     *
     * @return string|null
     */
    function colorize(int $number): ?string
    {

        if (inbetween($number, 0, 1)) {
            return 'karban-green-2';
        }

        if (inbetween($number, 1.1, 2)) {
            return 'karban-green-3';
        }

        if (inbetween($number, 2.1, 3)) {
            return 'karban-green-4';
        }

        if (inbetween($number, 3.1, 4)) {
            return 'karban-green-5';
        }

        if (inbetween($number, 4.1, 5)) {
            return 'karban-green-6';
        }

        return null;
    }
}

if (!function_exists('inbetween')) {
    /**
     * Check if a number is between two other numbers
     *
     * @param integer $val
     * @param integer $min
     * @param float $max
     *
     * @return bool
     */
    function inbetween(int $val, int $min, float $max): bool
    {
        return ($val >= $min && $val <= $max);
    }
}

if (!function_exists('calculateSections')) {
    /**
     * Calculate the sections for a form
     *
     * @param $event
     * @param Team $team
     *
     * @return array
     */
    function calculateSections($event, Team $team): array
    {

        $responses = $event->responses()->where('team_id', $team->id)->get();

        $progressMetricTotal = 0;

        $questions = $event->latestForm()->allQuestions();
        $allSections = collect($questions)->groupBy('section')->reject(fn ($item, $key) => $key == 'custom');
        $sectionCount = $allSections->keys()->mapWithkeys(fn ($item) => [$item . '_count' => 0])->all();
        $totalSections = $allSections->reject(fn ($item, $key) => $key == 'Intutive_Scoring')->flatten(1)->count();


        foreach ($responses as $response) {
            $total = 0;
            foreach ($allSections->reject(fn ($item, $key) => $key == 'Intutive_Scoring')->all() as $sectionData) {

                $sectionQuestions = $sectionData->pluck('question')->map(fn ($item) => Str::slug($item))->toArray();

                $total += collect($response->questions)->filter(function ($item, $key) use ($sectionQuestions) {
                    return in_array($key, $sectionQuestions);
                })->sum();
            }

            $progressMetricTotal = number_format(($total / $totalSections), 1);

            foreach ($allSections->all() as $section => $sectionData) {
                $sectionQuestions = $sectionData->pluck('question')->map(fn ($item) => Str::slug($item))->toArray();
                $sectionTotal = collect($response->questions)->filter(function ($item, $key) use ($sectionQuestions) {
                    return in_array($key, $sectionQuestions);
                })->sum();

                $sectionCount[$section . '_count'] .= number_format($sectionTotal / $allSections->count(), 1);
            }
        }

        return [
            'responses' => $responses,
            'questions' => $questions,
            'allSections' => $allSections,
            'sectionCount' => $sectionCount,
            'progressMetricTotal' => $progressMetricTotal,
        ];
    }
}
