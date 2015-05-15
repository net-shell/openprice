<?php namespace OpenPrice;

class Currency extends Model {
	
	protected $fillable = ['code', 'format'];

	public function products() {
		return $this->belongsToMany('OpenPrice\Product');
	}

	public function prices() {
		return $this->belongsToMany('OpenPrice\Price');
	}

	public function convertsFrom() {
		return $this->belongsToMany('OpenPrice\CurrencyConversion', 'TO');
	}

	public function convertsTo() {
		return $this->hasMany('OpenPrice\CurrencyConversion', 'FROM');
	}

}