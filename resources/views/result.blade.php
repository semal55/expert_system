<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Результат {{$test->name}}</title>
</head>
<body>
	@foreach($hypotheses as $hypothesis)
	<div>
		<span>{{$hypothesis->name}}</span>
		<span>{{$hypothesis->prior}}</span>
	</div>
	@endforeach

	<div>
		<a href="{{route('reset', ['test' => $test])}}">Reset answers</a>
	</div>
</body>
</html>