<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class SalidaConfirmada extends Model
{
    protected $table    = 'salidaconfirmadas';
    protected $fillable = ['fecha_salida','fecha_llegada','cupos','paquete_id'];

    public function paquete(){
        return $this->belongsTo('\App\Pagina\PaginaPaquete','paquete_id');
    }
    public function punto(){
        return $this->hasOne('\App\Pagina\PuntoEncuentro','salida_id');
    }
}
