<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aporte extends Model
{
    protected $table = 'aportes';
    protected $fillable = [
        'nombre','aporte_obligatorio','comision_ra','prima_seguro'
    ];
}