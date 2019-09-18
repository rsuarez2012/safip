<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
class Product extends Model
{

	use Sluggable;
	use SluggableScopeHelpers;

	protected $table = 'products';

	protected $fillable = ['name','description','destination_id',
        'typeservice_id','duration','slug','price_dolar',
        'extract', 'price_sol','quantity','visible','outstanding', 'category_id', 'visible', 'image'];


    public function destination(){
        return $this->belongsTo('App\Destination');
    }
    public function categories(){
        return $this->belongsTo('App\Category');
    }
    public function typeservice(){
        return $this->belongsTo('App\Typeservice');
    }
	public function order_item(){
		return $this->hasOne('App\OrderItem');
	}
	public function scopeCreated($query){
		return $query->orderBy('created_at', 'ASC');
	}
	public function scopePaginate($query){
		return $query->orderBy('id', 'ASC')->paginate(5);
	}

	public function sluggable(){
		return [
			'slug' => [
				'source' => 'name'
			]
		];
	}

}
