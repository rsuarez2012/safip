<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class VboletoP extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'venta_boletos_pasajeros';
    protected $fillable = [
        'id',
        'doc_cobranza',
        'venta_boletos_id',
        'codigo',
        'cliente_id',
        'nombre_cliente',
        'laereas_id',
        'ruta',
        'nro_ticket',
        'consolidadores_id',
        'aviajes',
        'agentes_id',
        'neto',
        'tarifa',
        'comision_agencia',
        'ivg',
        'total',
        'pago_consolidador',
        'tarifa_fee',
        'utilidad',
        'incentivo',
        'comision',
        'anulado',
        'pagado',
        'nro_operacion',
        'created_at',
        'updated_at',
        'users_id',
        'updated_by',
        'original_date'
    ];
    public static function created($date)
    {
      $date = explode('-', $date);

      $dayTime = explode(' ', $date[2]);

      return $dayTime[0]."/".$date[1]."/".$date[0];
    }

    public function laereas(){
        return $this->belongsTo('App\Laerea');
    }

    public function cotizaciones(){
        return $this->belongsto('App\Cotizacion');
    }

    public function consolidadores(){
        return $this->belongsto('App\Consolidador');
    }
    public function users(){
        return $this->belongsTo('App\User');
    }

    public function tipop(){
        return $this->belongsto('App\Tpago', 'tipo_pago');
    }


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
