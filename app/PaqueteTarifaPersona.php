<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaqueteTarifaPersona extends Model
{
    protected $table = 'paquete_tarifa_personas';

	protected $fillable = ['hotel','star','categoria','e_swb','e_dwb','e_chd','e_tpl','p_swb','p_dwb','p_tpl','p_chd','check_in','check_out'];
}
