<?php

namespace App\Http\Middleware;

use App\Scrum;
use Closure;

class VerifyScrumMaster
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
        // Get the route uuid param
        $uuid = $request->route('uuid');

        // Load the scrum from the UUID
        $scrum = Scrum::where('uuid', $uuid)->first();

        // Load the voter
        $voter = $scrum->voters()->where('session_id', $request->session()->getId())->first();

        // If the scrum's voter_id does not match the voter's ID they are not the scrum master
        if ($scrum->voter_id != $voter->id) {

            // If request is for API data return false
            if (in_array('api', $request->route()->middleware()))
                return response()->json(false);

            return redirect()->back()->withErrors('You are not the scrum master');
        }

        return $next($request);
    }
}
