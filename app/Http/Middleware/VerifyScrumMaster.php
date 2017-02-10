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
        $session_id = $request->session()->getId();
        $scrums = Scrum::where('session_id', $session_id);

        if ($scrums->count() == 0)
            return redirect('/');

        return $next($request);
    }
}
