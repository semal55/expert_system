<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>{{$test->name}}</title>
</head>
<body>
	<span>{{$question->question}}</span>
	<form action="{{route('post_answer', ['test' => $test])}}" method="post">
		{{csrf_field()}}
		<input type="text" hidden="" name="question_id" value="{{$question->id}}">
		<div>
			<input type="radio" name="answer" value="0" checked/> Yes
		</div>
		<div>
			<input type="radio" name="answer" value="1"/> Rather Yes
		</div>
		<div>
			<input type="radio" name="answer" value="2"/> Not sure
		</div>
		<div>
			<input type="radio" name="answer" value="3"/> Rather No
		</div>
		<div>
			<input type="radio" name="answer" value="4"/> No
		</div>
		<div>
			<input type="submit" value="Ответить"/>
		</div>
	</form>
</body>
</html>