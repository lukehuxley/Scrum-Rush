<?php

namespace App\Http\Middleware;

use App\Scrum;
use Closure;

class VerifyScrum
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
        $uuid = $request->route('uuid');

        // If scrum does not exist
        if ( ! Scrum::where('uuid', $uuid)->exists())
        {
            // Has this scrum been deleted
            $deleted_scrum = Scrum::where('uuid', $uuid)->withTrashed()->first();

            // If request is for API data return false
            if (in_array('api', $request->route()->middleware()))
                return response()->json(false);

            // If the scrum was deleted then it ended, otherwise it doesn't exist
            return redirect('/')->withErrors(($deleted_scrum) ? 'Scrum '.$deleted_scrum->name.' has ended' : 'Scrum does not exist');

        }

        return $next($request);
    }
}
