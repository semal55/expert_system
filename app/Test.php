<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    public function questions()
    {
    	return $this->hasMany(Question::class)->orderBy('id');
    }

    public function hypotheses()
    {
    	return $this->hasMany(Hypothesis::class);
    }

    public function session()
    {
    	return $this->hasOne(Session::class);
    }
}
