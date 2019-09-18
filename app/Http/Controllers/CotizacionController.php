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

    // Nuevas Funciones usando gerInRange
    public function get_count_data_filter($fecha_d, $fecha_h){
        /*$fecha_d = $fecha_d.' 00:00:00';
        $fecha_h = $fecha_h.' 23:59:00';*/
        if(Auth::User()->role == "Administrador") {
            $count_cboletos = Cotizacion::whereBetween('created_at', [$fecha_d, $fecha_h])
                                    ->where('anulado','!=','1')
                                    ->orderBy('id', 'desc')
                                    ->count();
        }else{
            $count_cboletos = Cotizacion::whereBetween('created_at', [$fecha_d, $fecha_h])
                                    ->where('users_id', Auth::id())
                                    ->where('anulado','!=','1')
                                    ->orderBy('id', 'desc')
                                    ->count();
        }
        return $count_cboletos;
    }

    public function getBoletosInRange($fecha_d, $fecha_h){
        $c_boletos = [];
        /*$fecha_d = $fecha_d.' 00:00:00';
        $fecha_h = $fecha_h.' 23:59:00';*/
        if(Auth::User()->role == "Administrador"){
            $c_boletos = Cotizacion::whereBetween('created_at', [$fecha_d, $fecha_h])
                                        ->where('anulado','!=','1')
                                        ->orderBy('id','desc')
                                        ->get();
        }else{
            $c_boletos = Cotizacion::whereBetween('created_at', [$fecha_d, $fecha_h])
                                        ->where('users_id', Auth::id())
                                        ->where('anulado','!=','1')
                                        ->orderBy('id','desc')
                                        ->get();
        }
        $c_boletos->load('paises', 'aviajes', 'users');
        return $c_boletos;
    }

    public function getC_Paquetes()
    {
        if(Auth::User()->role == "Administrador"){
            $c_paquetes = CotizacionPaquete::orderBy('updated_at','DESC')->get();
            $c_paquetes->load('agencia', 'pais', 'destino', 'vendedor');
        }else{
             $c_paquetes = CotizacionPaquete::where("user_id",Auth::User()->id)->orderBy('updated_at','DESC')->get();
            $c_paquetes->load('agencia', 'pais', 'destino', 'vendedor');       }
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

    public function update_Cpaquete(Request $data)
    {
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

    public function create()
    {
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

    public function update_Cboleto(Request $request)
    {
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

    public function update_Cboletos_multi(Request $request)
    {
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

    public function status(Request $request, $id)
    {

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
    public function show($id)
    {
        $cotizacioness = cotizaciones::all()->lists('name', 'id');

        return view('cotizaciones.show');

    }
    public function destroy($id)
    {
        $cotizacioness = Cotizacion::find($id);
        $cotizacioness->delete($id);
        $message = $cotizacioness?'Registro eliminado correctamente' : 'Error al Eliminar';
        return redirect()->route('manageCotizacion-A')->with('message', $message);
    }
    public function anulado($count)
    {
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
        return view('cotizaciones.procesar', compact(
            'empresas',
            'bancos',
            'bancosg',
            'tipo_pagos',
            'cotizacion',
            'agencia_viajes',
            'consolidadores',
            'lineas_aereas',
            'iva'
        ));
    }
    

    public function temp(Request $request){
        $cotizacion = Cotizacion::find($request->cotizacion);
        //return $cotizacion;
        $cotizacion->status = "1";
        $cotizacion->update();
        foreach ($request->boletos as $key => $boleto) {
            $ticket = new VboletoP();
            $ticket->venta_boleto_id   = $cotizacion->count;
            $ticket->nro_ticket        = $boleto["nro_ticket"];
            $ticket->codigo            = $request->proveedor["codigo"];
            if($request->pasajeros[$key]["id"] == 0){
                $cliente = new Cliente();
                $cliente->tipo_documento = $request->pasajeros[$key]['tipo_doc'];
                $cliente->empresas_id = 1;
                $cliente->cedula_rif  = $request->pasajeros[$key]["cedula"];
                $cliente->nombre      = $request->pasajeros[$key]["nombre"];
                $cliente->apellido    = $request->pasajeros[$key]["apellido"];
                $cliente->telefono    = $request->pasajeros[$key]["telefono"];
                $cliente->email       = $request->pasajeros[$key]["email"];
                $cliente->direccion   = $request->pasajeros[$key]["direccion"];
                $cliente->tipo_pasajero = $request->pasajeros[$key]["tipo"];
                $cliente->users_id = Auth::User()->id;
                $cliente->save();
            } else {
                $cliente = Cliente::find($request->pasajeros[$key]["id"]);
                $cliente->tipo_documento = $request->pasajeros[$key]['tipo_doc'];
                $cliente->empresas_id = 1;
                $cliente->cedula_rif  = $request->pasajeros[$key]["cedula"];
                $cliente->nombre      = $request->pasajeros[$key]["nombre"];
                $cliente->apellido    = $request->pasajeros[$key]["apellido"];
                $cliente->telefono    = $request->pasajeros[$key]["telefono"];
                $cliente->email       = $request->pasajeros[$key]["email"];
                $cliente->direccion   = $request->pasajeros[$key]["direccion"];
                $cliente->tipo_pasajero = $request->pasajeros[$key]["tipo"];
                $cliente->users_id = Auth::User()->id;
                $cliente->save();
            }
            $ticket->cliente_id        = $request->pasajeros[$key]["cedula"];
            $ticket->nombre_cliente    = $request->pasajeros[$key]["nombre"] . " " . $request->pasajeros[$key]["apellido"];
            $ticket->laereas_id        = $request->proveedor["aerolinea"];
            if($cotizacion->ida_vuelta == 1){
                $ticket->ruta          = $cotizacion->d_ciudad_id.$cotizacion->h_ciudad_id.$cotizacion->d_ciudad_id;    
            } else {
                $ticket->ruta          = $cotizacion->d_ciudad_id.$cotizacion->h_ciudad_id;
            }
            $ticket->consolidadores_id = $request->proveedor["consolidador"];
            $agencia = Aviaje::find($cotizacion->aviajes_id);
            $ticket->aviajes           = $agencia->nombre;
            $ticket->agentes_id        = Auth::User()->nombres . " " . Auth::User()->apellidos;
            $ticket->neto              = $boleto["neto"];
            $ticket->tarifa            = $boleto["tarifa"];
            $ticket->comision_agencia  = $boleto["comision"];
            $ticket->igv               = $boleto["igv"];
            $ticket->total             = $boleto["total"];
            $ticket->pago_consolidador = $boleto["pago_consolidador"];
            $ticket->tarifa_fee        = $boleto["tarifa_fee"];
            $ticket->utilidad          = $boleto["utilidad"];
            $ticket->incentivo         = 0;
            $ticket->monto             = $request->forma_pago["total_pagar"];
            $ticket->tipo_pago         = $request->forma_pago["tipo"];
            $ticket->banco_emisor      = $request->forma_pago["banco_emisor"];
            $ticket->banco_receptor    = $request->forma_pago["banco_receptor"];
            $ticket->nro_operacion     = $request->forma_pago["nro_operacion"];
            $ticket->abono             = $request->forma_pago["monto_cancelar"];
            $ticket->users_id          = Auth::User()->id;
            $ticket->save();

            if ($request->forma_pago["tipo"] != 1) {
                $deuda_agencia_viaje = new DeuagenciaViajes();
                    $deuda_agencia_viaje->fecha             =  date('Y-m-d');
                    $deuda_agencia_viaje->venta_boleto_id   = $ticket->venta_boleto_id;
                    $deuda_agencia_viaje->nro_ticket        = $ticket->nro_ticket;
                    $deuda_agencia_viaje->dni_ruc           = $ticket->cliente_id;
                    $deuda_agencia_viaje->nombre_cliente    = $ticket->nombre_cliente;
                    $deuda_agencia_viaje->laereas_id        = $ticket->laereas_id;
                    $deuda_agencia_viaje->ruta              = $ticket->ruta;
                    $deuda_agencia_viaje->consolidadores_id = $ticket->consolidadores_id;
                    $deuda_agencia_viaje->aviajes_id        = $ticket->aviajes;
                    $deuda_agencia_viaje->tarifa_fee        = $ticket->tarifa_fee;
                    $deuda_agencia_viaje->porpagar          = $ticket->tarifa_fee;
                    $deuda_agencia_viaje->agentes_id        = $ticket->agentes_id;
                    $deuda_agencia_viaje->diasc             = $request->forma_pago["dias_para_pagar"];
                    $deuda_agencia_viaje->status            = 0;
                    $deuda_agencia_viaje->nro_operacion     = $request->forma_pago["nro_operacion"];
                    $deuda_agencia_viaje->save();
            }
        }

        /* no se que hace esto pero lo puse por que sino no sirve */
        $propago =  new Propago();
        $propago->cotizacion_id     = $cotizacion->id;
        $propago->monto             = $request->forma_pago["total_pagar"];
        $propago->tipo_pago         = $request->forma_pago["tipo"];
        $propago->banco_e           = $request->forma_pago["banco_emisor"];
        $propago->banco_r           = $request->forma_pago["banco_receptor"];
        $propago->numero_op         = $request->forma_pago["nro_operacion"];
        $propago->monto_f           = $request->forma_pago["monto_cancelar"];
        $propago->save();

        return "funciono";

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
    public function validarTicket($ticket){
        $ticket = VboletoP::where("nro_ticket",$ticket)->get();
        return $ticket;
    }
    

    
    
    
}
