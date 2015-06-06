// benchmark
console.time('Initialized in')

var fs = require('fs')
var request = require('request')
var cheerio = require('cheerio')

// benchmark
console.timeEnd('Initialized in')

// benchmark
console.time('>> (sc)raped in')

var url = 'http://www.imdb.com/title/tt1229340/'

console.time('>> response')
request(url, function(error, response, html){
	if(!error){
		console.timeEnd('>> response')
		console.time('>> parsed in')
		var $ = cheerio.load(html)

		var json = { title: '', release: '', rating: '' }

		// Parse
		$('.header').filter(function(){
			var data = $(this)
			json.title = data.children().first().text()
			json.release = data.children().last().children().text()
		})
		$('.star-box-giga-star').filter(function(){
			var data = $(this)
			json.rating = data.text()
		})

		console.log(json)

		// benchmark
		console.timeEnd('>> parsed in')
	}

	// benchmark
	console.timeEnd('>> (sc)raped in')
})
