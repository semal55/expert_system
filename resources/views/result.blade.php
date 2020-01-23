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
</body>
</html>