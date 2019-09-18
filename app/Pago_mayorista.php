<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago_mayorista extends Model
{
    protected $table = 'pago_mayoristas';

	protected $fillable = ['nombre','pago','fecha','sucursal'];

}
