<?php

namespace App\Http\Controllers;

use App\Scrum;
use App\Voter;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class ScrumMaster extends Controller
{

    public function createScrum(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:1024',
            'scrum_master' => 'required|max:1024',
        ]);

        $session_id = $request->session()->getId();

        $scrum = new Scrum([
            'name' => $request->name,
            'scrum_master' => $request->scrum_master,
            'uuid' => Uuid::uuid4()->toString(),
            'session_id' => $session_id
        ]);
        $scrum->save();

        // Create a new voter
        $voter = new Voter([
            'name' => $request->scrum_master,
            'session_id' => $session_id,
            'uuid' => Uuid::uuid4()->toString(),
        ]);
        $voter->join_scrum($scrum->id);

        session(['scrum' => $scrum->id]);

        return redirect('/scrum-master');
    }

    public function endScrum(Request $request)
    {
        $scrums = Scrum::where('session_id', $request->session()->getId());
        if ($scrums->count() == 0)
            return redirect('/');
        $scrum = $scrums->first();
        $scrum_name = $scrum->name;
        $scrum->end();
        return redirect('/')->with('status', 'Ended the '.$scrum_name.' scrum');
    }

    public function index(Request $request)
    {
        $scrum = Scrum::where('session_id', $request->session()->getId())->first();
        $voter = Voter::where('session_id', $request->session()->getId())->first();

        $protocol = ( ! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domain_name = $_SERVER['HTTP_HOST'].'/';

        $scrum_url = $protocol.$domain_name.'scrum/'.$scrum->uuid;
        $scrum_master = $scrum->scrum_master;
        $scrum_name = $scrum->name;
        $scrum_started = $scrum->started;

        $round_open = $scrum->round_open;
        $vote = $voter->points_vote;

        $voters_model = $scrum->voters()->get();
        $scale = [0,1,2,3,5,8,13,21,34];

        $voters = [];
        foreach ($voters_model as $voter)
        {
            $voters[] = [
                'name' => $voter->name,
                'voted' => ($voter->points_vote !== null) ? true : false,
                'points_vote' => $voter->points_vote,
                'uuid' => $voter->uuid,
            ];
        }
        $scrum_data = json_encode(compact('round_open', 'vote', 'voters', 'scale', 'scrum_started'));

        return view('scrum-master', compact('scrum_url', 'scrum_name', 'scrum_master', 'scrum_started', 'round_open', 'scrum_data'));
    }

}
