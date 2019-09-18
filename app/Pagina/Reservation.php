<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
    	'code', 'codigo_referencia', 'status',
        'included', 'codigo_hoteles', 'total',
        'user_web_id', 'paquete_id', 'tipo_pago',
        'status_pago', 'posible_fecha_sal',
    ];

    public function user(){
    	return $this->belongsTo(User::class, 'user_web_id');
    }

    public function paquete(){
    	return $this->belongsTo('\App\Pagina\PaginaPaquete','paquete_id');
    }

    public function contacts(){
      return $this->belongsToMany(Contact::class);
    }

    public function contactos(){
      return $this->hasMany(ContactReservation::class);
    }

    public function tikets(){
    	return $this->hasMany(Tiket::class);
    }
}
