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
            'scrum_name' => 'required|max:1024',
            'scrum_master_name' => 'required|max:1024',
        ]);

        // Identify the session
        $session_id = $request->session()->getId();

        // Match session to voter if exists
        $voter = Voter::where('session_id', $request->session()->getId())->first();

        if ($voter)
        {
            // If the voter already exists

            // Set the voters name to the one provided
            $voter->name = $request->scrum_master_name;

        } else {
            // If the voter doesn't already exist

            // Create a new voter who will become the scrum master
            $voter = new Voter([
                'name' => $request->scrum_master_name,
                'session_id' => $session_id,
                'uuid' => Uuid::uuid4()->toString()
            ]);

        }

        // Save the voter
        $voter->save();

        // Create the scrum, setting this voter as the scrum master
        $scrum = new Scrum([
            'name' => $request->scrum_name,
            'uuid' => Uuid::uuid4()->toString(),
            'voter_id' => $voter->id,
            'public' => ($request->private == 'on') ? false : true
        ]);

        // Save the scrum
        $scrum->save();

        // Attach the voter to the scrum (as well as setting scrum master)
        $scrum->voters()->attach($voter);

        return redirect('/'.$scrum->uuid);
    }

    public function endScrum(Request $request, $uuid)
    {
        $scrum = Scrum::where('uuid', $uuid)->first();

        $scrum_name = $scrum->name;
        $scrum->delete();

        return redirect('/')->with('status', 'Ended the '.$scrum_name.' scrum');
    }

    public function startScrum(Request $request, $uuid)
    {
        $scrum = Scrum::where('uuid', $uuid)->first();
        $voter = Voter::where('session_id', $request->session()->getId())->first();

        $scrum->started = true;
        $scrum->round_open = true;
        $scrum->save();

        return response()->json([
            'scrum_status' => $scrum->status($voter)
        ]);
    }

    public function startNewRound(Request $request, $uuid)
    {
        $scrum = Scrum::where('uuid', $uuid)->first();
        $voter = Voter::where('session_id', $request->session()->getId())->first();

        foreach ($scrum->voters()->get() as $voter)
        {
            $voter->pivot->points_vote = null;
            $voter->pivot->save();
        }
        $scrum->round_open = true;
        $scrum->save();

        return response()->json([
            'scrum_status' => $scrum->status($voter)
        ]);
    }

    public function endRound(Request $request, $uuid)
    {
        $scrum = Scrum::where('uuid', $uuid)->first();
        $voter = Voter::where('session_id', $request->session()->getId())->first();

        $scrum->round_open = false;
        $scrum->save();

        return response()->json([
            'scrum_status' => $scrum->status($voter)
        ]);
    }

}
