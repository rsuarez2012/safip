<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FacturaC;

class FacturaCController extends Controller
{
    public function index(){
    	$lista=FacturaC::all();
    	return view('contabilidad.facturaCompra.index')->with('lista',$lista);
    } 

    public function guardar(Request $data){
    	$x=new FacturaC();
    	$x->emision= $data->emision;
    	$x->documento= $data->tipo;
    	$x->comp_pago_serie= $data->serie;
    	$x->comp_pago_numero= $data->numero;
    	$x->ruc= $data->ruc;
    	$x->nombre= $data->nombre;

        if($data->tipo=="NOTA CREDITO"){
            $cant= $data->nograbada;
            $cant="-".$cant;
            $x->adquis_no_grabada= $cant;

            $cant= $data->grabada;
            $cant="-".$cant;
            $x->adquis_grabada= $cant;
            
            $cant= $data->impuesto;
            $cant="-".$cant;
            $x->impuesto= $cant;
        
            $cant=($data->grabada + $data->nograbada + $data->impuesto);
            $cant="-".$cant;
            $x->importe_total= $cant;
        }else{
            $aux=($data->grabada + $data->nograbada + $data->impuesto);
            $x->importe_total= $aux;
            $x->adquis_no_grabada=$data->nograbada;
            $x->adquis_grabada= $data->grabada;
            $x->impuesto= $data->impuesto;
        }
    	$x->taza_cambio= $data->taza;
    	$x->save();
        
        return back();
    }

    public function formUpdate($id){
        $x=FacturaC::find($id);
        return view('contabilidad.facturaCompra.formulario')->with('registro',$x);
    }

     public function formSave(Request $data){
        $x=FacturaC::find($data->id);
        $x->emision= $data->emision;
        $x->documento= $data->tipo;
        $x->comp_pago_serie= $data->serie;
        $x->comp_pago_numero= $data->numero;
        $x->ruc= $data->ruc;
        $x->nombre= $data->nombre;
        $x->adquis_grabada= $data->grabada;
        $x->adquis_no_grabada= $data->nograbada;
        $x->impuesto= $data->impuesto;
        $aux=($data->grabada + $data->nograbada + $data->impuesto);
        $x->importe_total= $aux;
        $x->taza_cambio= $data->taza;
        $x->save();
        
        return redirect()->action('FacturaCController@index');
    }
    public function delete($id){
        $var = FacturaC::find($id);
        $var->delete();
        return back();
    }

    public function filtrar(Request $data){
        $x=FacturaC::whereMonth('emision', '=', $data->mes)->whereYear('emision', '=', $data->anio)->get();
        return view('contabilidad.facturaCompra.index')->with('lista',$x);
    }
}
