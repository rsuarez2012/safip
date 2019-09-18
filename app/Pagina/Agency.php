<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    //protected $table ='agencies';
    protected $fillable = [
    	'business_name', 'legal_representative', 'district', 'website', 'date', 'corporate_phone', 'user_phone', 'status', 'user_web_id','message'
    ];

    public function user(){
      return $this->belongsTo(User::class,'user_web_id');
    }
}