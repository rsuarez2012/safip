<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaginaDestino extends Model
{
    protected $table = 'paginadestinos';
    protected $fillable = ['nombre', 'pais_id'];

    // HOTELES
    public function hoteles(){
    	return $this->hasMany('\App\Pagina\PaginaHotel','destino_id');
    }
    // LISTADOS
    public function listados(){
    	return $this->hasMany('\App\Pagina\PaginaDestinoPaquete','destino_id');
    }
    // PAIS
    public function pais(){
        return $this->belongsTo(Pais::class);
    }

    public function restaurantes()
    {
        return $this->hasMany(PaginaRestaurante::class, 'destino_id');
    }

    public function operadores()
    {
        return $this->hasMany('\App\Operador', 'destino_id');
    }
}
