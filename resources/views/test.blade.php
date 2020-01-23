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
		<input type="radio" name="answer" value="1" checked/> Yes
		<input type="radio" name="answer" value="0" /> No
		<input type="submit" value="Ответить"/>
	</form>
</body>
</html>