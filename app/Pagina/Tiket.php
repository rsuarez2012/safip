<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $fillable = [
        'reservation_id', 'people_id', 'type', 'nacionality',
        'neto',
    ];

    public function reservation(){
    	return $this->belongsTo(Reservation::class);
    }

    public function people(){
    	return $this->belongsTo(People::class);
    }
}
