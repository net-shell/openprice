<?php namespace OpenPrice\Http\Controllers\API;

use Illuminate\Http\Request;
use OpenPrice\Http\Controllers\Controller;
use OpenPrice\Price as Model;
use OpenPrice\Product as ProductModel;
use OpenPrice\Store as StoreModel;

class Price extends Controller
{
	public function anyIndex(Request $request)
	{
		$products = $request->input('products');
		$allPrices = [];
		foreach ($products as $productId) {
			$product = ProductModel::find($productId);
			var_dump($productId, $product);
			$prices = (new Product)->prices($product);
			$allPrices = array_merge($allPrices, $prices);
		}
		return $allPrices;
	}
}