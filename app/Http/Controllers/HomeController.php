<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;

class HomeController extends Controller
{
    /**
     * Handle the default route for authenticated users.
     * 
     * Organization owners/admins go to dashboard.
     * Team members go to their first project.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Check if user has an organization (organization owner/admin)
        if ($user->allOrganizations()->count() > 0) {
            // Redirect to dashboard for organization owners/admins
            return redirect()->route('dashboard');
        } else {
            // Project-scoped team member - redirect to first project
            $firstTeam = Team::whereHas('members', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->first();
            
            if ($firstTeam) {
                return redirect()->route('teams.show', $firstTeam);
            } else {
                // Fallback if no teams found (shouldn't happen for invited members)
                return redirect()->route('dashboard');
            }
        }
    }
}
