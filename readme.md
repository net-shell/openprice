# OpenPrice

OpenPrice is a modern platform for financial data scraping (i.e. for the purposes of price comparison and analytics).
It utilizes cutting edge frameworks and approaches for best performance, security and looks.

## JS Data Scraping

This design approach allows for a broad range of processing units (pretty much anything from desktop browsers and VPS/cloud servers to mobile browsers and low-cost embedded servers) with virtually no limits to their number, concurrently scraping data for one hub (graph) database.

### Client-side (Butch Cassidy)
`Cassidy` is an AngularJS service for data scraping with a domain-based parser configuration (or `Blueprints`).

#### Configuration
An example config entry looks like this:
```
ngApp.constant('CassidiBlueprints', {
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
There are two options when adding a new key for parsing. You either set its value to a string (jQuery selector) in which case the contained text will be returned; or you set it to an object with `selector` and `callback` keys.
The callback is a function which is called for each selector match on every page and receives the jQuery element as the only argument. The callback must return a non-nil value for further processing or a 0-equiv value (false, null, etc.) in case of an error.

#### Usage

##### Single URL
Once there is a config for a given domain you can scrape URLs in it. With AngularJS it's as simple as:
```
Cassidi.steal(url).then(function(swag){ if(swag) console.log(swag.price); })
```
The `steal` method returns an Angular Promise which is later ("asynchronously") called. The closure for the promise receives an object as a sole argument which has the same keys as the parser for that domain. Each key is either a parse result value or `false`. In case all keys have failed to parse boolean `false` is passed instead of an object (so be sure to check for that).

##### (Client) Queue
However, usually you'd want to run multiple (possibly hundreds or even thousands) of scrape operations in a non-UI-blocking manner. That is the purpose of the `queue` method:
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

##### (Server) Queue
(TODO)

## Used Software
* Front-end
  * Semantic UI
  * HighCharts/HighStock
* Back-end: Laravel 5
* Database: Neo4j
* Cassidy: JavaScript 
  * jQuery
  * AngularJS
* Sundance: NodeJS
  * Express
  * Request
  * Cheerio