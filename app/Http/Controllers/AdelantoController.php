<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adelanto;

class AdelantoController extends Controller
{
    public function store(Request $data){
    	$nuevo = new Adelanto();
    	$nuevo->monto=$data->monto;
    	$nuevo->fecha=$data->fecha;
    	$nuevo->empleado_id=$data->adelanto_id;
    	$nuevo->tipo=$data->tipo;
    	$nuevo->motivo=$data->motivo;
    	$nuevo->save();

    	return redirect()->route('manageNomina-A');
    }
}
