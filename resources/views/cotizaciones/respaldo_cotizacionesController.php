<?php

namespace App\Http\Controllers;

use Auth;
use App\Iva;
use App\Role;
use App\Pais;
use App\User;
use App\Banco;
use App\Tpago;
use App\Cobro;
use App\Agente;
use App\Laerea;
use App\Bancog;
use App\Aviaje;
use App\Ciudad;
use App\Empresa;
use App\Propago;
use App\Cliente;
use App\Comision;
use App\Sucursal;
use App\VboletoP;
use App\Cotizacion;
use App\Consolidador;
use App\DeuagenciaViajes;
use Illuminate\Http\Request;
use App\Pagina\PaginaDestino;
use App\DeupagoConsolidadores;
use App\Pagina\CotizacionPaquete;
use Yajra\Datatables\Facades\Datatables;

class CotizacionController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    // FUNCIONES CREADAS POR CESAR YANEZ
    public function getManageCotizacion(){
        $id =  Auth::User()->id;
        //dd(Auth::user());
        if(Auth::User()->role != "Administrador"){
            $cotizaciones = Cotizacion::where('users_id', Auth::id())
                                        ->where('anulado','!=','1')
                                        ->orderBy('created_at', 'desc')
                                        ->get();
        }else{
            $cotizaciones = Cotizacion::where('anulado','!=','1')
                                        ->orderBy('created_at', 'desc')
                                        ->get();
        }
        return view('cotizaciones.index');
    }

    public function getC_Boletos($limiter, $desde)
    {
        if(Auth::User()->role != "Administrador"){
            $c_boletos = Cotizacion::where('users_id', Auth::id())
                                        ->where('id', '<', $desde)
                                        ->where('anulado','!=','1')
                                        ->orderBy('id','desc')
                                        ->limit($limiter)
                                        ->get();
        }else{
            $c_boletos = Cotizacion::where('anulado','!=','1')
                                        ->where('id', '<', $desde)
                                        /* ->orderBy('created_at', 'desc') */
                                        ->orderBy('id','desc')
                                        ->limit($limiter)
                                        ->get();
        }
        $c_boletos->load('paises', 'aviajes', 'users');
        return $c_boletos;
    }

    public function getC_Paquetes()
    {
        $c_paquetes = CotizacionPaquete::orderBy('updated_at','DESC')->get();
        $c_paquetes->load('agencia', 'pais', 'destino', 'vendedor');
        return $c_paquetes;
    }

    public function get_data_edit_Cpaquete()
    {
        $paises       = Pais::all();
		$agencias     = Aviaje::all();
        $destinos     = PaginaDestino::all();
        $ciudades = Ciudad::orderBy('ciudadnombre')->get();
        return ['paises' => $paises, 'destinos' => $destinos, 'agencias' => $agencias, 'ciudades' => $ciudades];
    }

    public function update_Cpaquete(Request $data){
		$cotizacion = CotizacionPaquete::find($data->id_cotizacion);
		$cotizacion->agencia_id    = $data->agencia_id;
		$cotizacion->pais_id       = $data->pais_id;
		$cotizacion->destino_id    = $data->destino_id;
		$cotizacion->nacionalidad  = $data->nacionalidad;
		$cotizacion->fecha_salida  = $data->fecha_salida;
		$cotizacion->fecha_retorno = $data->fecha_retorno;
		$cotizacion->pasajero      = $data->cantidad;
		$cotizacion->nacionalidad  = $data->nacionalidad;
		if (!empty($data->observacion)) {
			$cotizacion->observacion   = $data->observacion;
		}else{
			$cotizacion->observacion   = "Sin Observaciones";
		}
		$cotizacion->user_id       = Auth::user()->id;
		$cotizacion->save();
		return;
	}

    // OTRAS FUNCIONES QUE NO SON HECHAS POR CESAR YANEZ

    public function create(){
        $agentes = Agente::all();
        $aviajes = Aviaje::where("status","!=","rechazado")->get();
        $paises = Pais::all();
        $empresas = Empresa::all();
        /*ciudad de salida*/
        $salidas = Ciudad::orderBy('ciudadnombre')->get();
        /*ciudad de salida*/
        $llegadas =  Ciudad::orderBy('ciudadnombre')->get();
        


        return view('cotizaciones.create', compact('numeradorsum','agentes','aviajes','paises','salidas','llegadas','empresas'));
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){


                $cotizacioness = new Cotizacion();
                $numerador = Cotizacion::max('count');
                $numeradorsum= $numerador + 1;
                $cotizacioness->count  = $numeradorsum;
                $cotizacioness->aviajes_id  = $request->aviaje;
                /* $cotizacioness->paises_id       = $request->pais; */
                $cotizacioness->d_ciudad_id     = $request->salida;
                $cotizacioness->h_ciudad_id  = $request->llegada;
                $cotizacioness->salida_at    = $request->csalida;
                $cotizacioness->llegada_at     = $request->cllegada;
                $cotizacioness->ida_vuelta     =  $request->tipo_recorrido;
                $cotizacioness->cantidad_pasajeros       = $request->cpasajero;
                $cotizacioness->status       = 0;
                $cotizacioness->observacion       = $request->observacion;
                $cotizacioness->users_id   = Auth::User()->id;
                $cotizacioness->save();

                //return view('welcome');
                $message = $cotizacioness ? 'Se ha registrado la cotizacion 000' . $numeradorsum .  ' de forma exitosa.' : 'Error al Registrar';

                //Session::flash('message', 'Te has registrado exitosamente ');
                return redirect()->route('manageCotizacion-A')->with('message', $message);



    }

    public function edit($id){

        $cotizaciones = Cotizacion::where('id','=', $id)->first();

        $agentes = Agente::all();
        $aviajes = Aviaje::all();
        $paises = Pais::all();
        $salidas = Ciudad::orderBy('ciudadnombre')->get();
        /*ciudad de salida*/
        $llegadas =  Ciudad::orderBy('ciudadnombre')->get();
        return view('cotizaciones.edit')
            ->with('cotizaciones', $cotizaciones)
            ->with('agentes', $agentes)
            ->with('aviajes', $aviajes)
            ->with('paises', $paises)
            ->with('salidas', $salidas)
            ->with('llegadas', $llegadas);
    }

    public function update_Cboleto(Request $request){
        $cotizacion = Cotizacion::find($request->id_cotizacion);
        $cotizacion->aviajes_id  = $request->aviaje;
        /* $cotizacion->paises_id       = $request->pais; */
        $cotizacion->d_ciudad_id     = $request->salida;
        $cotizacion->h_ciudad_id  = $request->llegada;
        $cotizacion->salida_at    = $request->csalida;
        $cotizacion->llegada_at     = $request->cllegada;
        $cotizacion->ida_vuelta     = $request->idavuelta;
        $cotizacion->cantidad_pasajeros       = $request->cpasajero;
        $cotizacion->observacion       = $request->observacion;
        $cotizacion->update();

        $cotizacion = Cotizacion::find($cotizacion->id);
        $cotizacion->load('paises', 'aviajes', 'users');
        return $cotizacion;
    }

    public function update_Cboletos_multi(Request $request){
        $cotizaciones = Cotizacion::find($request->cotizaciones);
        foreach($cotizaciones as $cotizacion){
            if($request->aviaje != 0){
                $cotizacion->aviajes_id  = $request->aviaje;
            }
            if($request->salida != ""){
                $cotizacion->d_ciudad_id     = $request->salida;
            }
            if($request->llegada != ""){
                $cotizacion->h_ciudad_id  = $request->llegada;
            }
            if($request->csalida != null){
                $cotizacion->salida_at    = $request->csalida;
            }
            if($request->cllegada != null){
                $cotizacion->llegada_at     = $request->cllegada;
            }
            $cotizacion->ida_vuelta     = $request->idavuelta;
            if($request->cpasajero != 0){
                $cotizacion->cantidad_pasajeros       = $request->cpasajero;
            }
            if($request->observacion != ''){
                $cotizacion->observacion       = $request->observacion;
            }
            /* return Response()->json([
                'cot' => $cotizacion,
                'req' => $request->all()
            ]); */
            $cotizacion->update();
        }
        $cotizaciones = Cotizacion::find($request->cotizaciones);
        $cotizaciones->load('paises', 'aviajes', 'users');
        return $cotizaciones;
    }

    public function status(Request $request, $id){

        $cotizacioness = User::where('id','=', $id)->first();
        if ($cotizacioness->active == '0'){
            $cotizacioness= cotizaciones::find($id);
            $cotizacioness = User::where('id','=', $id)->first();
            $cotizacioness->active   = "1";
            $cotizacioness->save();
            $message = $cotizacioness?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageCotizacion-A')->with('message', $message);
        }else {
            if ($cotizacioness->active == '1')
                $cotizacioness = User::find($id);
            $cotizacioness = User::where('id', '=', $id)->first();
            $cotizacioness->active = "0";
            $cotizacioness->save();
            $message = $cotizacioness ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageCotizacion-A')->with('message', $message);
        }
    }



    public function show($id){
        $cotizacioness = cotizaciones::all()->lists('name', 'id');

        return view('cotizaciones.show');

    }


    public function destroy($id){

        $cotizacioness = Cotizacion::find($id);
        $cotizacioness->delete($id);
        $message = $cotizacioness?'Registro eliminado correctamente' : 'Error al Eliminar';

            return redirect()->route('manageCotizacion-A')->with('message', $message);

    }
    public function anulado($count){

        $cotizacioness = Cotizacion::where('count',$count)->first();
            $cotizacioness->anulado = "1";
            $cotizacioness->save();



        $cotizacioness2 = DeuagenciaViajes::where('venta_boleto_id',$count)->get();
        if($cotizacioness2){
        for($i=0; $i<sizeof($cotizacioness2); $i++){
            $cotizacioness2[$i]->nro_ticket = NULL;
            $cotizacioness2[$i]->anulado = "1";
            $cotizacioness2[$i]->save();
        }
        }


        $cotizacioness3 = DeupagoConsolidadores::where('venta_boleto_id',$count)->get();
        if($cotizacioness3) {
            for ($i = 0; $i < sizeof($cotizacioness3); $i++) {
                $cotizacioness3[$i]->nro_ticket = NULL;
                $cotizacioness3[$i]->anulado = "1";
                $cotizacioness3[$i]->save();
            }
        }


        $cotizacioness4 = VboletoP::where('venta_boleto_id',$count)->get();
        if($cotizacioness4) {
            for ($i = 0; $i < sizeof($cotizacioness4); $i++) {
                $cotizacioness4[$i]->nro_ticket = NULL;
                $cotizacioness4[$i]->anulado = "1";
                $cotizacioness4[$i]->save();
            }
        }



       $message = $cotizacioness  ? 'Se Anulo la cotizacion y todo lo que de ella depende.' : 'Error al Anular';

        return redirect()->route('manageCotizacion-A')->with('message', $message);

    }
    
    public function procesar($id){
        $cotizacion = cotizacion::find($id);
        $agencia_viajes = Aviaje::find($cotizacion->aviajes_id);
        $consolidadores = Consolidador::all();
        $lineas_aereas = Laerea::all();
        $iva = Iva::all()->last();
        $tipo_pagos= Tpago::all();
        $bancos = Banco::all();
        $bancosg = Bancog::all();
        $empresas = Empresa::all();
        //dd($empresas,$bancos,$bancosg,$tipo_pagos,$cotizacion,$agencia_viajes,$consolidadores,$lineas_aereas,$iva);
        return view('cotizaciones.procesar', compact('empresas','bancos','bancosg','tipo_pagos','cotizacion','agencia_viajes','consolidadores','lineas_aereas','iva'));
    }
    

    public function temp(Request $request){
/*
        $request->agenciav;
        $request->pais;
        $request->dsalida;
        $request->dllegada;
        $request->vendedor;
        $request->csalida;
        $request->cllegada;
        $request->cantidadp;
        $request->consolidador;
        $request->laerea;
        $request->valoreninput;*/

        /*array*/

//dd($request->all());
         for($i=0; $i<sizeof($request->tikets); $i++){
             $separador = explode("Ç", $request->agenciav);
             $ventav = new VboletoP();
             $ventav->venta_boleto_id   = $request->numero;
             $ventav->nro_ticket        = str_replace(" ","", $request->tikets[$i] );
             $ventav->codigo            = $request->codigo;
             $ventav->cliente_id        = $request->cedula[$i];
             $ventav->nombre_cliente    = $request->usern[$i];
             $ventav->laereas_id        = $request->laerea;
             $ventav->ruta              = $request->csalida.$request->pais.$request->cllegada;
             $ventav->consolidadores_id = $request->consolidador;
             $ventav->aviajes           = $separador[1];
             $ventav->agentes_id        = $request->nagente;
             $ventav->neto              = $request->neto[$i];
             $ventav->tarifa            = $request->tarifa[$i];
             $ventav->comision_agencia  =$request->comi[$i];
             $ventav->igv               =$request->igv[$i];
             $ventav->total             =$request->total[$i];
             $ventav->pago_consolidador =$request->conso[$i];
             $ventav->tarifa_fee        =$request->tarifaf[$i];
             $ventav->utilidad          =$request->utilidad[$i];
             $ventav->incentivo         =$request->incentivo[$i];
             $j = 0;
             $ventav->monto = $request->montom[$j];
             $ventav->tipo_pago = $request->tipop[$j];
             $ventav->banco_emisor = $request->bancoe[$j];
             $ventav->banco_receptor = $request->bancor[$j];
             $ventav->nro_operacion = $request->dosnroperacion[$j];
             $ventav->abono = $request->mfacturar;
             $ventav->users_id  = Auth::User()->id;
             //sucursal
             $ventav->save();
             if($request->tipop[$j]=="EFECTIVO"){
                //HACER FUNCION
             }
         }
                $cotizacion = Cotizacion::where('count','=', $request->numero)->first();
                $cotizacion->status = "1";
                $cotizacion->save();


            for($j=0; $j<sizeof($request->montom); ++$j){
                $propago =  new Propago();
                $propago->cotizacion_id = $request->numero;
                $propago->monto = $request->montom[$j];
                $propago->tipo_pago = $request->tipop[$j];
                $propago->banco_e = $request->bancoe[$j];
                $propago->banco_r = $request->bancor[$j];
                $propago->numero_op = $request->dosnroperacion[$j];
                $propago->monto_f = $request->mfacturar;
                $propago->save();
                }

        for($i=0; $i<sizeof($request->tikets); $i++) {
            $separadorr = explode('Ç', $request->agenciav);
            $j = 0;
            if (!empty($request->tipop[$j])) {
                    if ($request->tipop[$j] == '7') {
                        $deuagenciav = new DeuagenciaViajes();
                        $deuagenciav->fecha =  date('Y-m-d');
                        $deuagenciav->venta_boleto_id = $request->numero;
                        $deuagenciav->nro_ticket = str_replace(" ","", $request->tikets[$i] );
                        $deuagenciav->dni_ruc = $request->cedula[$i];
                        $deuagenciav->nombre_cliente = $request->usern[$i];
                        $deuagenciav->laereas_id = $request->laerea;
                        $deuagenciav->ruta = $request->csalida . $request->pais . $request->cllegada;
                        $deuagenciav->consolidadores_id = $request->consolidador;
                        $deuagenciav->aviajes_id = $separadorr[1];
                        $deuagenciav->tarifa_fee = $request->tarifaf[$i];
                        $deuagenciav->porpagar = $request->tarifaf[$i];
                        $deuagenciav->agentes_id = $request->nagente;
                        $deuagenciav->diasc = $request->diasp;
                        $deuagenciav->status = 0;
                        $deuagenciav->save();
                    } else {
                        $deuagenciav = "true";
                    }

            }

        }
        for($i=0; $i<sizeof($request->tikets); $i++) {
            $separadorr = explode('Ç', $request->agenciav);
            $j = 0;
            if (!empty($request->tipop[$j])) {
                if ($request->tipop[$j] == '6') {
                    $deuagenciav2 = new DeuagenciaViajes();
                    $deuagenciav2->fecha =  date('Y-m-d');
                    $deuagenciav2->venta_boleto_id = $request->numero;
                    $deuagenciav2->nro_ticket = str_replace(" ","", $request->tikets[$i] );
                    $deuagenciav2->dni_ruc = $request->cedula[$i];
                    $deuagenciav2->nombre_cliente = $request->usern[$i];
                    $deuagenciav2->laereas_id = $request->laerea;
                    $deuagenciav2->ruta = $request->csalida . $request->pais . $request->cllegada;
                    $deuagenciav2->consolidadores_id = $request->consolidador;
                    $deuagenciav2->aviajes_id = $separadorr[1];
                    $deuagenciav2->tarifa_fee = $request->tarifaf[$i];
                    $deuagenciav2->porpagar = $request->tarifaf[$i];
                    $deuagenciav2->agentes_id = $request->nagente;
                    $deuagenciav2->diasc = $request->diasp;
                    $deuagenciav2->status = 0;
                    $deuagenciav2->save();
                } else {
                    $deuagenciav2 = "true";
                }

            }

        }


        for($i=0; $i<sizeof($request->tikets); $i++) {
            $separador = explode('Ç', $request->agenciav);
            $j = 0;
            if (!empty($request->tipop[$j])) {
                    $pagoc = new DeupagoConsolidadores();
                 $pagoc->fecha =  date('Y-m-d');
                    $pagoc->venta_boleto_id     = $request->numero;
                    $pagoc->codigo              = $request->codigo;
                    $pagoc->nro_ticket         = str_replace(" ","", $request->tikets[$i] );
                    $pagoc->dni_ruc             = $request->cedula[$i];
                    $pagoc->nombre_cliente      = $request->usern[$i];
                    $pagoc->laereas_id          = $request->laerea;
                    $pagoc->ruta                = $request->csalida . $request->pais . $request->cllegada;
                    $pagoc->consolidadores_id   = $request->consolidador;
                    $pagoc->aviajes_id          = $separador[1];
                    $pagoc->pago_consolidador   = $request->conso[$i];
                    $pagoc->porpagar            = $request->conso[$i];
                    $pagoc->comision_agencia    = $request->comi[$i];
                    $pagoc->igv                 = $request->igv[$i];
                    $pagoc->total               = $request->total[$i];
                    $pagoc->diasc               = $request->diasp;
                    $pagoc->status              = 0;
                    $pagoc->save();
            }
        }

       /* for($i=0; $i<sizeof($request->tikets); $i++) {
            $separador = explode('Ç', $request->agenciav);
            $j = 0;
            if (!empty($request->tipop[$j])) {
                if ($request->tipop[$j] == 7) {
                        $cobros = new Cobro();
                        $cobros->venta_boleto_id = $request->numero;
                        $cobros->nro_ticket = $request->tikets[$i];
                        $cobros->dni_ruc = $separador[0];
                        $cobros->cliente_id = $separador[1];
                        $cobros->fecha = date('Y-m-d');
                        $cobros->dias = $request->diasp;
                        $cobros->monto = $request->tarifaf[$i];
                        $cobros->users_id = Auth::User()->id;
                        $cobros->status = 0;
                        $cobros->save();
                    } else {
                        $cobros = "true";
                    }
            }
        }*/

                $message = $cotizacion && $ventav && $propago && $deuagenciav && $deuagenciav2  && $pagoc  ? 'Se procesó exitosamente'  : 'Error al Procesar';

                return redirect()->route('manageCotizacion-A')->with('message', $message);

   /* dd($request->all());*/
    }
    /* funciones nuevas */
    public function buscarComision($aerolinea,$consolidador){
        $comision = Comision::where("laereas_id",$aerolinea)->Where("consolidadores_id",$consolidador)->first();
        return $comision;
    }
    public function validarCodigo($codigo){
        $boleto = VboletoP::where("codigo",$codigo)->first();
        return $boleto;
    }
    public function buscarCedula($cedula){
        $persona = Cliente::where("cedula_rif",$cedula)->first();
        return $persona;
    }
    

    
    
    
}
