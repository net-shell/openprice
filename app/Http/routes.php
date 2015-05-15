<?php
namespace OpenPrice;

// Home
$router->get('/', 'HomeController@index');

// View Partials
$router->get('{partial}.html', function($partial) { return view('partials/' . $partial); });

// Models
$router->model('crawl', 'OpenPrice\Crawl');
$router->model('currency', 'OpenPrice\Currency');
$router->model('price', 'OpenPrice\Price');
$router->model('product', 'OpenPrice\Product');
$router->model('store', 'OpenPrice\Store');

// HTTP API
$router->group(['prefix' => 'api/v1', 'namespace' => 'API'], function()
{
	// Product
	$this->resource('product', 'Product');

	// Store
	$this->resource('store', 'Store');
	$this->get('store/{store}/products', 'Store@products');
});