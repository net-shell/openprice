<?php namespace OpenPrice;

class CurrencyConversion extends Model {
	
	protected $fillable = ['rate'];

	public function from() {
		return $this->belongsTo('OpenPrice\Currency', 'FROM');
	}

	public function to() {
		return $this->hasOne('OpenPrice\Currency', 'TO');
	}

}