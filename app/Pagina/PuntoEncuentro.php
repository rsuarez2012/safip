<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PuntoEncuentro extends Model
{
    protected $table = 'punto_encuentros';
    protected $fillable = ['nombre','latitud','longitud','salida_id'];
    //SALIDAS
    public function salida(){
    	return $this->belongsTo('\App\Pagina\SalidaConfirmada','salida_id');
    }
}
