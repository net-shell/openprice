<?php namespace OpenPrice\Http\Controllers\API;

use Illuminate\Http\Request;
use OpenPrice\Store as Model;
use OpenPrice\Product;
use OpenPrice\Http\Controllers\Controller;

class Store extends Controller
{
	public function products(Model $store, Request $request)
	{
		$args = $request->only('search');
		$q = $store->products()->with('latestPrice');
		if($args['search']) {
			$q = $q->where('products.name', $args['search']);
		}
		return $q->get();
	}

	public function getIndex()
	{
		return Model::all();
	}

	public function postIndex(Request $request, Model $model)
	{
		$model->fill($request->only(['name', 'domain']));
		$success = $model->save();
		return compact('success');
	}

}