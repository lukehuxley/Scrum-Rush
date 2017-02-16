<?php

namespace App\Http\Controllers;

use App\Scrum;
use App\Voter;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $voter = Voter::where('session_id', $request->session()->getId())->first();
        if ($voter)
        {
            $voter_scrums = [];
            $other_scrums = [];

            $scrums = Scrum::where('updated_at', '>', \Carbon\Carbon::now()->subMinutes(30))->get();
            foreach($scrums as $scrum) {
                $voter_in_scrum = false;
                foreach($scrum->voters as $scrum_voter)
                {
                    if ($scrum_voter->id == $voter->id)
                    {
                        $voter_in_scrum = true;
                        $voter_scrums[] = $scrum;
                        break;
                    }
                }
                if ( ! $voter_in_scrum) {
                    if ($scrum->public)
                        $other_scrums[] = $scrum;
                }
            }
        } else {
            $voter_scrums = [];
            $other_scrums = Scrum::where('public', true)->where('updated_at', '>', \Carbon\Carbon::now()->subMinutes(5))->get();
        }

        return view('welcome', compact('voter_scrums', 'other_scrums'));
    }

}
