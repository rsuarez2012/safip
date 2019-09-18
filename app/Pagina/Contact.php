<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
      'people_id', 'email', 'phone'
    ];

    public function people(){
      return $this->belongsTo(People::class);
    }

    public function reservations(){
      return $this->belongsToMany(Reservation::class);
    }
}
