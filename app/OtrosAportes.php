<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtrosAportes extends Model
{
    protected $table = 'otros_aportes';

	protected $fillable = ['nombre', 'monto'];
}
