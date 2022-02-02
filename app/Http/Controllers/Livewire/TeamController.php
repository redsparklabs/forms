<?php

namespace App\Http\Controllers\Livewire;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use App\Models\Team;

class TeamController extends Controller
{
    /**
     * Show the organization management screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $team
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $team)
    {

        return view('teams.show', [
            'user' => $request->user(),
            'team' => $team,
        ]);
    }

    /**
     * @param  Request $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('teams.create', [
            'organization' => $request->user()->currentOrganization,
            'user' => $request->user(),
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
        return view('teams.index', [
            'organization' => $request->user()->currentOrganization,
            'user' => $request->user(),
        ]);
    }
}
