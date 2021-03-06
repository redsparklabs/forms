<?php

use App\Models\Team;
use Illuminate\Support\Str;

function farey($v, $lim = 10) {
    // No error checking on args.  lim = maximum denominator.
    // Results are array(numerator, denominator); array(1, 0) is 'infinity'.
    if($v < 0) {
        list($n, $d) = farey(-$v, $lim);
        return array(-$n, $d);
    }
    $z = $lim - $lim;   // Get a "zero of the right type" for the denominator
    list($lower, $upper) = array(array($z, $z+1), array($z+1, $z));
    while(true) {
        $mediant = array(($lower[0] + $upper[0]), ($lower[1] + $upper[1]));
        if($v * $mediant[1] > $mediant[0]) {
            if($lim < $mediant[1])
                return $upper;
            $lower = $mediant;
        }
        else if($v * $mediant[1] == $mediant[0]) {
            if($lim >= $mediant[1])
                return $mediant;
            if($lower[1] < $upper[1])
                return $lower;
            return $upper;
        }
        else {
            if($lim < $mediant[1])
                return $lower;
            $upper = $mediant;
        }
    }
}

if (!function_exists('colorize')) {
    /**
     * Colorize
     *
     * @param float $number
     *
     * @return string|null
     */
    function colorize($number): ?string
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
     * @param float $val
     * @param float $min
     * @param float $max
     *
     * @return bool
     */
    function inbetween(float $val, float $min, float $max): bool
    {
        return ($val >= $min && $val <= $max);
    }
}

    /**
     * Grab the current stage
     * @param float $metric
     * @return object|null
     */
    function stage(float $metric)
    {
        foreach(config('stages') as $stage) {
            if($metric >= $stage['start_scale'] && $metric <= $stage['end_scale']) {
                return (object) $stage;
            }
        }
    }

if (!function_exists('calculateSections')) {
    /**
     * Calculate the sections for a form
     *
     * @param Event event
     * @param Team $team
     *
     * @return array
     */
    function calculateSections($event, Team $team)
    {

        $responses = $event->responses->where('team_id', $team->id)->all();

        $progressMetricTotal = 0;

        $questions = $event->latestForm()?->allQuestions();

        $allSections = collect($questions)->groupBy('section')->reject(fn ($item, $key) => $key == 'custom');
        $sectionCount = $allSections->keys()->mapWithkeys(fn ($item) => [$item . '_count' => 0])->all();
        $totalSections = $allSections->reject(fn ($item, $key) => $key == 'Intutive_Scoring')->flatten(1)->count();

        if(!$totalSections) {
            return [];
        }

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
