<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Pais extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'paises';
    protected $fillable = [
        'id','PaisCodigo','paisnombre','PaisContinente','PaisRegion',  'PaisArea', 'PaisIndependencia',
       'PaisPoblacion','PaisExpectativaDeVida','PaisProductoInternoBruto','PaisProductoInternoBrutoAntiguo', 'PaisNombreLocal',
        'PaisGobierno', 'PaisJefeDeEstado', 'PaisCapital', 'PaisCodigo2','created_at','users_id'
    ];
    
    public function cotizaciones(){
        return $this->belongsTo('App\Cotizacion');
    }

    public function destinos(){
        return $this->hasMany(App\Pagina\PaginaDestino::class);
    }

}
