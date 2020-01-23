<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hypothesis extends Model
{
    public function test()
    {
    	return $this->belongsTo(Test::class);
    }

	public function questions()
    {
    	return $this->belongsToMany(Question::class)->withPivot('plus', 'minus');
    }

    public function calc($prior, $answer, $plus, $minus)
    {
    	if ($answer) {
			$result = ($plus*$prior) / ($plus*$prior + $minus*(1-$prior));
		} else {
			$result = ((1-$plus)*$prior) / ((1-$plus)*$prior + (1-$minus)*(1-$prior));
		}
		return $result;
    }
}
