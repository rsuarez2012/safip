<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GananciaPerdida;
use App\VboletoP;
use App\Contabilidadopb;
use App\Otros_gastos;
use App\User;
use App\Sucursal;
use App\Mayorista;
use App\Pago_mayorista;
use App\Utilidad;
use App\Incentivo;
use Auth;


class GananciaPerdidaController extends Controller
{
    public function index(Request $data){
        $mes=$data->mes;
    	$anio=$data->anio;
        $boletos=VboletoP::whereMonth('created_at', '=', $data->mes)->whereYear('created_at', '=', $data->anio)->get();
    	
    	$contabilidad_opb=Contabilidadopb::whereMonth('fecha', '=', $data->mes)->whereYear('fecha', '=', $data->anio)->get();
    	
        $otros=Otros_gastos::whereMonth('fecha', '=', $data->mes)->whereYear('fecha', '=', $data->anio)->get();

    	$sucursales=Sucursal::all();

        $incentivo=Incentivo::all();

    	$vendedores=User::all();

    	$mayoristas=Mayorista::all();

        $utilidades=Utilidad::whereMonth('fecha', '=', $data->mes)->whereYear('fecha', '=', $data->anio)->get();

    	$pago_mayorista=Pago_mayorista::whereMonth('fecha', '=', $data->mes)->whereYear('fecha', '=', $data->anio)->get();
    	return view('contabilidad.GananciaPerdida.index',compact('vendedores','sucursales','boletos','mayoristas','pago_mayorista','utilidades','incentivo','contabilidad_opb','otros'))->with('mes',$mes)->with('anio',$anio);
    }
    public function auxiliar($mesa,$anioa){
        $mes=$mesa;
        $anio=$anioa;
        $boletos=VboletoP::whereMonth('created_at', '=', $mesa)->whereYear('created_at', '=', $anioa)->get();
        
        $contabilidad_opb=Contabilidadopb::whereMonth('fecha', '=', $mesa)->whereYear('fecha', '=', $anioa)->get();
        
        $otros=Otros_gastos::whereMonth('fecha', '=', $mesa)->whereYear('fecha', '=', $anioa)->get();

        $sucursales=Sucursal::all();

        $incentivo=Incentivo::all();

        $vendedores=User::all();

        $mayoristas=Mayorista::all();

        $utilidades=Utilidad::whereMonth('fecha', '=', $mesa)->whereYear('fecha', '=', $anioa)->get();

        $pago_mayorista=Pago_mayorista::whereMonth('fecha', '=', $mesa)->whereYear('fecha', '=', $anioa)->get();
        return view('contabilidad.GananciaPerdida.index',compact('vendedores','sucursales','boletos','mayoristas','pago_mayorista','utilidades','incentivo','contabilidad_opb','otros'))->with('mes',$mes)->with('anio',$anio);
    }
    public function mayorista(Request $data){
        $pago = new Pago_mayorista();
        $pago->mayorista=$data->mayorista;
        $pago->sucursal=$data->sucursal;
        $pago->pago=$data->pago;
        $pago->fecha=$data->fecha;
        $pago->save();
        
         return redirect()->Route('manageGananciaPerdida-actual-A',['mesa' => $data->mes, 'anioa' => $data->anio]);
    }
    public function taza(Request $data){
        $t= new Utilidad();
        $t->taza=$data->taza;
        $t->sucursal=$data->sucursal;
        $t->fecha=$data->fecha;
        $t->save();

         return redirect()->Route('manageGananciaPerdida-actual-A',['mesa' => $data->mes, 'anioa' => $data->anio]);
    }

    
}
