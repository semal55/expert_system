<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="{{route('send_test')}}" method="post" enctype="multipart/form-data">
		{{csrf_field()}}
		<input type="file" name="upload">
		<input type="submit">
	</form>
</body>
</html>
