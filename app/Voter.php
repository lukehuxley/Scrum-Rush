<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    protected $fillable = [
        'name',
        'session_id',
        'uuid'
    ];

    public function clear_vote() {
        $this->points_vote = null;
        $this->priority_vote = null;
        $this->save();
    }

    public function scrum() {
        return $this->belongsTo('App\Scrum');
    }

    public function join_scrum($scrum_id) {
        $this->scrum_id = $scrum_id;
        $this->save();
    }

    public function leave_scrum() {
        $this->delete();
    }

    public function vote_points($points) {
        $this->points_vote = $points;
        $this->save();
    }

    public function vote_priority($priority) {
        $this->priority_vote = $priority;
        $this->save();
    }

}
