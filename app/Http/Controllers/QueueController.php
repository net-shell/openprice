<?php namespace OpenPrice\Http\Controllers;

class QueueController extends Controller {

	public function __construct()
	{
		// $this->middleware('auth_worker');
	}

	// Get products in a queue
	public function getIndex()
	{
		// if $queue not provided
		// return all products* not related*** to any queue
		// else return products* related to $queue
		// *products are limited to only those that don't have a recent** price
		// **recent is the found price TTL defined by the domain parser (defaults to 48, i.e. 8h.)
		// ***related means having a relation to the Queue with label :SUBSCRIBED that also has nil "lock" value

		/*
		MATCH (product:OpenPriceProduct)-[r:COSTS]->(price:OpenPricePrice)
		WHERE price.stored_at < TIMESTAMP()
		AND NOT ()-[:SCRAPES]->(product)
		RETURN DISTINCT product;

		TIMESTAMP() = time() - TTL * 60
		*/
	}

	// Lock a product while processing
	public function getLock($product, $queue)
	{
	}
}
