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

    public function scrums() {
        return $this->belongsToMany('App\Scrum')->withPivot('points_vote');
    }

}
