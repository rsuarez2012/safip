<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aporte;
class AporteController extends Controller
{
    public function store(Request $data){
    	$created = new Aporte();
    	$created->nombre=strtoupper($data->nombre);
    	$created->aporte_obligatorio=$data->aporte_obligatorio;
    	$created->comision_ra=$data->comision_ra;
    	$created->prima_seguro=$data->prima_seguro;
    	$created->save();
    	return redirect()->route('manageNomina-A');
    }
    public function updated(Request $data){
    	$updated = Aporte::find($data->id);
    	$updated->nombre=strtoupper($data->nombre);
    	$updated->aporte_obligatorio=$data->aporte_obligatorio;
    	$updated->comision_ra=$data->comision_ra;
    	$updated->prima_seguro=$data->prima_seguro;
    	$updated->save();
    	return redirect()->route('manageNomina-A');
    }
}
