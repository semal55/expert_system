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
}
