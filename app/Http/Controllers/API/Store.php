<?php namespace OpenPrice\Http\Controllers\API;

use Illuminate\Http\Request;
use OpenPrice\Store as Model;
use OpenPrice\Product;
use OpenPrice\Http\Controllers\Controller;

class Store extends Controller
{
	// Relationships
	public function products(Model $store)
	{
		return $store->products()->with('latestPrice')->get();
	}

	// Resource
	public function index()
	{
		return Model::all();
	}

	public function store(Request $request, Model $model)
	{
		$model->fill($request->only(['name', 'domain']));
		$success = $model->save();
		return compact('success');
	}

}