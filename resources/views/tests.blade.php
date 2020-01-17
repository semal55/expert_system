<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	@foreach($tests as $test)
		<div>
			<a href="{{route('test')}}">
				<span>{{$test->name}}</span>
			</a>
		</div>
	@endforeach
	<a href="{{route('mkb')}}">Append test</a>
</body>
</html>