<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\Inasistencia;
use Auth;

class InasistenciaController extends Controller
{
	 public function __construct() {
        $this->middleware('web');
    }

 public function store(Request $request){
 	//dd($request->all());
 	$reporte=new Inasistencia();
 	$reporte->fecha= $request->fecha;
 	$reporte->empleado_id= $request->inasistencia_id;
 	$reporte->motivo = $request->motivo;
 	$reporte->save();
 	return redirect()->route('manageNomina-A');
 }   
}
