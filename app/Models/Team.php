<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];

        /**
     * Get the owner of the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @return string
     */
    public function getTeamImageAttribute()
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Undocumented function
     *
     * @param  \App\Models\Form $form
     * @return void
     */
    public function calculateSections($form)
    {
        $responses = $form->responses()->where('team_id', $this->id)->get();
        $progressMetricTotal = 0;
        $questions = $form->allQuestions();
        $allSections = collect($questions)->groupBy('section')->reject(fn($item, $key) => $key == 'custom');
        $sectionCount = $allSections->keys()->mapWithkeys(fn($item) => [$item.'_count' => 0])->all();
        $totalSections = $allSections->reject(fn($item, $key) => $key == 'Intutive_Scoring')->flatten(1)->count();


        foreach($responses as $response) {
            $total = 0;
            foreach($allSections->reject(fn($item, $key) => $key == 'Intutive_Scoring')->all() as $section => $sectionData) {

                $sectionQuestions = $sectionData->pluck('question')->map(fn($item) => Str::slug($item))->toArray();

                $total += collect($response->questions)->filter(function($item, $key) use ($sectionQuestions) {
                    return in_array($key, $sectionQuestions);
                })->sum();
            }

            $progressMetricTotal += number_format($total / $totalSections, 1);

            foreach($allSections->all() as $section => $sectionData) {
                $sectionQuestions = $sectionData->pluck('question')->map(fn($item) => Str::slug($item))->toArray();
                $total = collect($response->questions)->filter(function($item, $key) use($sectionQuestions) {
                    return in_array($key, $sectionQuestions);
                })->sum();

                $sectionCount[$section .'_count'] += number_format($total / $allSections->count(), 1);
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
