<?php namespace OpenPrice\Http\Controllers\API;

use Illuminate\Http\Request;
use OpenPrice\Http\Controllers\Controller;
use OpenPrice\Price as PriceModel;
use OpenPrice\Product as Model;
use OpenPrice\Store as StoreModel;

class Product extends Controller
{
	public function store(Request $request)
	{
		$url = $request->input('url');
		$parsed = parse_url($url);

		if(!$parsed || !array_key_exists('host', $parsed)) {
			return ['error' => 'Invalid URL'];
		}
		
		$domain = str_replace('www.', '', $parsed['host']);
		$store = StoreModel::whereDomain($domain)->first();
		
		if(!$store) {
			return ['error' => "$domain is not yet supported"];
		}
		
		if(Model::whereUrl($url)->first()) {
			return ['error' => "This product already exists"];
		}
		
		$model = Model::createWith(compact('url'), compact('store'));
		$success = $model->save();
		return compact('success');
	}

	public function show($model)
	{
		return $model->with('latestPrice')->find($model->id);
	}

	public function update(Model $model, Request $request)
	{
		$input = $request->only(['name', 'image']);
		$model->fill($input);
		if($request->has('price')) {
			$value = (float)$request->input('price');
			$priceModel = new PriceModel(compact('value'));
			$priceModel->save();
			$model->prices()->save($priceModel);
		}
		$success = $model->save();
		return compact('success');
	}

	public function prices(Model $model)
	{
		$prices = $model->prices()->select(['prices.stored_at', 'prices.value'])->orderBy('prices.stored_at', 'asc')->get()->toArray();
		$data = ['name' => $model->name, 'data' => []];
		foreach ($prices as $price) {
			$data['data'][] = [$price['prices.stored_at'] * 1000, $price['prices.value']];
		}
		return [$data];
	}
}