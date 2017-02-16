<?php

namespace App\Http\Middleware;

use App\Voter;
use Closure;

class VerifyScrumVoter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $session_id = $request->session()->getId();
        $voter = Voter::where('session_id', $session_id)->first();

        // Is this session ID associated to a voter
        if ( ! $voter) {

            // If request is for API data return false
            if (in_array('api', $request->route()->middleware()))
                return response()->json(false);

            return redirect('/')->withErrors('Session does not exist or session has expired');
        }

        return $next($request);
    }
}
