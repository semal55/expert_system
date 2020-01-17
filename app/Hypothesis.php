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
}
