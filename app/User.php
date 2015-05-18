<?php namespace OpenPrice;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract {

	use Authenticatable;

	protected $guarded = ['id', 'remember_token'];

	protected $hidden = ['password', 'remember_token'];

	public function stores() {
		return $this->hasMany('OpenPrice\Store', 'OWNS');
	}
}
