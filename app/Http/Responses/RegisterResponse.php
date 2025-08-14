<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // Check if this was an invitation registration
        if ($teamId = session('invitation_redirect_team_id')) {
            // Clear the session variable
            session()->forget('invitation_redirect_team_id');
            
            // Redirect to the project details page
            return $request->wantsJson()
                ? new JsonResponse('', 201)
                : redirect()->route('teams.show', ['team' => $teamId])
                    ->with('status', 'Welcome! You have successfully joined the team.');
        }
        
        // Default redirect for regular registrations
        return $request->wantsJson()
            ? new JsonResponse('', 201)
            : redirect()->intended(config('fortify.home'));
    }
}
