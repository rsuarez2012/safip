<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class ContactReservation extends Model
{
    protected $table = "contact_reservation";
    
    public function reservation(){
        return $this->belongsTo(Reservation::class);
    }

    public function contact(){
        return $this->belongsTo(Contact::class);
    }
}
