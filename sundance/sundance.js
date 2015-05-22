var express = require('express')
var fs = require('fs')
var request = require('request')
var cheerio = require('cheerio')
var app = express()

// benchmark
console.time('Scraped in');

var url = 'http://www.imdb.com/title/tt1229340/'

request(url, function(error, response, html){
	if(!error){
		var $ = cheerio.load(html);

		var json = { title: '', release: '', rating: '' }

		$('.header').filter(function(){
			var data = $(this);
			json.title = data.children().first().text();            
			json.release = data.children().last().children().text();
		})

		$('.star-box-giga-star').filter(function(){
			var data = $(this);
			json.rating = data.text();
		})
		console.log(json)

		// benchmark
		console.timeEnd('Scraped in')
	}
})

exports = module.exports = app