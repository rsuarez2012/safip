<?php

namespace App\Http\Controllers\Pagina;

use Auth;
use App\Tpago;
use App\User;
use App\Aviaje;
use App\Consolidador;
use App\Pagina\OtroVenta;
use App\Pagina\PaqueteVenta;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;

class BoletoPaquetesController extends Controller
{
    public function getBoletos(Request $request){
        if (isset($request->tipo)) {

            $boletos1 = PaqueteVenta::where('id',"like","%".$request->search."%")
                                    ->orwhere('cotizacion_id',"like","%".$request->search."%")
                                    ->orderBy('id', 'DESC')
                                    ->with('cliente','cotizacion.agencia','vendedor','otro','qantu')
                                    ->get();
            $boletos2 = $boletos1->has($request->tipo)
                                ->paginate($request->sort);
            dd($boletos1);
            dd($boletos2);
            // dd($boletos);                        
            if (Auth::User()->role == 'Administrador') {
                $boletos = PaqueteVenta::orderBy('id', 'DESC')
                                    ->whereHas($request->tipo)
                                    ->whereBetween('fecha', [$request->fecha_inicial, $request->fecha_final])
                                    ->where('estado','!=','Anulado')
                                    ->get();                                        
            } else {
                $boletos = PaqueteVenta::orderBy('id', 'DESC')
                                    ->where('user_id',Auth::User()->id)
                                    ->whereHas($request->tipo)
                                    ->whereBetween('fecha', [$request->fecha_inicial, $request->fecha_final])
                                    ->where('estado','!=','Anulado')
                                    ->get();
            }
            
            /*filtro por search */
            if ($request->search != null || $request->search != '') {
                foreach ($boletos as $index => $boleto) { // Iteramos la collecion
                    $request->search = strtolower($request->search); // pasamos a minus el search
                    if (substr_count($boleto->id,$request->search) == 0 
                        && substr_count($boleto->cotizacion_id,$request->search) == 0
                                && substr_count(strtolower($boleto->cliente->nombre),$request->search) == 0
                                    && substr_count(strtolower($boleto->cliente->apellido),$request->search) == 0
                                        && substr_count(strtolower($boleto->cotizacion->agencia->nombre) ,$request->search) == 0
                    ){
                        $boletos->pull($index);  
                    }
                }
            }
            
            /*filtro por consolidadores */
            if ($request->consolidadores != null || $request->consolidadores != '') {
                $lista_consolidadores = explode(",",$request->consolidadores);
                foreach ($boletos as $index => $boleto) {
                    if ($boleto->has('otro')) {
                        if (!in_array($boleto->otro->proveedor_id,$lista_consolidadores)) {
                            $boletos->pull($index);  
                        }
                    }
                }
            }
            /*filtro por agencias */
            if ($request->agencias != null || $request->agencias != '') {
                $lista_agencias = explode(",",$request->agencias);
                foreach ($boletos as $index => $boleto) {
                    if ($boleto->has('otro')) {
                        if (!in_array($boleto->cotizacion->agencia_id,$lista_agencias)) {
                            $boletos->pull($index);  
                        }
                    }
                }
            }
            /*filtro por vendedores */
            if ($request->vendedores != null || $request->vendedores != '') {
                $lista_vendedores = explode(",",$request->vendedores);
                foreach ($boletos as $index => $boleto) {
                    if ($boleto->has('otro')) {
                        if (!in_array($boleto->user_id,$lista_vendedores)) {
                            $boletos->pull($index);  
                        }
                    }
                }
            }
            /*filtro por vendedores */
            if ($request->vendedores != null || $request->vendedores != '') {
                $lista_vendedores = explode(",",$request->vendedores);
                foreach ($boletos as $index => $boleto) {
                    if ($boleto->has('otro')) {
                        if (!in_array($boleto->user_id,$lista_vendedores)) {
                            $boletos->pull($index);  
                        }
                    }
                }
            }
            /* filtro por agencia */
            if ($request->tipo_venta != null || $request->tipo_venta != '') {
                foreach ($boletos as $index => $boleto) {
                    if ($boleto->has('otro')) {
                        if ($boleto->otro->tipo != $request->tipo_venta) {
                            $boletos->pull($index);  
                        }
                    }
                }
            }
            /* rescato boletos filtrados */
            $boletos = PaqueteVenta::whereIn('id',$boletos->pluck("id"))
            ->whereHas('cliente',function($query) use ($request){
                $query->where('nombre','like',"%$request->cliente%")->orWhere('apellido','like',"%$request->cliente%");
            })
            ->with('abonos','cliente','cotizacion.agencia','vendedor',$request->tipo.'.consolidador')
            ->paginate($request->sort);
            return [
                'pagination' => [
                    'total'         => $boletos2->total(),
                    'current_page'  => $boletos2->currentPage(),
                    'per_page'      => $boletos2->perPage(),
                    'last_page'     => $boletos2->lastPage(),
                    'from'          => $boletos2->firstItem(),
                    'to'            => $boletos2->lastItem(),
                ],
                'registros' => $boletos,
                'fecha_inicial' => $request->fecha_inicial,
                'fecha_final' => $request->fecha_final,  
                'rol' => Auth::User()->role
            ];
        }
    }
    public function getAgencias(){
        return Aviaje::all();
    }
    public function getConsolidadores(){
        return Consolidador::all();
    }
    public function getVendedores(){
        return User::all();
    }
    public function getTipoPagos(){
        return Tpago::all();
    }
    public function editBoletos(Request $request){
        $boleto = PaqueteVenta::findOrFail($request->boleto['id']);
        $boleto->update($request->boleto);
        if (isset($request->boleto['otro'])) {
           
            //veo si el id cambio
            if ($request->boleto['otro']['proveedor_id'] != $boleto->otro->proveedor_id) {
                $boleto->otro->delete();
                $nuevo_consolidador = OtroVenta::create($request->boleto['otro']);
            }
        }elseif (isset($request->boleto['qantu'])){
            if ($request->boleto['qantu']['proveedor_id'] != $boleto->qantu->proveedor_id) {
                $boleto->qantu->delete();
                $nuevo_consolidador = QantuVenta::create($request->boleto['qantu']);
            }
        }
        $boleto->update_by = Auth::User()->nombres . " " . Auth::User()->apellidos; 
        $boleto->update();
        return ;
    }
    public function anularBoletos(PaqueteVenta $boleto){
        $boleto->estado = "Anulado";
        $boleto->update_by = Auth::User()->nombres . " " . Auth::User()->apellidos;
        $boleto->update();
        return ;
    }
    public function imprimirBoletos(PaqueteVenta $boleto){
        $pdf = PDF::loadView('adminweb.paquetes.ventas.fragmentos.boleto_pdf',compact('boleto'));
        return $pdf->download('boleto'.$boleto->id.'.pdf');
    }
}
