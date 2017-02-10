<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scrum extends Model
{
    protected $fillable = [
        'name',
        'scrum_master',
        'uuid',
        'session_id'
    ];

    protected $casts = [
        'round_open' => 'boolean',
        'started' => 'boolean',
    ];

    public function voters()
    {
        return $this->hasMany('App\Voter');
    }

    public function vote()
    {
        $this->state = 'voting';
        $this->save();
    }

    public function start()
    {
        $this->started = true;
        $this->save();
    }

    public function end()
    {
        $this->delete();
    }

    public function end_round()
    {
        $this->round_open = false;
        $this->save();
    }

    public function start_new_round()
    {
        $this->clear_votes();
        $this->round_open = true;
        $this->save();
    }

    public function clear_votes()
    {
        foreach($this->voters as $voter)
        {
            $voter->clear_vote();
        }
    }

}
