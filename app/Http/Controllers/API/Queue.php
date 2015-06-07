<?php namespace OpenPrice\Http\Controllers\API;

use Illuminate\Http\Request;
use OpenPrice\Http\Controllers\Controller;
use OpenPrice\Queue as QueueModel;
use OpenPrice\Product as ProductModel;
use OpenPrice\Price as PriceModel;

class Queue extends Controller {

	public function __construct(Request $request)
	{
		$this->request = $request;
		// $this->middleware('auth_worker');
	}

	// Get products in a queue
	public function getIndex()
	{
		$id = $this->request->input('id');
		$queue = QueueModel::find($id);

		if($queue) {
			// Get private queue
			$Q = ProductModel::whereHas('prices', function($q) {
					$q->where('stored_at', '<', time());
				})
				->whereHas('queues', function($q) use($id) {
					$q->find($id);
				})
				->distinct();
		}
		else {
			// Get unqueued
			$ttl = time() - 8 * 60 * 60;
			$Q = ProductModel::whereHas('prices', function($q) use ($ttl) {
					$q->where('stored_at', '<', $ttl);
				})
				->whereRaw('NOT ()-[:SCRAPES]->(openpriceproduct)', [1])
				->distinct();
		}

		return array_keys($Q->limit(6)->get()->groupBy('id')->toArray());

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
