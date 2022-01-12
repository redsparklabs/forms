<?php

namespace App\Http\Controllers\Livewire;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use App\Models\Team;
use App\Models\Form;
use App\Models\Event;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Show the organization management screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $event
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $event)
    {

        // if (Gate::denies('view', $team)) {
        //     abort(403);
        // }

        return view('events.show', [
            'user' => $request->user(),
            'event' => $event,
        ]);
    }

    /**
     * Show the organization creation screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Gate::authorize('create', Team::class);

        return view('events.index', [
            'organization' => $request->user()->currentOrganization,
            'user' => $request->user(),
        ]);
    }

    /**
     * Undocumented function
     *
     * @param  Request $request
     * @param  Event   $event
     * @param  Form    $form
     * @param  Team|null  $team
     *
     * @return \Illuminate\View\View
     */
    public function results(Request $request, Event $event, Form $form, Team $team = null)
    {
        $form = $event->forms()->findOrFail($form->id);

        $progressMetricTotal = 0;
        $questions = $form->allQuestions();
        $feedback_questions = $form->feedbackQuestions();
        $sections = collect($questions)->groupBy('section')->reject(fn ($item, $key) => $key == 'custom');
        $sectionTotals = $sections->keys()->mapWithkeys(fn ($item) => [$item . '_count' => 0])->all();
        $totalSections = $sections->reject(fn ($item, $key) => $key == 'Intutive_Scoring')->flatten(1)->count();

        if ($team) {
            $responses = $form->responses()->where('team_id', $team->id)->get();
        } else {
            $responses = $form->responses()->get();
        }

        return view('events.results', compact(
            'event',
            'form',
            'team',
            'questions',
            'sections',
            'responses',
            'progressMetricTotal',
            'sectionTotals',
            'totalSections'
        ));
    }
}
