<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function test()
    {
    	return $this->belongsTo(Test::class);
    }

    public function hypotheses()
    {
    	return $this->belongsToMany(Hypothesis::class)->withPivot('plus', 'minus');
    }

    public function sessions()
    {
    	return $this->belongsToMany(Session::class, 'session_questions')->withPivot('answer');
    }
}
