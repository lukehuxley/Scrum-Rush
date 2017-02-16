<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scrum extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'uuid',
        'voter_id',
        'public'
    ];

    protected $casts = [
        'round_open' => 'boolean',
        'started' => 'boolean',
        'public' => 'boolean',
    ];

    public function voters()
    {
        return $this->belongsToMany('App\Voter')->withPivot('points_vote');
    }

    public function status($voter)
    {
        $scrum_master = ($this->voter_id == $voter->id) ? true : false;
        $voter_id = $voter->id;
        $voter = $this->voters()->where('id', $voter_id)->first();

        $vote = $voter->pivot->points_vote;
        $round_open = $this->round_open;
        $scrum_started = $this->started;

        $voters_model = $this->voters()->get();
        $voters = [];
        $scale = [0,1,2,3,5,8,13,21,34];
        foreach ($voters_model as $voter)
        {
            if ($this->round_open && ! $scrum_master)
                $points_vote = null;
            else
                $points_vote = $voter->pivot->points_vote;

            $voters[] = [
                'name' => $voter->name,
                'points_vote' => $points_vote,
                'voted' => ($voter->pivot->points_vote !== null) ? true : false,
                'uuid' => $voter->uuid,
                'inactive' => ($voter->updated_at < \Carbon\Carbon::now()->subMinutes(5)) ? true : false
            ];
        }

        return compact('round_open', 'vote', 'voters', 'scale', 'scrum_started');
    }

}
