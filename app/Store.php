<?php namespace OpenPrice;

class Store extends Model {
	
	protected $fillable = ['name', 'domain'];

	public function products() {
		return $this->hasMany('OpenPrice\Product', 'SELLS');
	}
	
	public function users() {
		return $this->belongsTo('OpenPrice\User', 'OWNS');
	}

}