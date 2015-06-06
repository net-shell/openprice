<!DOCTYPE html>
<html lang="en">
<head>
	<title>{{ config('app.title') }}</title>
	@include('layout/head')
</head>
<body ng-app="OpenPrice">

	{{-- Sidebar --}}
	<div class="ui large inverted vertical visible sidebar menu left">
		@include('nav')
	</div>

	{{-- Content --}}
	<div class="pusher" ui-view></div>

@include('layout/scripts')

{{-- Angular JS --}}
<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.15/angular.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.14/angular-ui-router.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.15/angular-animate.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/angular-i18n/1.2.15/angular-locale_{{ App::getLocale() }}.js"></script>

{{-- RestAngular --}}
<script src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/restangular/1.5.1/restangular.min.js"></script>

{{-- Moment.js --}}
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/angular-moment/0.10.1/angular-moment.min.js"></script>

{{-- HighCharts/HighStock --}}
<script src="//cdnjs.cloudflare.com/ajax/libs/highstock/2.1.5/highstock.js"></script>
<script src="{{ asset('js/highcharts-ng.min.js') }}"></script>

{{-- Application scripts --}}
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/controllers.js') }}"></script>

</body>
</html>