<?php namespace OpenPrice\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	public function boot()
	{
		//
	}

	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'OpenPrice\Services\Registrar'
		);

		$this->app->bind(
			'OpenPrice\Contracts\Model',
			'Vinelab\NeoEloquent\Eloquent\Model'
		);
	}

}
