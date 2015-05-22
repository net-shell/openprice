# OpenPrice

OpenPrice is a modern platform for financial data scraping (i.e. for the purposes of price comparison and analytics).
It utilizes cutting edge frameworks and approaches for best performance, security and looks.

## Data Scraping

### Client-side (Butch Cassidy)
`Cassidy` is an AngularJS service that we wrote to use for data scraping from a domain-based config.

#### Configuration
An example config entry looks like this:
```
myNgApp.constant('CassidiBlueprints', {
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
  }
});
```
There are two options when adding a new key for parsing. You either set its value to a string (jQuery selector) and the contained text will be returned, or you set it to an object with `selector` and `callback` keys. The callback is a function which is called for each selector match on every page and receives the jQuery element as the only argument. The  callback should return a string or a null value.

#### Usage
Once there is a config for a given domain you can scrape URLs from that domain. With AngularJS it's as simple as:
```
Cassidi.steal(url).then(function(swag){ console.log(swag.price); })
```

Of course, usually you'd want to run multiple (possibly hundreds or even thousands) of scrape operations in a non-UI-blocking manner. That is the purpose of the `queue` method:
```
Cassidi.queue([url1, url2, ...], function(swag){ console.log(swag.price); }, function(){ alert('All done!'); })
```
Cool, right? It's pretty self-explanatory, but for the sake of clarity:
* The first argument is an array of URLs.
* The second argument is an optional function which will be used as a `callback` for each processed URL.
* The third argument is an optional final callback, i.e. a simple function to be run when all URLs have been processed.

## Server-side (Sundance Kid)
`Sundance` is a lightweight NodeJS script that can run scraping queues on the server.
It's designed to be stackable and scalable.
(TODO: explain)

## Used Software
* Front-end
  * AngularJS
  * Semantic UI
  * jQuery
  * HighCharts/HighStock
* Back-end: Laravel 5
* Database: Neo4j
* Sundance: NodeJS
  * Express
  * Request
  * Cheerio