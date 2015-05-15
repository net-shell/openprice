<?php namespace OpenPrice;

class Crawl extends Model {
	
	protected $fillable = ['initiator'];

	public function products() {
		return $this->hasMany('OpenPrice\Product', 'CRAWLS');
	}

	public function prices() {
		return $this->hasMany('OpenPrice\Price', 'FOUND');
	}

}