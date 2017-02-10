<?php

namespace App\Http\Controllers;

use App\Scrum;
use App\Voter;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $session_id = $request->session()->getId();
        $scrum = Scrum::where('session_id', $session_id);

        if ($scrum->count() > 0)
            return redirect('/scrum-master');

        $voter = Voter::where('session_id', $session_id);

        if ($voter->count() > 0)
            return redirect('/scrum');

        return view('welcome');
    }

}
