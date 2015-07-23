<?php

// Welcome
Route::get('/welcome', function(){ return view('welcome'); });

// Authentication
Route::controller('auth', 'Auth\AuthController');

// View Partials
Route::get('{partial}.html', function($partial) { return view('partials/' . $partial); });

// Models
Route::model('crawl', 'OpenPrice\Crawl');
Route::model('currency', 'OpenPrice\Currency');
Route::model('price', 'OpenPrice\Price');
Route::model('product', 'OpenPrice\Product');
Route::model('store', 'OpenPrice\Store');
Route::model('user', 'OpenPrice\User');

// HTTP API
Route::group(['prefix' => 'api/v1', 'namespace' => 'API'], function()
{
	// Price
	Route::controller('price', 'Price');

	// Product
	Route::resource('product', 'Product');
	Route::get('product/{product}/prices', 'Product@prices');

	// Store
	Route::any('store/{store}/products', 'Store@products');
	Route::controller('store', 'Store');

	// Queue
	Route::controller('queue', 'Queue');

	// User
	Route::controller('user/{user}', 'User');
});


// Home
Route::get('/', 'HomeController@index');