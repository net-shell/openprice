var app = angular.module('OpenPrice', ['restangular', 'ui.router']);

// Configuration
app.config(function($stateProvider, $urlRouterProvider, $locationProvider, $httpProvider) {
	$urlRouterProvider.otherwise('/')
	$stateProvider
		.state('home', {
			url: '/',
			templateUrl: 'home.html',
		})
	$httpProvider.interceptors.push('uiInterceptor');
})

// Initial work
app.run(function(Cassidi, $rootScope) {
	Cassidi.steal('http://www.randomhaiku.com/', { haiku: '.line' })
		.then(function(swag){ $rootScope.haiku = swag.haiku })
})

// OpenPrice API
app.factory('API', function(Restangular) {
	return Restangular.setBaseUrl('api/v1')
})

// Butch Cassidy
app.factory('Cassidi', function($http) {
	return {
		steal: function(url, swag) {
			if(!url) return
			ourl = 'http://anyorigin.com/get?url=' + encodeURIComponent(url) + '&callback=JSON_CALLBACK'
			//
			console.log('BC penetrates '+url)
			var config = {}
			return $http.jsonp(ourl, config).then(function(response) {
				if(response && response.data) {
					//
					console.log('BC left '+url+' like a boss')
					var html = response.data.contents
					var parsed = {}
					for(var s in swag) {
						var matched = $(html).find(swag[s].selector ? swag[s].selector : swag[s])
						var val = matched.length ? [] : false
						var valCb = swag[s].callback ? swag[s].callback : function(e){ return e.text().trim() }
						if(matched.length) {
							matched.each(function(){ val.push( valCb($(this)) ); })
							if(val.length == 1) val = val[0]
						}
						if(val) parsed[s] = val
					}
					if(!Object.keys(parsed).length) parsed = false
					//
					if(parsed) console.log('BC snitched some swag!', parsed)
					else console.error('BC fucked up with '+url, swag)
					return parsed;
				}
				//
				else console.error('BC fucked up BAD with '+url)
			})
		}
	}
})

// Itercept HTTP traffic
app.factory('uiInterceptor', function($q, $rootScope) {
	return {
		'request': function(config) {
			$rootScope.error = false
			$rootScope.loading = true
			return config;
		},
		'response': function(response) {
			$rootScope.error = false
			$rootScope.loading = false
			return response;
		},
		'requestError': function(rejection) {
			$rootScope.error = true
			return response
		},
		'responseError': function(rejection) {
			$rootScope.error = true
			return rejection
		}
	}
});

// Date filter
app.filter('asDate', function() {
	return function(input) { return new Date(input) }
})