<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    public function test()
    {
    	return $this->belongsTo(Test::class);
    }

    public function questions()
    {
    	return $this->belongsToMany(Question::class, 'session_questions')->withPivot('answer');
    }

    public function delete()
    {
        $this->questions()->sync([]);

        return parent::delete();
    }
}
