<?php namespace OpenPrice\Http\Controllers\API;

use Illuminate\Http\Request;
use OpenPrice\Http\Controllers\Controller;
use OpenPrice\User as Model;
use OpenPrice\Product as ProductModel;
use OpenPrice\Store as StoreModel;

class User extends Controller
{
	public function getIndex(Model $user)
	{
		return $user;
	}

	public function getStores(Model $user)
	{
		return $user->stores;
	}

	public function getProducts(Model $user)
	{
		return $user->stores()->with('products')->get();
	}
}