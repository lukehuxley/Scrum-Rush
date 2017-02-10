<?php

namespace App\Http\Controllers;

use App\Scrum;
use App\Voter;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class ScrumVoter extends Controller
{

    public function joinScrumForm(Request $request, $uuid)
    {

        // If the scrum does not exist redirect the user
        $scrums = Scrum::where('uuid', $uuid);
        if ($scrums->count() == 0)
            return redirect('/');

        $voter_name = '';

        // Get the name of the scrum
        $scrum = $scrums->first();
        $scrum_name = $scrum->name;

        // If this session is already in another scrum
        $voters = Voter::where('session_id', $request->session()->getId());
        if ($voters->count() > 0)
        {
            // Get the voter's name
            $voter = $voters->first();
            $voter_name = $voter->name;
        }

        return view('join-scrum', compact('voter_name', 'scrum_name'));

    }

    public function joinScrum(Request $request, $uuid)
    {
        $this->validate($request, [
            'voter_name' => 'required|max:1024'
        ]);

        // If the scrum does not exist redirect the user
        $scrums = Scrum::where('uuid', $uuid);
        if ($scrums->count() == 0)
            return redirect('/');

        // If this session is already in another scrum
        $voters = Voter::where('session_id', $request->session()->getId());
        if ($voters->count() > 0)
        {
            // Delete the voter, removing from their current scrum
            $voter = $voters->first();
            $voter->leave_scrum();
        } else {
            $voter = new Voter([
                'session_id' => $request->session()->getId(),
                'uuid' => Uuid::uuid4()->toString()
            ]);
        }

        // Get the scrum
        $scrum = $scrums->first();

        // Set voter name
        $voter->name = $request->voter_name;

        // Join the scrum
        $voter->join_scrum($scrum->id);

        return redirect('/scrum');

    }

    public function leaveScrum(Request $request)
    {

        $voters = Voter::where('session_id', $request->session()->getId());
        if ($voters->count() > 0)
        {
            // Delete the voter, removing from their current scrum
            $voter = $voters->first();
            $voter->leave_scrum();
        }

        return redirect('/');

    }

    public function index(Request $request)
    {
        $voter = Voter::where('session_id', $request->session()->getId())->first();
        $scrum = $voter->scrum();

        if ($scrum->count() == 0)
        {
            $voter->leave_scrum();
            return redirect('/');
        }

        $scrum = $scrum->first();

        $protocol = ( ! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domain_name = $_SERVER['HTTP_HOST'].'/';

        $scrum_url = $protocol.$domain_name.'scrum/'.$scrum->uuid;
        $scrum_name = $scrum->name;
        $vote = $voter->points_vote;
        $voter_name = $voter->name;
        $round_open = $scrum->round_open;
        $scrum_started = $scrum->started;

        $voters_model = $scrum->voters()->get();

        $voters = [];
        $scale = [0,1,2,3,5,8,13,21,34];

        foreach ($voters_model as $voter)
        {
            if ($scrum->round_open)
                $points_vote = null;
            else
                $points_vote = $voter->points_vote;

            $voters[] = [
                'name' => $voter->name,
                'points_vote' => $points_vote,
                'voted' => ($voter->points_vote !== null) ? true : false,
                'uuid' => $voter->uuid
            ];
        }

        $scrum_data = json_encode(compact('round_open', 'vote', 'voters', 'scale', 'scrum_started'));

        return view('scrum-voter', compact('scrum_name', 'voter_name', 'scrum_data', 'scrum_url'));
    }

}
