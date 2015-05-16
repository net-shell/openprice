var app = angular.module('OpenPrice', ['restangular', 'ui.router', 'highcharts-ng']);

// Configuration
app.config(function($stateProvider, $urlRouterProvider, $locationProvider, $httpProvider) {
	$urlRouterProvider.otherwise('/')
	$stateProvider
		.state('home', {
			url: '/',
			templateUrl: 'home.html',
		})
		.state('me', {
			url: 'me',
			templateUrl: 'me.html',
		})
	$httpProvider.interceptors.push('uiInterceptor');
})

// Initial work
app.run(function(Cassidi, $rootScope) {
	Cassidi.steal('http://www.randomhaiku.com')
		.then(function(swag){ $rootScope.haiku = swag.haiku })
})

// OpenPrice API
app.factory('API', function(Restangular) {
	return Restangular.setBaseUrl('api/v1')
})

// Blueprints for data shmekeri
app.constant('CassidiBlueprints', {
	'olx.bg': {
		price: {
			selector: '.pricelabel:first',
			callback: function(e){ return parseFloat(e.text()) }
		},
		name: 'h1.brkword',
		image: {
			selector: '.firstimage .bigImage',
			callback: function(e){ return e.attr('src') }
		}
	},
	'amazon.com': {
		price: {
			selector: '#priceblock_ourprice',
			callback: function(e){ return parseFloat(e.text().replace(/[^\d.]/g, '')) }
		},
		name: '#productTitle',
		image: {
			selector: '#landingImage',
			callback: function(e){ return e.attr('src') }
		}
	},
	'ebay.com': {
		price: {
			selector: '#prcIsum',
			callback: function(e){ return parseFloat(e.text().replace(/[^\d.]/g, '')) }
		},
		name: '#itemTitle',
		image: {
			selector: '#icImg',
			callback: function(e){ return e.attr('src') }
		}
	},
	'randomhaiku.com': { haiku: '.line' }
})

// 
app.factory('Charts', function($http) {
})

// Butch Cassidy
app.factory('Cassidi', function($http, CassidiBlueprints, UTF8) {
	var me = {
		queue: function(list, callback, finalCb) {
			me.queue = list
			return me._runQueue(callback, finalCb)
		},
		_runQueue: function(callback, finalCb) {
			if(!me.queue[0].url) {
				me.queue.shift()
				if(me.queue.length) return me._runQueue(callback, finalCb)
			}
			var robbery = me.steal(me.queue[0].url)
			if(!robbery) return
			return robbery.then(function(S){
				callback(S, me.queue[0])
				me.queue.shift()
				if(!me.queue.length && typeof finalCb == 'function') finalCb()
				if(me.queue.length) me._runQueue(callback, finalCb)
			}, function(error) {
				console.error('BC ran into the HTTPolice', error)
				me.queue.shift()
				if(!me.queue.length && typeof finalCb == 'function') finalCb()
				if(me.queue.length) me._runQueue(callback, finalCb)
			})
		},
		steal: function(url, $q) {
			if(!url) return
			
			var parsed = document.createElement('a')
			parsed.href = url
			var domain = parsed.hostname.replace('www.', '')

			if(!CassidiBlueprints[domain]) return console.error('BC doesnt have the blueprints for ' + domain)
			var swag = CassidiBlueprints[domain]

			ourl = 'http://anyorigin.com/get?url=' + encodeURIComponent(url) + '&callback=JSON_CALLBACK'
			//
			console.info('BC penetrates '+url)
			var config = { headers: { 'Content-Type': 'application/json; charset=utf-8' } }
			return $http.jsonp(ourl, config).then(function(response) {
				if(response && response.data) {
					//
					console.info('BC left '+url+' like a boss')
					var html = response.data.contents
					var parsed = {}
					for(var s in swag) {
						var selector = swag[s].selector ? swag[s].selector : swag[s]
						var matched = $(html).find(selector)
						var val = matched.length ? [] : false
						var valCb = swag[s].callback ? swag[s].callback : function(e){ return e.text().trim() }
						if(matched.length) {
							matched.each(function(){
								var V = valCb($(this)) // call user function on collection
								if(typeof V == 'string') V = UTF8.decode(V)
								val.push(V)
							})
							if(val.length == 1) val = val[0]
						}
						if(val) parsed[s] = val
					}
					if(!Object.keys(parsed).length) parsed = false
					//
					if(parsed) console.info('BC snitched some swag!', parsed)
					else console.error('BC fucked up with '+url, swag)
					return parsed;
				}
				//
				else console.error('BC fucked up BAD with '+url)
			}) // end jsonp callback
		} // end steal()
	}
	return me
})

// Unicode support
app.constant('UTF8', {
	decode: function(str_data) {
		var tmp_arr = [], i = 0, ac = 0, c1 = 0, c2 = 0, c3 = 0, c4 = 0;
		str_data += '';
		while (i < str_data.length) {
			c1 = str_data.charCodeAt(i);
			if (c1 <= 191) {
				tmp_arr[ac++] = String.fromCharCode(c1);
				i++;
			} else if (c1 <= 223) {
				c2 = str_data.charCodeAt(i + 1);
				tmp_arr[ac++] = String.fromCharCode(((c1 & 31) << 6) | (c2 & 63));
				i += 2;
			} else if (c1 <= 239) {
				// http://en.wikipedia.org/wiki/UTF-8#Codepage_layout
				c2 = str_data.charCodeAt(i + 1);
				c3 = str_data.charCodeAt(i + 2);
				tmp_arr[ac++] = String.fromCharCode(((c1 & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
				i += 3;
			} else {
				c2 = str_data.charCodeAt(i + 1);
				c3 = str_data.charCodeAt(i + 2);
				c4 = str_data.charCodeAt(i + 3);
				c1 = ((c1 & 7) << 18) | ((c2 & 63) << 12) | ((c3 & 63) << 6) | (c4 & 63);
				c1 -= 0x10000;
				tmp_arr[ac++] = String.fromCharCode(0xD800 | ((c1 >> 10) & 0x3FF));
				tmp_arr[ac++] = String.fromCharCode(0xDC00 | (c1 & 0x3FF));
				i += 4;
			}
		}
		return tmp_arr.join('');
	},
	encode: function(argString) {
		if (argString === null || typeof argString === 'undefined') return '';
		var string = (argString + '');
		var utftext = '', start, end, stringl = 0;
		start = end = 0;
		stringl = string.length;
		for(var n = 0; n < stringl; n++) {
			var c1 = string.charCodeAt(n);
			var enc = null;
			if(c1 < 128) {
				end++;
			} else if(c1 > 127 && c1 < 2048) {
				enc = String.fromCharCode(
					(c1 >> 6) | 192, (c1 & 63) | 128
				);
			} else if((c1 & 0xF800) != 0xD800) {
				enc = String.fromCharCode(
					(c1 >> 12) | 224, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
				);
			} else { // surrogate pairs
				if ((c1 & 0xFC00) != 0xD800) {
					throw new RangeError('Unmatched trail surrogate at ' + n);
				}
				var c2 = string.charCodeAt(++n);
				if ((c2 & 0xFC00) != 0xDC00) {
					throw new RangeError('Unmatched lead surrogate at ' + (n - 1));
				}
				c1 = ((c1 & 0x3FF) << 10) + (c2 & 0x3FF) + 0x10000;
				enc = String.fromCharCode(
					(c1 >> 18) | 240, ((c1 >> 12) & 63) | 128, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
				);
			}
			if (enc !== null) {
				if (end > start) {
					utftext += string.slice(start, end);
				}
				utftext += enc;
				start = end = n + 1;
			}
		}
		if(end > start) utftext += string.slice(start, stringl);
		return utftext;
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