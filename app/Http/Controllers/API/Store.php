<?php namespace OpenPrice\Http\Controllers\API;

use Illuminate\Http\Request;
use OpenPrice\Store as Model;
use OpenPrice\Product;
use OpenPrice\Http\Controllers\Controller;

class Store extends Controller
{
	public function products(Model $store, Request $request)
	{
		$search = $request->input('search');
		$q = $store->products()->with('latestPrice');
		if($search) {
			$search = trim($search);
			if(strlen($search)) {
				$search = str_replace('/', '\/', $search);
				$search = preg_replace('/\s+/', ' ', $search);
				$search = str_replace(' ', '.*', $search);
				$search = '(?i).*' . $search . '.*';
				$q = $q->where('products.name', '=~', $search);
			}
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