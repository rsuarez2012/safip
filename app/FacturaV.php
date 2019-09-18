<?php
 

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class FacturaV extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'facturav';
    protected $fillable = [
        'fecha','factura','ruc',
        'usuario','monto','igv',
        'total','taza_cambio','serie'
    ];

   
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
