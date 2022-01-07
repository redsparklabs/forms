<?php

namespace App\Http\Controllers\Livewire;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use App\Models\Team;

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
}
