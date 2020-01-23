<?php

namespace App\Http\Controllers;

use Storage;
use \App\State;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
    	$tests = \App\Test::all();
   		return view('tests', compact('tests'));
    }

    public function mkb()
    {
    	return view('mkb');
    }

    public function send(Request $request)
    {
    	$file = $request->file('upload');
    	$path = $file->store('');
    	$mkb = Storage::get($path);
    	$text = new Collection();
    	$string = "";
    	for ($i = 0, $j = strlen($mkb); $i < $j; $i++) {
    		if ($mkb[$i] == "\r") {
    			$i++;
    			$text->push($string);
    			$string = "";
    			continue;
    		}
    		$string .= $mkb[$i];
		}
		$text->push($string);
		
		$num = 0;

		$test = new \App\Test();
		$test->name = $text[$num];
		$num++;

		if (mb_substr($text[$num], 0, 6) === "Автор:") {
			$test->author = mb_substr($text[1], 6);
			$num++;
		}
		$test->save();

		if ($text[$num] === "") {
			$num++;
		}

		$questionsFlag = false;
		if ($text[$num] === "Вопросы:") {
			$questionsFlag = true;
			$num++;
		}

		$questions = new Collection();

		while ($text[$num] !== "") {
			$question = new \App\Question();
			$question->question = $text[$num];
			$question->test_id = $test->id;
			$question->save();
			$questions->push($question);
			$num++;
		}
		$questionsFlag = false;

		$num++;

		$hypotheses = new Collection();

		$state = new State();
		for (; $num < count($text); $num++) {
			$hypothesis = new \App\Hypothesis();
			$string = "";
			$pivot = [];
			for ($i = 0; $i < strlen($text[$num]); $i++) {
				$char = mb_substr($text[$num], $i, 1);
				if ($char == ",") {
					switch ($state->get()) {
						case State::HYPOTHESIS:
							$hypothesis->name = $string;
							$hypothesis->test_id = $test->id;
							$hypothesis->save();
							$hypotheses->push($hypothesis);
							break;
						case State::PRIOR:
							$hypothesis->prior = floatval($string);
							$hypothesis->save();
							break;
						case State::NUMBER_OF_QUESTION:
							$currentQuestion = $questions[intval($string)-1];
							break;
						case State::PLUS:
							$pivot['plus'] = floatval($string);
							break;
						case State::MINUS:
							$pivot['minus'] = floatval($string);
							break;
					}
					$string = "";
					$state->next();
					continue;
				}
				if (isset($pivot['plus']) && isset($pivot['minus'])) {
					$hypothesis->questions()->attach($currentQuestion->id, $pivot);
					$pivot = [];
				}
				$string .= $char;
			}
			$state->reset();
		}
		return redirect()->route('index');
    }

    public function test(\App\Test $test)
    {
    	$session = $test->session;
    	if ($session == null) {
    		$session = $test->session()->create();
    	}
    	$unsolved_question_ids = new Collection();
    	foreach ($session->questions as $question) {
    		$unsolved_question_ids->push($question->id);
    	}
    	$questions = $test->questions()->whereNotIn('id', $unsolved_question_ids)->get();
    	if ($questions->count() == 0) {
    		$session->finished = true;
    		$session->save();
    		return redirect()->route('result', ['test' => $test]);
    	}
    	return view('test', ['test' => $test, 'question' => $questions->first()]);
    }

    public function post_answer(Request $request, \App\Test $test)
    {
    	if (!isset($request->question_id)) {
    		return redirect()->back();
    	}
    	$session = $test->session;
    	$session->questions()->attach($request->question_id, ['answer' => $request->answer]);
    	return redirect()->route('test', ['test' => $test]);
    }

    public function result(\App\Test $test) 
    {
    	$hypotheses = new Collection();
    	foreach (\App\Hypothesis::all() as $hypothesis) {
    		$new_hypothesis = new \App\Hypothesis();
    		$new_hypothesis->id = $hypothesis->id;
			$new_hypothesis->name = $hypothesis->name;
			$new_hypothesis->prior = $hypothesis->prior;
			$hypotheses->push($new_hypothesis);
    	}
    	$session = $test->session;
    	foreach ($session->questions as $question) {
    		$question_hypotheses = $question->hypotheses;
    		$new_hypotheses = new Collection();
    		foreach ($question_hypotheses as $q_hypothesis) {

    			$prior = $q_hypothesis->calc(
    				$hypotheses->where('id', $q_hypothesis->id)->first()->prior,
    				$question->pivot->answer, 
    				$q_hypothesis->pivot->plus, 
    				$q_hypothesis->pivot->minus
    			);

    			$new_hypothesis = new \App\Hypothesis();
    			$new_hypothesis->id = $q_hypothesis->id;
    			$new_hypothesis->name = $q_hypothesis->name;
    			$new_hypothesis->prior = $prior;
    			$new_hypotheses->push($new_hypothesis);
    		}
    		if ($new_hypotheses->count() > 0) {
    			$hypotheses = $new_hypotheses;
    		}
    	}
    	return view('result', ['test' => $test, 'hypotheses' => $hypotheses->sortByDesc('prior')]);
    }

    public function reset(\App\Test $test)
    {
        $session = $test->session;
        if ($session !== null) {
            $session->delete();
        }
        return redirect()->route('index');
    }
}
