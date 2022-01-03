<?php

namespace App\Http\Controllers\Livewire;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use App\Models\Organization;

class OrganizationController extends Controller
{
    /**
     * Show the organization management screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $organization
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $organization)
    {

        if (Gate::denies('view', $organization)) {
            abort(403);
        }

        return view('organizations.show', [
            'user' => $request->user(),
            'organization' => $organization,
        ]);
    }

    /**
     * Show the organization creation screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        Gate::authorize('create', Organization::class);

        return view('organizations.create', [
            'user' => $request->user(),
        ]);
    }
}
