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
        $voters = Voter::where('session_id', $session_id);

        if ($voters->count() == 0)
            return redirect('/');

        return $next($request);
    }
}
