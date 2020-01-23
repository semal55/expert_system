<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hypothesis extends Model
{
    public const YES = 1.00;
    public const RATHER_YES = 0.75;
    public const NOT_SURE = 0.50;
    public const RATHER_NO = 0.25;
    public const NO = 0.00;

    public function test()
    {
    	return $this->belongsTo(Test::class);
    }

	public function questions()
    {
    	return $this->belongsToMany(Question::class)->withPivot('plus', 'minus');
    }

    public function get_coof($answer) 
    {
        switch ($answer) {
            case '0':
                return self::YES;
                break;
            case '1':
                return self::RATHER_YES;
                break;
            case '2':
                return self::NOT_SURE;
                break;
            case '3':
                return self::RATHER_NO;
                break;
            case '4':
                return self::NO;
                break;
        }
    }

    public function calc($prior, $answer, $plus, $minus)
    {
        $probability = $this->get_coof($answer);
    	if ($probability > self::NOT_SURE) {
			$posterior = ($plus*$prior) / ($plus*$prior + $minus*(1-$prior));
            $result = $prior + (($probability - self::NOT_SURE) * ($posterior - $prior)) / (self::NOT_SURE);
		} else {
			$posterior = ((1-$plus)*$prior) / ((1-$plus)*$prior + (1-$minus)*(1-$prior));
            $result = $posterior + ($probability * ($prior - $posterior)) / (self::NOT_SURE);
		}
		return $result;
    }
}
