<?php

namespace App\Http\Controllers\Livewire;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use App\Models\Team;
use App\Models\Form;
use App\Models\Event;

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

        $customQuestion = $form->questions->map(function($item) {
            return [
                'question' => $item['question'],
                'description' => $item['description'],
                'color' => '',
                'section' => 'custom'
            ];
        })->toArray();

        $questions = array_merge(
            config('questions.business-model'),
            config('questions.qualitative-intuitive-scoring'),
            $customQuestion,

        );

        $feedback_questions = config('questions.qualitative-intuitive-scoring-feedback');

        if($team) {
            $responses = $form->responses()->where('team_id', $team->id)->get();
        } else {
            $responses = $form->responses()->get();
        }


        return view('events.results', compact('event', 'form', 'team', 'questions', 'feedback_questions', 'responses'));
    }

}
