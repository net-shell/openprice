# OpenPrice

OpenPrice is a modern tool for financial data scraping (i.e. price comparison).
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
So, basically you have two options when adding a new key to be parsed. You either set its value to a string [jQuery] selector and the contained text will be returned, or you set it to an object with `selector` and `callback` keys. The latter is a callback which is passed each element (as a jQuery object) matching the selector. The callback should then return the string of interest.

#### Usage
Once there is a config for a domain the data can be scraped. It couldn't be simpler:
```
Cassidi.steal(url).then(function(swag){ console.log(swag.price); });
```

Of course, usually you'd want to run multiple (possibly hundreds or even thousands) of scrape operations in a non-UI-blocking manner. It is just as simple to do it, as scraping a single URL:
```
Cassidi.queue([url1, url2], function(swag){ console.log(swag.price); }, function(){ alert('Done'); });
```
Cool, right? It's pretty self-explanatory, but for the sake of clarity:
The first argument is an array of URLs. The second is an optional function which will be used as a callback for each processed URL.
The third argument is an optional final callback, i.e. a simple function to be run when all URLs have been processed.

## Server-side (Sundance Kid)
`Sundance` is a lightweight Lumen piece of code that runs scraping queues in a cloud or shared environment. It's designed to be stackable and scalable.
It's not yet ready.
(TODO)

## Used Software
* AngularJS
* Semantic UI
* jQuery
* HighCharts/HighStock
* Neo4j
* Laravel 5
* Lumen
