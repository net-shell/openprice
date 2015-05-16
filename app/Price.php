<?php namespace OpenPrice;

class Price extends Model {
	
	protected $fillable = ['value'];

	public $timestamps = false;
	
	public function getDates() {
		return ['stored_at'];
	}
	
	public static function boot()
	{
		parent::boot();

		static::creating(function($model) {
			$model->attributes['stored_at'] = time();
		});
	}

	public function product() {
		return $this->belongsTo('OpenPrice\Product', 'COSTS');
	}

	public function currency() {
		return $this->hasOne('OpenPrice\Currency', 'IN_CURRENCY');
	}
	
	public function crawl() {
		return $this->belongsTo('OpenPrice\Crawl', 'FOUND');
	}

}