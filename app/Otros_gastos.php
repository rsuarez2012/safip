<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Otros_gastos extends Model
{
    protected $table = 'otros_gastos';

	protected $fillable = ['tipo', 'monto', 'sucursal', 'fecha','impuesto'];

	
}
