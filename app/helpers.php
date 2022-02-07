<?php
use App\Models\Form;
use App\Models\Team;
if (!function_exists('colorize')) {
    /**
     * Colorize
     *
     * @param  integer $number
     *
     * @return string|null
     */
    function colorize($number)
    {

        if (inbetween($number, 0, .99)) {
            return 'bg-red-900';
        }

        if (inbetween($number, 1, 1.99)) {
            return 'bg-pink-900';
        }

        if (inbetween($number, 2, 2.99)) {
            return 'bg-yellow-500';
        }

        if (inbetween($number, 3, 3.99)) {
            return 'bg-green-400';
        }

        if (inbetween($number, 4, 5)) {
            return 'bg-green-900';
        }

        return null;
    }
}


if (!function_exists('inbetween')) {
    /**
     * Check if a number is between two other numbers
     *
     * @param  integer $val
     * @param  integer $min
     * @param  float $max
     *
     * @return bool
     */
    function inbetween($val, $min, $max)
    {
        return ($val >= $min && $val <= $max);
    }
}

function calculateSections(Form $form, Team $team)
{
        $responses = $form->responses()->where('team_id', $team->id)->get();
        $progressMetricTotal = 0;
        $questions = $form->allQuestions();
        $allSections = collect($questions)->groupBy('section')->reject(fn ($item, $key) => $key == 'custom');
        $sectionCount = $allSections->keys()->mapWithkeys(fn ($item) => [$item . '_count' => 0])->all();
        $totalSections = $allSections->reject(fn ($item, $key) => $key == 'Intutive_Scoring')->flatten(1)->count();


        foreach ($responses as $response) {
            $total = 0;
            foreach ($allSections->reject(fn ($item, $key) => $key == 'Intutive_Scoring')->all() as $section => $sectionData) {

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

                $sectionCount[$section . '_count'] += number_format($sectionTotal / $allSections->count(), 1);
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
