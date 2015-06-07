<?php namespace OpenPrice;

class Queue extends Model {
	
	protected $fillable = ['name'];

	public function products() {
		return $this->hasMany('OpenPrice\Product', 'SCRAPES');
	}

	public function prices($morph = null) {
		return $this->hyperMorph($morph, 'OpenPrice\Product', 'SCRAPES', 'COSTS');
	}

}