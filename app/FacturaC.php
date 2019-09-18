<?php
 

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class FacturaC extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'facturac';
    protected $fillable = [
        'emision','documento','comp_pago_serie',
        'comp_pago_numero','ruc','nombre',
        'adquis_grabada','adquis_no_grabada',
        'impuesto','importe_total','taza_cambio'
    ];

   
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
