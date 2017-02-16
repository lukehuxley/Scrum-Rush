<?php

namespace App\Http\Controllers;

use App\Scrum;
use App\Voter;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class ScrumVoter extends Controller
{

    public function showScrum(Request $request, $uuid)
    {
        $scrum = Scrum::where('uuid', $uuid)->first();
        $voter = $scrum->voters()->where('session_id', $request->session()->getId())->first();

        // Scrum URL
        $protocol = ( ! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domain_name = $_SERVER['HTTP_HOST'].'/';
        $scrum_rush_url = $protocol.$domain_name;
        $scrum_uuid = $scrum->uuid;

        // If the voter does not belong to this scrum
        if ( ! $voter)
        {
            // Load the voter if the session ID already exists in database
            $voter = Voter::where('session_id', $request->session()->getId())->first();

            // Set the name to the voter name or blank if new voter
            $voter_name = ($voter) ? $voter->name : '';

            // Get the name of the scrum
            $scrum_name = $scrum->name;

            return view('join-scrum', compact('voter_name', 'scrum_rush_url', 'scrum_uuid', 'scrum_name'));
        }

        $scrum_master = ($scrum->voter_id == $voter->id) ? true : false;
        $scrum_name = $scrum->name;
        $voter_name = $voter->name;

        $scrum_data = json_encode($scrum->status($voter));

        return view(($scrum_master) ? 'scrum-master' : 'scrum-voter', compact('scrum_name', 'voter_name', 'scrum_data', 'scrum_rush_url', 'scrum_uuid'));

    }

    public function joinScrum(Request $request, $uuid)
    {
        $scrum = Scrum::where('uuid', $uuid)->first();
        $voter = Voter::where('session_id', $request->session()->getId())->first();

        $this->validate($request, [
            'voter_name' => 'required|max:1024'
        ]);

        // If the voter doesn't already exist, create one
        if ( ! $voter)
        {
            $voter = new Voter([
                'session_id' => $request->session()->getId(),
                'uuid' => Uuid::uuid4()->toString(),
            ]);
        }

        // Set voter name
        $voter->name = $request->voter_name;

        // Save voter
        $voter->save();

        // Join the scrum
        $scrum->voters()->attach($voter);

        return redirect('/'.$uuid);

    }

    public function leaveScrum(Request $request, $uuid)
    {
        $scrum = Scrum::where('uuid', $uuid)->first();
        $voter = $scrum->voters()->where('session_id', $request->session()->getId())->first();

        // The scrum master can not leave the scrum
        if ($scrum->voter_id == $voter->id)
            return redirect()->back()->withErrors('You can not leave the scrum because you are scrum master');

        // Detach voter from scrum
        $scrum->voters()->detach($voter);

        return redirect('/')->with(['status' => 'You have left scrum '.$scrum->name]);
    }

    public function getScrumStatus(Request $request, $uuid)
    {
        $scrum = Scrum::where('uuid', $uuid)->first();
        $voter = $scrum->voters()->where('session_id', $request->session()->getId())->first();

        if ($scrum->voter_id == $voter->id)
        {
            $scrum->setUpdatedAt($scrum->freshTimestamp());
            $scrum->save();
        }

        $voter->setUpdatedAt($voter->freshTimestamp());
        $voter->save();

        return response()->json($scrum->status($voter));
    }

    public function submitPointsVote(Request $request, $uuid)
    {
        $scrum = Scrum::where('uuid', $uuid)->first();
        $voter = $scrum->voters()->where('session_id', $request->session()->getId())->first();

        if ($scrum->started && $scrum->round_open) {
            if ($request->points == $voter->pivot->points_vote)
                $voter->pivot->points_vote = null;
            else
                $voter->pivot->points_vote = $request->points;
        }
        $voter->pivot->save();

        return response()->json([
            'request_response' => $voter->pivot->points_vote,
            'scrum_status' => $scrum->status($voter)
        ]);
    }

}
