<?php namespace OpenPrice;

class Product extends Model {
	
	protected $fillable = ['name', 'url'];

	public function store() {
		return $this->belongsTo('OpenPrice\Store', 'SELLS');
	}

	public function latestPrice() {
		return $this->hasOne('OpenPrice\Price', 'COSTS')->latest();
	}

	public function prices() {
		return $this->hasMany('OpenPrice\Price', 'COSTS');
	}

	public function crawl() {
		return $this->belongsTo('OpenPrice\Crawl', 'CRAWLS');
	}
}