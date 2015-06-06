<!DOCTYPE html>
<html>
<head>
	<title>{{ config('app.title') }}</title>
	@include('layout/head')
</head>
<body>
	@yield('content')
	@include('layout/scripts')
</body>
</html>