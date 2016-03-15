# OpenPrice

OpenPrice is a modern platform for financial data scraping (i.e. for the purposes of price comparison and analytics).
It utilizes cutting edge frameworks and approaches for best performance, security and looks.

## JS Data Scraping

This design approach allows for a broad range of processing units (pretty much anything from desktop browsers and VPS/cloud servers to mobile browsers and low-cost embedded servers) with virtually no limits to their number, concurrently scraping data for one distributed graph database.

## The Stack
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
There are two options when adding a new key for parsing.

When the value is `string` it's treated as a DOM selector, in which case the contained text will be returned.

That is a shorthand, otherwise the value has to be an object with `selector`, and `callback` keys. The callback is a function which is called for each match on every page and receives the jQuery element as sole argument. The callback must return a non-nil value for further processing or nil in case of any error. Data accuracy depends on that of the callback error reporting.

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
It's pretty self-explanatory, but for the sake of clarity:
* The first argument is an array of URLs.
* The second argument is an optional function which will be used as a `callback` for each processed URL.
* The third argument is an optional final callback, i.e. a simple function to be run when all URLs have been processed.

Usually you'd want to fetch a few items from the Queue REST API (see below) and run them in the `queue` method while fetching the next items.

### Client-side (Butch Cassidy)
`Cassidy` is an AngularJS service for data scraping with a domain-based parser configuration (or `Blueprints`).

## Server-side (Sundance Kid)
`Sundance` is a lightweight NodeJS script that can run scraping queues on the server.
It's designed to be stackable and scalable.

##### (Server) Queue
The queue has a simple workflow. Using the REST API the typical worker scenario looks like this:

* `GET /api/v1/queue` returns a list of product IDs not related to recent (8h) prices and not related to a recently updated `:Promise`.
* `GET /api/v1/lock/{product}` assigns the given product a new `:Promise` and returns its id
* `POST /api/v1/lock/{promise}` adds the `value` parameter to the parent product's prices and deletes the promise on success (otherwise touches `updated_at`)

<img src="http://s27.postimg.org/wmjcshfyb/Screenshot_from_2015_06_06_23_36_59.png">
<img src="http://s27.postimg.org/xnf03v7k3/Screenshot_from_2015_06_06_23_41_34.png">
