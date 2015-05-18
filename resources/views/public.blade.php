<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>OpenPrice</title>
<link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/semantic.min.css" rel="stylesheet">
<style>
.segment { padding: 2em 0; }
.short.segment { padding: 4em 0; }
.header.segment {
	position: relative;
	z-index: 2;
	margin: 0em;
	min-height: 185px;
	padding-top: 70px;
	padding-bottom: 30px;
	background-color: #fff;
	border-bottom: 1px solid #ddd;
	box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}
.header.segment .container { right: 110px; }
.main.container {
	margin: 0em auto;
	padding: 2em 0;
	z-index: 1;
}
.container{
	position: relative;
	width: 915px;
	margin: 0px auto;
}

</style>

</head>
<body>

@yield('content')

{{-- Scripts --}}
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/semantic.min.js"></script>

</body>
</html>