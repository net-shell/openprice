<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>OpenPrice</title>

{{-- Stylesheets --}}
<link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/semantic.min.css" rel="stylesheet">
<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

</head>
<body ng-app="OpenPrice">

{{-- Dimmer --}}
<div class="ui inverted dimmer active" ng-class="{false: 'active', true: 'disabled'}[!loading]">
	<div class="ui text loader">
		<div ng-if="!haiku">please wait :)</div>
		<div ng-repeat="line in haiku">@{{ line }}</div>
	</div>
</div>

{{-- Sidebar --}}
<div class="ui large inverted vertical visible sidebar menu left">
	@include('nav')
</div>

{{-- Main View --}}
<div class="pusher" ui-view></div>

{{-- Scripts --}}
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.12.2/semantic.min.js"></script>
{{-- Angular JS --}}
<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.15/angular.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.14/angular-ui-router.min.js"></script>
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