<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\Datoscargados;
use Auth;

class DatoscargadosController extends Controller
{
	 public function __construct() {
        $this->middleware('web');
    }

 public function store(Request $request){
 	$option=new Datoscargados();
 	$option->tipo_dato= $request->dato_nuevo;
 	$option->nombre_dato= $request->nombre_dato;
 	$option->save();
 	return back();
 }   
}
