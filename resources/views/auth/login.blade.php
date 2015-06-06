@extends('public')

@section('content')

@if (count($errors) > 0)
	<div class="alert alert-danger">
		<strong>Whoops!</strong> There were some problems with your input.<br><br>
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif

<form class="" method="POST" action="{{ url('/auth/login') }}">
	<input tpye="hidden" name="_token" value="{{ csrf_token() }}">
	
	<div class="ui left icon input">
		<input type="text" name="email" placeholder="E-mail">
		<i class="mail icon"></i>
	</div>

	<div class="ui left icon input">
		<input type="password" name="password" placeholder="Password">
		<i class="key icon"></i>
	</div>

	<div class="ui checkbox">
		<input type="checkbox" name="remember">
		<label>Remember me</label>
	</div>

	<button type="submit" class="ui basic button">
		<i class="icon user"></i>
		Login
	</button>
</form>
@endsection