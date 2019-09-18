<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FacturaV;

class FacturaVController extends Controller
{
    public function index(){
    	$x= FacturaV::all();
    	return view('contabilidad.facturaVenta.index')->with('lista',$x);
    } 
    public function guardar(Request $data){
    	$x=new FacturaV();
    	$x->fecha=$data->fecha;
    	$x->factura=$data->factura;
    	$x->ruc=$data->ruc;
    	$x->usuario=$data->usuario;
    	$x->monto=$data->monto;
    	$x->igv=$data->igv;
        $aux=($data->monto+$data->igv);
    	$x->total=$aux;
        $x->serie=$data->serie;
    	$x->taza_cambio=$data->taza_cambio;
    	$x->save();

    	return back();
    }
    public function formUpdate($id){
    	$x=FacturaV::find($id);
    	return view('contabilidad.facturaVenta.formulario')->with('registro',$x);
    }
    public function formSave(Request $data){
        $x=FacturaV::find($data->id);
        $x->fecha=$data->fecha;
        $x->factura=$data->factura;
        $x->ruc=$data->ruc;
        $x->usuario=$data->usuario;
        $x->monto=$data->monto;
        $x->igv=$data->igv;
        $aux=($data->monto+$data->igv);
        $x->total=$aux;
        $x->taza_cambio=$data->taza_cambio;
        $x->save();

         return redirect()->action('FacturaVController@index');
    }
      public function delete($id){
        $var = FacturaV::find($id);
        $var->delete();
       return back();
    }
    public function filtrar(Request $data){
        $x=FacturaV::whereMonth('fecha', '=', $data->mes)->whereYear('fecha', '=', $data->anio)->get();
        return view('contabilidad.facturaVenta.index')->with('lista',$x);
    }
}
