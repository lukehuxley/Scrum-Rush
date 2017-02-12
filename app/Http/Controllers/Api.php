<?php

namespace App\Http\Controllers;

use App\Scrum;
use App\Voter;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class Api extends Controller
{

    private function voters($scrum)
    {
        // Get the voters
        $voters = $scrum->voters()->get();

        $return_voters = [];

        foreach ($voters as $voter)
        {
            if ($scrum->round_open)
                $return_voters[] = [
                    'name' => $voter->name,
                    'voted' => ($voter->points_vote != null),
                    'uuid' => $voter->uuid
                ];
            else
                $return_voters[] = [
                    'name' => $voter->name,
                    'points_vote' => $voter->points_vote,
                    'uuid' => $voter->uuid
                ];
        }

        return $return_voters;
    }

    public function submitPointsVote(Request $request)
    {
        $voter = Voter::where('session_id', $request->session()->getId())->first();

        $scrum = $voter->scrum()->first();

        if ($scrum->started && $scrum->round_open) {
            if ($request->points == $voter->points_vote)
                $voter->vote_points(null);
            else
                $voter->vote_points($request->points);
        }

        return response()->json([
            'request_response' => $voter->points_vote,
            'scrum_status' => $this->scrumStatus($request)
        ]);
    }

    private function scrumStatus(Request $request)
    {
        $voter = Voter::where('session_id', $request->session()->getId());

        if ($voter->count() == 0)
        {
            $request->session()->flash('status', 'Scrum has ended');
            return response()->json(false);
        }

        $voter = $voter->first();
        $scrum = $voter->scrum()->first();

        $voters_model = $scrum->voters()->get();

        $voters = [];
        $scale = [0,1,2,3,5,8,13,21];

        foreach ($voters_model as $voter_model) {
            if ($scrum->round_open && $scrum->session_id != $voter->session_id)
                $points_vote = null;
            else
                $points_vote = $voter_model->points_vote;

            $voters[] = [
                'name' => $voter_model->name,
                'points_vote' => $points_vote,
                'voted' => ($voter_model->points_vote !== null) ? true : false,
                'uuid' => $voter_model->uuid
            ];
        }

        return [
            'round_open' => ($scrum->round_open) ? true : false,
            'voters' => $voters,
            'vote' => $voter->points_vote,
            'scale' => $scale,
            'scrum_started' => ($scrum->started) ? true : false
        ];
    }

    public function getScrumStatus(Request $request)
    {
        return response()->json($this->scrumStatus($request));
    }

    public function startScrum(Request $request)
    {
        $scrum = Scrum::where('session_id', $request->session()->getId())->first();

        $scrum->start();
        $scrum->start_new_round();

        return response()->json([
            'scrum_status' => $this->scrumStatus($request)
        ]);
    }

    public function startNewRound(Request $request)
    {
        $scrum = Scrum::where('session_id', $request->session()->getId())->first();

        $scrum->start_new_round();

        return response()->json([
            'scrum_status' => $this->scrumStatus($request)
        ]);
    }

    public function endRound(Request $request)
    {
        $scrum = Scrum::where('session_id', $request->session()->getId())->first();

        $scrum->end_round();

        return response()->json([
            'scrum_status' => $this->scrumStatus($request)
        ]);
    }

}
