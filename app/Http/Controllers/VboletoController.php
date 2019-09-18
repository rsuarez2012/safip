<?php

namespace App\Http\Controllers;

use Auth;
use Excel;
use App\Iva;
use App\Role;
use App\User;
use App\Tpago;
use App\Aviaje;
use App\Laerea;
use App\Cliente;//eliminar mas adelante
use App\Empresa;
use App\Sucursal;
use App\VboletoP;
use App\Incentivo;
use App\Cotizacion;
use App\Consolidador;
use App\DeuagenciaViajes;
use Illuminate\Http\Request;
use App\DeupagoConsolidadores;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;

class VboletoController extends Controller
{
    public function debug(){
        $count = 0;
        $users = Cliente::all();
        foreach ($users as $user) {
            echo("<hr>usuario id : ".$user->id." nombre : " . $user->nombre ." ".$user->apellido . " - ");
            $boletos = VboletoP::where("cliente_id",null)
                                ->where("nombre_cliente","like","%".$user->nombre ." ".$user->apellido."%")
                                ->orderBy("id","asc")
                                ->get();
            echo("Boletos nulos : " . $boletos->count() . " - ");
                foreach ($boletos as $index => $boleto) {
                    $boletos[$index]->cliente_id = $user->cedula_rif;
                    $boletos[$index]->save();
                    $count++;
                    echo("Boleto con id : " .$boletos[$index]->id. " cambiado a : " . $boletos[$index]->cliente_id ." / ");
            }
        }
        return "<\n>Finalizo , se corrigieron " . $count . " documentos";
    }
    public function __construct() {
        $this->middleware('web');
    }

    // FUNCION PARA CAMBIAR AGENCIAS QUE ESTAN EN 0 EN UN RANGO DE FECHA
    public function change_agencies($fecha_d, $fecha_h){
        $vboletos = [];
        $zero = 0;
        if(Auth::User()->role == "Administrador") {
            $vboletos = VboletoP::whereBetween('created_at', [$fecha_d, $fecha_h])
                                    ->where('anulado','!=','1')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
        }
        if(count($vboletos) > 0){
            foreach ($vboletos as $vboleto) {
                if($vboleto->aviajes == '' || $vboleto->aviajes == "0"){
                    $cotizacion = Cotizacion::where('count', $vboleto->venta_boleto_id)->first();
                    $agency_name = $cotizacion->aviajes->nombre;
                    $vboleto->aviajes = $agency_name;
                    $vboleto->update();
                    $zero++;
                }
            }
            if($zero > 0){
                if($zero > 1){
                    $text = 'Los '.$zero.' boletos que tenían agencia con 0 han sido modificados!.';
                } else {
                    $text = 'El boleto que tenía agencia con 0 ha sido modificado!.';
                }
                return redirect()->route('manageVboleto-A')->with('info', $text);
            }
        }
        return redirect()->route('manageVboleto-A')->with('inf', 'No se encontraron boletos con agencias en 0 en el rango de fechas asignadas.');
    }

    // NEW FUNCTIONS CREATED'S BY CJ
    public function get_count_data_filter($fecha_d, $fecha_h){
        $fecha_d = $fecha_d.' 00:00:00';
        $fecha_h = $fecha_h.' 23:59:00';
        if(Auth::User()->role == "Administrador") {
            $count_vboletos = VboletoP::whereBetween('created_at', [$fecha_d, $fecha_h])
                                    ->where('anulado','!=','1')
                                    ->orderBy('created_at', 'desc')
                                    ->count();
        }else{
            $count_vboletos = VboletoP::whereBetween('created_at', [$fecha_d, $fecha_h])
                                    ->where('users_id', Auth::id())
                                    ->where('anulado','!=','1')
                                    ->orderBy('created_at', 'desc')
                                    ->count();
        }
        return $count_vboletos;
    }

    public function get_vb_InRange($fecha_d, $fecha_h){
        $vboletos = [];
        $fecha_d = $fecha_d.' 00:00:00';
        $fecha_h = $fecha_h.' 23:59:00';
        if(Auth::User()->role == "Administrador") {
            $vboletos = VboletoP::whereBetween('created_at', [$fecha_d, $fecha_h])
                                    ->where('validated',1)
                                    ->where('anulado','!=','1')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
        }else{
            $vboletos = VboletoP::whereBetween('created_at', [$fecha_d, $fecha_h])
                                    ->where('users_id', Auth::id())
                                    ->where('validated',1)
                                    ->where('anulado','!=','1')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
        }
        $vboletos->load('consolidadores', 'laereas', 'users', 'tipop');

        $tipop = Tpago::orderBy('pago','asc')->get();
        $aviajes = Aviaje::orderBy('nombre','asc')->get();
        $laereas = Laerea::orderBy('nombre','asc')->get();
        $consolidadores = Consolidador::orderBy('nombre','asc')->get();
        $incentivos = Incentivo::all();
        $iva = Iva::all()->last();
        $vendedores = User::orderBy('nombres','asc')->get();

        return response()->json([
            'fecha_d'           => $fecha_d,
            'fecha_h'           => $fecha_h,
            'incentivos'        => $incentivos,
            'iva'               => $iva,
            'vendedores'        => $vendedores,
            'tipo_pagos'        => $tipop,
            'aviajes'           => $aviajes,
            'laereas'           => $laereas,
            'consolidadores'    => $consolidadores,
            'vboletos'=> $vboletos,
        ]);
    }

    public function updateVboleto(VboletoP $vboletop, Request $request){

        $deuda_agencia_viaje = DeuagenciaViajes::where('nro_ticket',$request->ticket['nro'])->first();

        // EDITAR EL VBOLETOP CON LOS DATOS DE LA REQUEST
        $vboletop->aviajes              = $request->ticket['aviajes'];
        $vboletop->tipo_pago            = $request->ticket['tipop']['id'];
        $vboletop->laereas_id           = $request->ticket['laerea']['id'];
        $vboletop->consolidadores_id    = $request->ticket['consolidador']['id'];
        $vboletop->neto                 = $request->ticket['neto'];
        $vboletop->tarifa               = $request->ticket['tarifa'];
        $vboletop->comision_agencia     = $request->ticket['comision_agencia'];
        $vboletop->igv                  = $request->ticket['igv'];
        $vboletop->total                = $request->ticket['total'];
        $vboletop->pago_consolidador    = $request->ticket['pago_consolidador'];
        $vboletop->tarifa_fee           = $request->ticket['tarifa_fee'];
        $vboletop->utilidad             = $request->ticket['utilidad'];
        $vboletop->incentivo            = $request->ticket['incentivo'];
        $vboletop->nro_operacion        = $request->ticket['nro_operacion'];
        if(!$request->ticket['exist_percent']){
            $vboletop->comision         = $request->ticket['percent_comi_agency'];
        }
        $vboletop->updated_by = Auth::User()->apellidos . " " . Auth::User()->nombres;
        $vboletop->update();

        if($deuda_agencia_viaje == null){
            if($request->ticket['tipop']['id'] != 1){

                $create_deuda = DeuagenciaViajes::create([
                    'fecha'             => $request->ticket['fecha'],
                    'venta_boleto_id'   => $vboletop->venta_boleto_id,
                    'nro_ticket'        => $request->ticket['nro'],
                    'dni_ruc'           => $vboletop->cliente_id,
                    'nombre_cliente'    => $vboletop->nombre_cliente,
                    'laereas_id'        => $request->ticket['laerea']['id'],
                    'ruta'              => $vboletop->ruta,
                    'consolidadores_id' => $request->ticket['consolidador']['id'],
                    'aviajes_id'        => $request->ticket['aviajes'],
                    'tarifa_fee'        => $request->ticket['tarifa_fee'],
                    'porpagar'          => $request->ticket['tarifa_fee'],
                    'agentes_id'        => $vboletop->agentes_id,
                    'diasc'             => $request->ticket['percent_comi_agency'],
                    'status'            => 0,
                    'users_id'          => $vboletop->users->id,
                    'anulado'           => 0,
                    'nro_operacion'     => $request->ticket['nro_operacion'],
                ]);
            }
        } else {
        // si existe una deuda de agencia de viaje
            if($request->ticket['tipop']['id'] != 1){
                $deuda_agencia_viaje->aviajes_id            = $request->ticket['aviajes'];
                $deuda_agencia_viaje->laereas_id            = $request->ticket['laerea']['id'];
                $deuda_agencia_viaje->consolidadores_id     = $request->ticket['consolidador']['id'];
                $deuda_agencia_viaje->tarifa_fee            = $request->ticket['tarifa_fee'];
                $deuda_agencia_viaje->porpagar              = $request->ticket['tarifa_fee'];
                $deuda_agencia_viaje->nro_operacion         = $request->ticket['nro_operacion'];
                $deuda_agencia_viaje->update();
            } else {
                // si existe la de deuda de agencia pero se cambio el tipo de pago distinto de A CREDITO
                $deuda_agencia_viaje->delete();
            }
        }

        $deuda_pago_conso = DeupagoConsolidadores::where('nro_ticket',$request->ticket['nro'])->first();
        if($deuda_pago_conso != null) {
            $deuda_pago_conso->aviajes_id           = $request->ticket['aviajes'];
            $deuda_pago_conso->laereas_id           = $request->ticket['laerea']['id'];
            $deuda_pago_conso->consolidadores_id    = $request->ticket['consolidador']['id'];
            $deuda_pago_conso->comision_agencia     = $request->ticket['comision_agencia'];
            $deuda_pago_conso->igv                  = $request->ticket['igv'];
            $deuda_pago_conso->total                = $request->ticket['total'];
            $deuda_pago_conso->pago_consolidador    = $request->ticket['pago_consolidador'];
            $deuda_pago_conso->nro_operacion        = $request->ticket['nro_operacion'];
            $deuda_pago_conso->update();
        }

        return/* response()->json([
            'deuda_pago_conso'  => $deuda_pago_conso,
            'create_deuda'      => $create_deuda,
            'deuda_agencia'     => $deuda_agencia_viaje,
            'request'           => $request->all(),
            'vboletop'          => $vboletop
        ])*/;
    }

    public function updateFechaRegistro(VboletoP $vboletop, Request $request){
        $hora = explode(' ', $vboletop->created_at)[1];
        $vboletop->created_at = $request->new_fecha.' '.$hora;
        $vboletop->updated_by = Auth::User()->apellidos . " " . Auth::User()->nombres;
        $vboletop->update();

        $deuda_pago_conso = DeupagoConsolidadores::where('nro_ticket', $request->nro_ticket)->first();
        if($deuda_pago_conso != null) {
            $deuda_pago_conso->fecha = $request->new_fecha;
            $deuda_pago_conso->update();
        }

        $deuda_agencia_viaje = DeuagenciaViajes::where('nro_ticket', $request->nro_ticket)->first();
        if($deuda_agencia_viaje != null){
            $deuda_agencia_viaje->fecha = $request->new_fecha;
            $deuda_agencia_viaje->update();
        }

        return $hora;
    }

    public function toolGetDataFilter($fecha_d, $fecha_h, $consos, $avs, $las, $vens, $pas, $tpago){
        $ar_name = [];
        $fechai = $fecha_d.' 00:00:00';
        $fechaf = $fecha_h.' 23:59:00';

        $consulta = VboletoP::whereBetween('created_at', [$fechai, $fechaf])->where('anulado','!=','1')->orderBy('created_at', 'desc');

        $vboletos = $consulta->get();
        $vboletos->load('consolidadores', 'laereas', 'users', 'tipop');

        $ven_colect = collect();

        if(Auth::User()->role != "Administrador") {
            foreach ($vboletos as $index => $boleto) {
                if($boleto->users_id != Auth::id()){
                    $vboletos->pull($index);
                }
            }
        }

        if($vens != null){
            foreach ($vens as $ven) {
                if($ven != null){
                    foreach ($vboletos as $index => $boleto) {
                        if($boleto->users != null){
                            if($boleto->users->id == $ven) $ven_colect->push($boleto);
                        }
                        /*$exist = false;
                        $ar_agent = explode(' ', strtolower($ven));
                        foreach ($ar_agent as $agent) {
                            if($boleto->users != null){
                                $name = strtolower($boleto->users->nombres);
                                $lastname = strtolower($boleto->users->apellidos);
                                $item_user = strtolower($agent);

                                similar_text($name, $item_user, $per_name);
                                if(!$exist && $per_name >= 50) $existe = !0;

                                similar_text($lastname, $item_user, $per_last);
                                if(!$exist && $per_last >= 50) $exist = !0;

                                if(!$exist && substr_count($name, $item_user) > 0) $exist = !0;

                                if(!$exist && substr_count($lastname, $item_user) > 0) $exist = !0;

                                if($exist) $ven_colect->push($boleto);
                            }
                        }*/
                    }
                }
            }
            $vboletos = $ven_colect;
        }

        //return $vboletos;

        if($pas != null){
            foreach ($vboletos as $index => $boleto) {
                if(substr_count(strtolower($boleto->nombre_cliente), strtolower($pas)) == 0){
                    $vboletos->pull($index);
                }
            }
        }

        $con_colect = collect();
        if($consos != null){
            foreach ($consos as $index => $con) {
                foreach ($vboletos as $index => $boleto) {
                    if($boleto->consolidadores_id == $con){
                        $con_colect->push($boleto);
                    }
                }
            }
            $vboletos = $con_colect;
        }

        $avs_colect = collect();
        if($avs != null){
            foreach ($avs as $index => $av) {
                foreach ($vboletos as $index => $boleto) {
                    //return response()->json(['av' => $av, 'avs' => $avs, 'boleto' => $boleto]);
                    if(substr_count(strtolower($boleto->aviajes), strtolower($av)) != 0){
                        $avs_colect->push($boleto);
                    }

                }
            }
            $vboletos = $avs_colect;
        }

        $las_colect = collect();
        if($las != null){
            foreach ($las as $la) {
                foreach ($vboletos as $boleto) {
                    if($boleto->laereas_id == $la){
                        $las_colect->push($boleto);
                    }
                }
            }
            $vboletos = $las_colect;
        }

        if($tpago > 0){
            foreach ($vboletos as $index => $boleto) {
                if($boleto->tipo_pago != $tpago){
                    $vboletos->pull($index);
                }
            }
        }

        $aux = collect();
        foreach ($vboletos as $boleto) {
            $aux->push($boleto);
        }

        return $aux;
    }

    public function generalFilter(Request $request){
        //dd($request->all());
        //return $request->all();
        $vboletos = $this->toolGetDataFilter($request->fecha_d, $request->fecha_h, $request->consolidador, $request->aviajes, $request->laereas, $request->vendedor, $request->pasajero, $request->tpago);

        $tipop = Tpago::orderBy('pago','asc')->get();
        $aviajes = Aviaje::orderBy('nombre','asc')->get();
        $laereas = Laerea::orderBy('nombre','asc')->get();
        $consolidadores = Consolidador::orderBy('nombre','asc')->get();

        $iva = Iva::all()->last();
        $vendedores = User::orderBy('nombres','asc')->get();

        return response()->json([
            'iva'               => $iva,
            'request'           => $request->all(),
            'aviajes'           => $aviajes,
            'laereas'           => $laereas,
            'vboletos'          => $vboletos,
            'vendedores'        => $vendedores,
            'tipo_pagos'        => $tipop,
            'consolidadores'    => $consolidadores,
        ]);
    }

    public function updateVarios(Request $request){
        $vboletos = VboletoP::find($request->boletos);
        $ar_hours = [];
        foreach($vboletos as $boleto){
            $boleto->updated_by = Auth::User()->apellidos . " " . Auth::User()->nombres;
            if($request->aviaje !== 0 && $request->aviaje != "0" && $request->aviaje != null && isset($request->aviaje)){
                $boleto->aviajes = $request->aviaje;
            }
            if($request->tpago > 0){
                $deuda_agencia_viaje = DeuagenciaViajes::where('nro_ticket',$boleto->nro_ticket)->first();
                if($request->tpago == 7){
                    if($request->aviaje == 0) $aviajes = $boleto->aviajes;
                    else $aviajes = $request->aviaje;

                    if($request->freg != null){
                        $fecha = $request->freg;
                    } else {
                        $fecha = explode(' ', $boleto->created_at)[0];
                    }

                    if($deuda_agencia_viaje == null){
                        DeuagenciaViajes::create([
                            'fecha'             => $fecha,
                            'venta_boleto_id'   => $boleto->venta_boleto_id,
                            'nro_ticket'        => $boleto->nro_ticket,
                            'dni_ruc'           => $boleto->cliente_id,
                            'nombre_cliente'    => $boleto->nombre_cliente,
                            'laereas_id'        => $boleto->laereas_id,
                            'ruta'              => $boleto->ruta,
                            'consolidadores_id' => $boleto->consolidadores_id,
                            'aviajes_id'        => $aviajes,
                            'tarifa_fee'        => $boleto->tarifa_fee,
                            'porpagar'          => $boleto->tarifa_fee,
                            'agentes_id'        => $boleto->agentes_id,
                            'diasc'             => 0,
                            'status'            => 0,
                            'users_id'          => $boleto->users_id,
                            'anulado'           => 0,
                        ]);
                    } else {
                        $deuda_agencia_viaje->aviajes_id = $aviajes;
                        $deuda_agencia_viaje->fecha      = $fecha;
                        $deuda_agencia_viaje->update();
                    }
                        
                } else {
                    if($deuda_agencia_viaje != null){
                        $deuda_agencia_viaje->delete();
                    }
                }
                $boleto->tipo_pago = $request->tpago;
            }

            $deuda_pago_conso = DeupagoConsolidadores::where('nro_ticket', $boleto->nro_ticket)->first();
            if($deuda_pago_conso != null) {
                if($request->aviaje > 0){
                    $deuda_pago_conso->aviajes_id = $request->aviaje;
                }
                
                if($request->freg != null){
                    $deuda_pago_conso->fecha = $request->freg;
                } else {
                    $deuda_pago_conso->fecha = explode(' ', $boleto->created_at)[0];
                }
                $deuda_pago_conso->update();
            }

            $hora = explode(' ', $boleto->created_at)[1];
            array_push($ar_hours, $hora);
            if($request->freg != null){
                $boleto->created_at = $request->freg. ' '. $hora;
            }
            $boleto->update();
        }
        return $ar_hours;
    }

    public function anularTicket(VboletoP $vboletop){

        $deuda_agencia_viaje = DeuagenciaViajes::where('venta_boleto_id', $vboletop->venta_boleto_id)->first();
        
        if($deuda_agencia_viaje != null){
            //$deuda_agencia_viaje->nro_ticket = NULL;
            $deuda_agencia_viaje->anulado = '1';
            $deuda_agencia_viaje->update();
        }

        $deuda_pago_conso = DeupagoConsolidadores::where('venta_boleto_id', $vboletop->venta_boleto_id)->first();
        if($deuda_pago_conso != null){
            //$deuda_pago_conso->nro_ticket = NULL;
            $deuda_pago_conso->anulado = "1";
            $deuda_pago_conso->update();
        }

        $cotizacion = Cotizacion::where('count', $vboletop->venta_boleto_id)->first();
        if($cotizacion != null){
            $cotizacion->anulado = "1";
            $cotizacion->update();
        }

        //$vboletop->nro_ticket = NULL;
        $vboletop->anulado = "1";
        $vboletop->updated_by = Auth::User()->apellidos . " " . Auth::User()->nombres;
        $vboletop->update();

        return;
    }

    public function exportarVboletos($fecha_d, $fecha_h, $consolidador, $aviajes, $laereas, $vendedores, $pasajero, $tpago, $rango_a, $rango_b, $search){
        /*
        id, fecha de registro (created_at), id cotizacion, codigo, dni/ruc, pasajero, aerolinea, ruta, nro de ticket, agencia de viajes,
        agente, neto, comision de agencia, total, tipo de pago, tarifa fee, status
        */
        if($consolidador == "null"){
            $consos = null;
        } else {
            $consos = explode(',', $consolidador);
        }

        if($aviajes == "null"){
            $avs = null;
        } else {
            $avs = explode(',', $aviajes);
        }

        if($laereas == "null"){
            $las = null;
        } else {
            $las = explode(',', $laereas);
        }

        if($vendedores == "null"){
            $vens = null;
        } else {
            $vens = explode(',', $vendedores);
        }

        if($pasajero == "null"){
            $pas = null;
        } else {
            $pas = $pasajero;
        }

        $vboletos = $this->toolGetDataFilter($fecha_d, $fecha_h, $consos, $avs, $las, $vens, $pas, $tpago);
        //dd($rango_a, $rango_b, $vboletos, $search);
        if(count($vboletos) > 0){
            //dd($vboletos);
            $newVboletos = [];

            if($search != "null"){
                $search = strtolower($search);
                //dd($search);
                foreach ($vboletos as $vboleto) {
                    //dd($vboleto->users);
                    if($vboleto->laereas != null){
                        $laerea = $vboleto->laereas->nombre;
                    } else { $laerea = ''; }

                    if($vboleto->agentes_id != null){
                        $agent = strtolower($vboleto->agentes_id);
                    } else {
                        $agent = '';
                    }
                    //dd(strpos($agent, $search));

                    if(strpos(strval($vboleto->id), $search) !== false){ // id del boleto
                        array_push($newVboletos, $vboleto);
                    } elseif (strpos(strval($vboleto->venta_boleto_id), $search) !== false) { // id cotizacion
                        array_push($newVboletos, $vboleto);
                    } elseif (strpos(strtolower($vboleto->codigo), $search) !== false) { // codigo de boleto
                        array_push($newVboletos, $vboleto);
                    } elseif (strpos(strval($vboleto->cliente_id), $search) !== false) { // dni ruc
                        array_push($newVboletos, $vboleto);
                    } elseif (strpos(strtolower($vboleto->nombre_cliente), $search) !== false) { // nombre pasajero
                        array_push($newVboletos, $vboleto);
                    } elseif (strpos(strtolower($laerea), $search) !== false) { //aerolinea
                        array_push($newVboletos, $vboleto);
                    } elseif (strpos(strtolower($vboleto->ruta), $search) !== false) { // ruta
                        array_push($newVboletos, $vboleto);
                    } elseif (strpos(strval($vboleto->nro_ticket), $search) !== false) { // nro de ticket
                        array_push($newVboletos, $vboleto);
                    } elseif (strpos(strtolower($vboleto->aviajes), $search) !== false) { //agencia de viaje
                        array_push($newVboletos, $vboleto);
                    } elseif (strpos($agent, $search) !== false) { // agente
                        array_push($newVboletos, $vboleto);
                    } elseif (strpos(strval($vboleto->neto), $search) !== false) {  // neto
                        array_push($newVboletos, $vboleto);
                    } elseif (strpos(strval($vboleto->comision_agencia), $search) !== false) { // comision agencia
                        array_push($newVboletos, $vboleto);
                    } elseif (strpos(strval($vboleto->total), $search) !== false) { // total
                        array_push($newVboletos, $vboleto);
                    } elseif (strpos(strtolower($vboleto->tipop->pago), $search) !== false) { // tipo de pago
                        array_push($newVboletos, $vboleto);
                    } elseif (strpos(strval($vboleto->tarifa_fee), $search) !== false) { // tarifa fee
                        array_push($newVboletos, $vboleto);
                    }
                    //dd($newVboletos);
                }

                $vboletos = $newVboletos;
            }
            if(count($vboletos) >= ($rango_b - 1)){
                Excel::create('Vboletos', function($excel) use($vboletos, $rango_a, $rango_b) {
                 
                    $excel->sheet('Vboletos', function($sheet) use($vboletos, $rango_a, $rango_b) {
                 
                        $sheet->row(1, [
                            'ID',
                            'REGISTRO',
                            'ID COTIZACION',
                            'CODIGO',
                            'DNI/RUC',
                            'PASAJERO',
                            'AEROLINEA',
                            'RUTA',
                            'NRO TICKET',
                            'CONSOLIDADOR',
                            'AGENCIA DE VIAJE',
                            'AGENTE',
                            'NETO',
                            'TARIFA',
                            'COMISION DE AGENCIA',
                            'IGV',
                            'TOTAL',
                            'TIPO DE PAGO',
                            'PAGO CONSOLIDADOR',
                            'TARIFA FEE',
                            'UTILIDAD',
                            'STATUS',
                        ]);

                        $index = 0;
                        for ($i = $rango_a; $i < $rango_b; $i++) {
                            if($vboletos[$i]->laereas != null){
                                $laerea = $vboletos[$i]->laereas->nombre;
                            } else {
                                $laerea = '';
                            }

                            if($vboletos[$i]->users != null){
                                $user = $vboletos[$i]->users->nombres .' '.$vboletos[$i]->users->apellidos;
                            } else {
                                $user = '';
                            }

                            if($vboletos[$i]->pagado == 1){
                                $status = 'Pagado';
                            } else {
                                $status = 'Sin pagar';
                            }

                            $sheet->row($index+2, [
                                $vboletos[$i]->id,
                                $vboletos[$i]->created_at,
                                $vboletos[$i]->venta_boleto_id,
                                $vboletos[$i]->codigo,
                                $vboletos[$i]->cliente_id,
                                $vboletos[$i]->nombre_cliente,
                                $laerea,
                                $vboletos[$i]->ruta,
                                $vboletos[$i]->nro_ticket,
                                $vboletos[$i]->consolidadores->nombre,
                                $vboletos[$i]->aviajes,
                                $user,
                                $vboletos[$i]->neto,
                                $vboletos[$i]->tarifa,
                                $vboletos[$i]->comision_agencia,
                                $vboletos[$i]->igv,
                                $vboletos[$i]->total,
                                $vboletos[$i]->tipop->pago,
                                $vboletos[$i]->pago_consolidador,
                                $vboletos[$i]->tarifa_fee,
                                $vboletos[$i]->utilidad,
                                $status,
                            ]);

                            $index++;
                        }
                    });
         
                })->export('xlsx');
            } else {
                return redirect()->route('manageVboleto-A')->with('error', 'La cantidad de venta de boletos no es compatible con el rango de impresion');
            }
        } else {
            return redirect()->route('usuarios')->with('error', 'No existen venta de boletos para exportar');
        }
    }
    // END

    public function getManageVboleto(Request $request){
        /*dd(date("Y-m-d H:i:s"));*/

        if (($request->fechai != "") and ($request->fechaf != "")){
            $fechai = $request->fechai;
            $fechaf = $request->fechaf;
        }else{
            $fechai = date('Y-m-d');
            $fechaf = date('Y-m-d');
        }
        $id =  Auth::User()->id;
        if(Auth::User()->role != "Administrador") {
            /*$vboletos = VboletoP::whereBetween('created_at', ['2018/01/24', '2018/02/06'])->get();*/
            $vboletos = VboletoP::whereBetween('created_at', [$fechai, $fechaf])->where('users_id', $id)->where('anulado','!=','1')->with('consolidadores')->orderBy('id', 'desc')->get();
        }else{
            $vboletos = VboletoP::whereBetween('created_at', [$fechai, $fechaf])->where('anulado','!=','1')->with('consolidadores')->orderBy('id', 'desc')->get();
        }
        /*dd($fechaf);*/
        $consolidadores = Consolidador::orderBy('nombre','asc')->get();
        $tipop = Tpago::orderBy('pago','asc')->get();
        $aviajes = Aviaje::orderBy('nombre','asc')->get();
        $laereas = Laerea::orderBy('nombre','asc')->get();
        $vendedor = User::orderBy('nombres','asc')->get();
        $incentivos = Incentivo::all();
        $iva = Iva::all()->last();
        //dd($incentivos);
        return view('vboletos.respaldo_index',compact('iva','incentivos','consolidadores','aviajes','laereas','vendedor','tipop'))->with('vboletos',$vboletos)->with('fechai', $fechai)->with('fechaf', $fechaf);
    }
    public function getManageVboletofecha(Request $request){
        // TESTING
        /*$vboletos = VboletoP::  whereBetween('created_at', [$request->fechai, $request->fechaf])
                                ->where('anulado','!=','1')
                                ->with('consolidadores')
                                ->orderBy('id', 'desc')
                                ->get();

        foreach($vboletos as $v){

        }
        dd($request->all(), $vboletos, $v);*/

        // dd(date("Y-m-d H:i:s"));

        if (($request->fechai != "") and ($request->fechaf != "")){
            $fechai = $request->fechai;
            $fechaf = $request->fechaf;
        }else{
            $fechai = date('Y-m-d');
            $fechaf = date('Y-m-d');
        }

        $id =  Auth::User()->id;
        if(Auth::User()->role != "Administrador") {
            /*$vboletos = VboletoP::whereBetween('created_at', ['2018/01/24', '2018/02/06'])->get();*/
            $vboletos = VboletoP::whereBetween('created_at', [$fechai, $fechaf])->where('anulado','!=','1')->where('users_id', $id)->with('consolidadores')->orderBy('id', 'desc')->get();
        }else{
            $vboletos = VboletoP::whereBetween('created_at', [$fechai, $fechaf])->where('anulado','!=','1')->with('consolidadores')->orderBy('id', 'desc')->get();
        }
        /*return response()->json([
                 'datos'=>$vboletos->toArray()
             ]);*/
        $consolidadores = Consolidador::orderBy('nombre','asc')->get();
        $aviajes = Aviaje::orderBy('nombre','asc')->get();
        $laereas = Laerea::orderBy('nombre','asc')->get();
        $vendedor = User::orderBy('nombres','asc')->get();
        $tipop = Tpago::orderBy('pago','asc')->get();
        $incentivos = Incentivo::all();
        $iva = Iva::all()->last();
        return view('vboletos.respaldo_index',compact('iva','incentivos','vboletos','fechai','fechaf','consolidadores','aviajes','laereas','vendedor','tipop'));

        //return view('vboletos.index')->with('vboletos',$vboletos)->with('fechai', $fechai)->with('fechaf', $fechaf);

    }
    public function getManageVboletobusqueda(Request $request){
        //dd($request->all());
        $ar_name = [];
        if (($request->fechai != "") and ($request->fechaf != "")){
            $fechai = $request->fechai;
            $fechaf = $request->fechaf;
        }else{
            $fechai = date('Y-m-d');
            $fechaf = date('Y-m-d');
        }

        $consulta= VboletoP::select('id','venta_boleto_id',
            'codigo','cliente_id','nombre_cliente','laereas_id',
            'ruta','nro_ticket','consolidadores_id','aviajes','agentes_id','neto','tipo_pago',
            'tarifa','comision_agencia','igv','total','pago_consolidador','tarifa_fee','utilidad','incentivo','comision','users_id','updated_at','created_at');

        if($request->consolidador != null){
            foreach ($request->consolidador as $con) {
                $consulta->where('consolidadores_id', $con);
            }
        }

        if($request->aviajes != null){
            foreach ($request->aviajes as $av) {
                $consulta->where('aviajes', $av);
            }
        }

        if($request->laereas != null){
            foreach ($request->laereas as $la) {
                $consulta->where('laereas_id', $la);
            }
        }

        if($request->vendedor != null){
            foreach ($request->vendedor as $ven) {
                if($ven != null){
                    $ar_name = explode(' ', $ven);
                    if(count($ar_name) > 1){
                        $f_name = $ar_name[0];
                        $s_name = $ar_name[1];
                        $consulta->where('agentes_id', 'LIKE', "%$f_name%")->where('agentes_id', 'LIKE', "%$s_name%");
                    } else {
                        $f_name = $ar_name[0];
                        $consulta->where('agentes_id','LIKE', "%$f_name");
                    }
                }
            }
        }

        if($request->pasajero != null){
            $consulta->where('nombre_cliente','like',"%$request->pasajero%");
        }

        if($request->tpago != null){
            $consulta->where('tipo_pago',$request->tpago);
        }

        $consulta->whereBetween('created_at', [$fechai, $fechaf])->where('anulado','!=','1');
        
        $vboletos = $consulta->get();

        //dd($vboletos, $request->all(), $fechai, $fechaf, $ar_name, $consulta);
        $consolidadores = Consolidador::orderBy('nombre','asc')->get();
        $aviajes = Aviaje::orderBy('nombre','asc')->get();
        $laereas = Laerea::orderBy('nombre','asc')->get();
        $vendedor = User::orderBy('nombres','asc')->get();
        $tipop = Tpago::orderBy('pago','asc')->get();
        $incentivos = Incentivo::all();
        $iva = Iva::all()->last();

        return view('vboletos.index', compact(
            'iva', 'incentivos', 'consolidadores', 
            'aviajes', 'laereas', 'vendedor', 'tipop')
        )->with('vboletos',$vboletos)->with('fechai', $fechai)->with('fechaf', $fechaf);
    }

    public function fecha(Request $request, $id){

        $vboletos= VboletoP::find($id);
        $vboletos = VboletoP::where('id','=', $id)->first();
        $vboletos->created_at = $request->fecha;
        $vboletos->save();
        $vboletos1 = DeupagoConsolidadores::where('nro_ticket','=', $request->nro_ticket)->first();
        if($vboletos1){
            $vboletos1->fecha = $request->fecha;
            $vboletos1->save();
        }

        $vboletos2 = DeuagenciaViajes::where('nro_ticket','=', $request->nro_ticket)->first();
        if($vboletos2) {
            $vboletos2->fecha = $request->fecha;
            $vboletos2->save();
        }
        $message = $vboletos ? 'Se actualizo la fecha de forma exitosa.' : 'Error al actualizar';
        $fecha = date('Y-m-d');

        $vboletos = VboletoP::whereBetween('created_at', array($fecha, $fecha))->where('anulado','!=','1')->with('consolidadores')->get();
        if($request->fechai){
            $fechai = $request->fechai;
        }else{
            $fechai = 0;
        }
        if($request->fechaf){
            $fechaf = $request->fechaf;
        }else{
            $fechaf = 0;
        }
        $incentivos = Incentivo::all();
        $iva = Iva::all()->last();
        return redirect()->route('manageVboleto-A', compact('incentivos','iva'))->with('message', $message)->with('vboletos', $vboletos)->with('fechai', $fechai)->with('fechaf', $fechaf);
    }

    public function create(){
        $empresas = Empresa::all();
        $sucursales = Sucursal::all();

        return view('vboletos.create',  compact('empresas'), compact('sucursales'));
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function anulado($nro_ticket){
        $vboletos4 = VboletoP::where('nro_ticket',$nro_ticket)->pluck('venta_boleto_id');
        if($vboletos4) {
            $cotizacion = $vboletos4;
            $vboletos2 = DeuagenciaViajes::where('venta_boleto_id', $cotizacion)->get();
            if($vboletos2){
                for($i=0; $i<sizeof($vboletos2); $i++){
                    $vboletos2[$i]->nro_ticket = NULL;
                    $vboletos2[$i]->anulado = "1";
                    $vboletos2[$i]->save();
                }
            }


            $vboletos3 = DeupagoConsolidadores::where('venta_boleto_id', $cotizacion)->get();
            if($vboletos3) {
                for ($i = 0; $i < sizeof($vboletos3); $i++) {
                    $vboletos3[$i]->nro_ticket = NULL;
                    $vboletos3[$i]->anulado = "1";
                    $vboletos3[$i]->save();
                }
            }
            $cotizacioness = Cotizacion::where('count',$cotizacion)->first();
            $cotizacioness->anulado = "1";
            $cotizacioness->save();
        }

        $vboletos4 = VboletoP::where('nro_ticket',$nro_ticket)->get();
        if($vboletos4) {
            for ($i = 0; $i < sizeof($vboletos4); $i++) {
                $vboletos4[$i]->nro_ticket = NULL;
                $vboletos4[$i]->anulado = "1";
                $vboletos4[$i]->save();
            }
        }

        $message = $vboletos4  ? 'Se Anulo el ticket.' : 'Error al Anular';

        return redirect()->route('manageVboleto-A')->with('message', $message);

    }
    public function store(Request $request){
        $existe_rif = Vboleto::where('cedula_rif', '=', $request->rif)->get();

        if (count($existe_rif) == 0) {

            $Vboletos = new Vboleto();
            $Vboletos->empresas_id  = $request->empresa;
            $Vboletos->sucursales_id  = $request->sucursal;
            $Vboletos->nombre       = $request->nombre;
            $Vboletos->apellido     = $request->apellido;
            $Vboletos->cedula_rif   = $request->cedula_rif;
            $Vboletos->direccion    = $request->direccion;
            $Vboletos->telefono     = $request->telefono;
            $Vboletos->email        = $request->email;
            $Vboletos->cargo        = $request->cargo;
            $Vboletos->users_id   = Auth::User()->id;
            $Vboletos->save();

            //return view('welcome');
            $message = $Vboletos ? 'Se ha registrado ' . $request->nombre .  'de forma exitosa.' : 'Error al Registrar';

            //Session::flash('message', 'Te has registrado exitosamente ');
            return redirect()->route('manageVboleto-A')->with('message', $message);


        } else {

            $message2 = 'Esta Vboleto ya se encuentra registrada';
            return redirect()->route('manageVboleto-A')->with('message2', $message2);

        }
    }

    public function edit($id){

        $Vboletos = Vboleto::where('id','=', $id)->first();
        $empresas = Empresa::all();
        return view('vboletos.edit')->with('Vboletos', $Vboletos)->with('empresas', $empresas);
    }

    public function consulta($h){

        $ticket = VboletoP::where('nro_ticket','=',$h)->first();
        /*dd($datosg);*/
        return $ticket;

    }

    public function update(Request $request){
        //dd($request->all());
        $dnro_ticket =$request->dtikets;
        $venta_boleto_p = VboletoP::where('nro_ticket',$dnro_ticket)->get();
        
        $deuda_agencia_viaje = DeuagenciaViajes::where('nro_ticket',$dnro_ticket)->get();
        //dd($venta_boleto_p[0], $deuda_agencia_viaje, $request->all());

        // LOGICA CREDA POR CESAR YANEZ
        if($venta_boleto_p->count() > 0){
            foreach($venta_boleto_p as $venta_bp){
                //dd($venta_bp, $request->all());
                if($request->aviajes != null){
                    $venta_bp->aviajes = $request->aviajes;
                }
                if($request->has('tpago')){
                    $venta_bp->tipo_pago = $request->tpago;
                }
                if($request->laerea != null){
                    $venta_bp->laereas_id = $request->laerea;
                }
                if($request->consolidadors != null){
                    $venta_bp->consolidadores_id = $request->consolidadors;
                }
                $venta_bp->neto             = $request->dneto;
                $venta_bp->tarifa           = $request->dtarifa;
                $venta_bp->comision_agencia = $request->dcomi;
                $venta_bp->igv              = $request->digv;
                $venta_bp->total            = $request->dtotal;
                $venta_bp->pago_consolidador= $request->dconso;
                $venta_bp->tarifa_fee       = $request->dtarifaf;
                $venta_bp->utilidad         = $request->dutilidad;
                $venta_bp->incentivo        = $request->dincentivo;
                if($request->porcentaje != null){
                    $venta_bp->comision         = $request->porcentaje;
                }
                $venta_bp->update();

                if($deuda_agencia_viaje->count() == 0){
                    if($request->tpago == 7){
                        if($request->aviajes == null) $aviajes = $venta_bp->aviajes;
                        else $aviajes = $request->aviajes;

                        if(!$request->has('tpago')) $tipo_pago = $venta_bp->tipo_pago;
                        else $tipo_pago = $request->tpago;

                        if($request->laerea == null) $laereas_id = $venta_bp->laereas_id;
                        else $laereas_id = $request->laerea;

                        if($request->consolidadors == null) $consolidadores_id = $venta_bp->consolidadores_id;
                        else $consolidadores_id = $request->consolidadors;

                        DeuagenciaViajes::create([
                            'fecha'             => $request->fechai,
                            'venta_boleto_id'   => $venta_bp->venta_boleto_id,
                            'nro_ticket'        => $request->dtikets,
                            'dni_ruc'           => $venta_bp->cliente_id,
                            'nombre_cliente'    => $venta_bp->nombre_cliente,
                            'laereas_id'        => $laereas_id,
                            'ruta'              => $venta_bp->ruta,
                            'consolidadores_id' => $consolidadores_id,
                            'aviajes_id'        => $aviajes,
                            'tarifa_fee'        => $request->dtarifaf,
                            'porpagar'          => $request->dtarifaf,
                            'agentes_id'        => $venta_bp->agentes_id,
                            'diasc'             => $request->dvaloreninput,
                            'status'            => 0,
                            'users_id'          => $venta_bp->users->id,
                            'anulado'           => 0,
                        ]);
                    }
                }
            }
        }

        if($deuda_agencia_viaje->count() > 0){
            foreach($deuda_agencia_viaje as $deuda){
                if($request->aviajes != null){
                    $deuda->aviajes_id = $request->aviajes;
                }
                if($request->laerea != null){
                    $deuda->laereas_id = $request->laerea;
                }
                if($request->consolidadors != null){
                    $deuda->consolidadores_id = $request->consolidadors;
                }
                $deuda->tarifa_fee = $request->dtarifaf;
                $deuda->porpagar = $request->dtarifaf;
                $deuda->update();
            }
        }

        // FIN DE LA LOGICA

        $vboletos3 = DeupagoConsolidadores::where('nro_ticket','=',$dnro_ticket)->get();
        if($vboletos3) {
            for ($i = 0; $i < sizeof($vboletos3); $i++) {
                if($request->has('aviajes')){
                    $vboletos3[$i]->aviajes_id=$request->aviajes;
                }
                if($request->has('laerea')){
                    $venta_boleto_p[$i]->laereas_id=$request->laerea;
                }
                if($request->has('consolidadors')){
                    $venta_boleto_p[$i]->consolidadores_id=$request->consolidadors;
                }
                $vboletos3[$i]->comision_agencia=$request->dcomi;
                $vboletos3[$i]->igv=$request->digv;
                $vboletos3[$i]->total=$request->dtotal;
                $vboletos3[$i]->pago_consolidador=$request->dconso;
                $vboletos3[$i]->save();
            }
        }



        $message = $venta_boleto_p  ? 'Se Actualizo el ticket.' : 'Error al actualizar';



        /*--------------------------------------------------------------*/


        // dd(date("Y-m-d H:i:s"));

        if (($request->fechai != "") and ($request->fechaf != "")){
            $fechai = $request->fechai;
            $fechaf = $request->fechaf;
        }else{
            $fechai = date('Y-m-d');
            $fechaf = date('Y-m-d');
        }

        $id =  Auth::User()->id;
        if(Auth::User()->role != "Administrador") {
            /*$vboletos = VboletoP::whereBetween('created_at', ['2018/01/24', '2018/02/06'])->get();*/
            $vboletos = VboletoP::whereBetween('created_at', [$fechai, $fechaf])
                                    ->where('anulado','!=','1')
                                    ->where('users_id', $id)
                                    ->with('consolidadores')
                                    ->get();
        }else{
            $vboletos = VboletoP::whereBetween('created_at', [$fechai, $fechaf])
                        ->where('anulado','!=','1')
                        ->with('consolidadores')
                        ->get();
        }
        /*return response()->json([
                 'datos'=>$vboletos->toArray()
             ]);*/
        $consolidadores = Consolidador::orderBy('nombre','asc')->get();
        $aviajes = Aviaje::orderBy('nombre','asc')->get();
        $laereas = Laerea::orderBy('nombre','asc')->get();
        $vendedor = User::orderBy('nombres','asc')->get();
        $tipop = Tpago::orderBy('pago','asc')->get();
        $incentivos = Incentivo::all();
        $iva = Iva::all()->last();

        return view('vboletos.index',compact('iva','incentivos','vboletos','fechai','fechaf','consolidadores','aviajes','laereas','vendedor','tipop'))->with('message', $message);
    }

    public function update_varios_boletos(Request $request){
        $vboletos = VboletoP::find($request->boletos);
        foreach($vboletos as $boleto){
            if($request->aviaje != null){
                $boleto->aviajes = $request->aviaje;
            }
            if($request->tpago != null){
                if($request->tpago == 7){
                    $deuda_agencia_viaje = DeuagenciaViajes::where('nro_ticket',$boleto->nro_ticket)->get();
                    if($deuda_agencia_viaje->count() > 0){
                        foreach($deuda_agencia_viaje as $deuda){
                            if($request->aviaje != null){
                                $deuda->aviajes_id = $request->aviaje;
                            }
                            if($request->freg != null){
                                $deuda->fecha = $request->freg;
                            } else {
                                $deuda->fecha = $boleto->created_at;
                            }
                            $deuda->update();
                        }
                    } else {
                        if($request->aviaje == null) $aviajes = $boleto->aviajes;
                        else $aviajes = $request->aviaje;

                        if($request->freg != null){
                            $fecha = $request->freg;
                        } else {
                            $fecha = $boleto->created_at;
                        }

                        DeuagenciaViajes::create([
                            'fecha'             => $fecha,
                            'venta_boleto_id'   => $boleto->venta_boleto_id,
                            'nro_ticket'        => $boleto->nro_ticket,
                            'dni_ruc'           => $boleto->cliente_id,
                            'nombre_cliente'    => $boleto->nombre_cliente,
                            'laereas_id'        => $boleto->laereas_id,
                            'ruta'              => $boleto->ruta,
                            'consolidadores_id' => $boleto->consolidadores_id,
                            'aviajes_id'        => $aviajes,
                            'tarifa_fee'        => $boleto->tarifa_fee,
                            'porpagar'          => $boleto->tarifa_fee,
                            'agentes_id'        => $boleto->agentes_id,
                            'diasc'             => 0,
                            'status'            => 0,
                            'users_id'          => $boleto->users_id,
                            'anulado'           => 0,
                        ]);
                    }
                }
                $boleto->tipo_pago = $request->tpago;
            }
            if($request->freg != null){
                $boleto->created_at = $request->freg;
            }
            $boleto->update();
        }
        return;
    }

    public function doc_cobranza(Request $request){

        $cobranza = VboletoP::where('nro_ticket',$request->tk)->get();
        $destination = 'uploads/documentos_cobranza/';
        $image = $request->file('doc_cobranza');
        $random = str_random(6);
        $fechai = $request->fechai;
        $fechaf =$request->fechaf;
        if (!empty($image)) {
            $filename = $request->nro_ticket. $random.  $image->getClientOriginalName();
            $image->move($destination, $filename);
        }else{
            $filename = NULL;
        }
        for ($i = 0; $i < sizeof($cobranza); $i++) {
            $cobranza[$i]->doc_cobranza = $filename;
            $cobranza[$i]->save();
        }

        $id =  Auth::User()->id;
        if(Auth::User()->role != "Administrador") {
            /*$vboletos = VboletoP::whereBetween('created_at', ['2018/01/24', '2018/02/06'])->get();*/
            $vboletos = VboletoP::whereBetween('created_at', [$fechai, $fechaf])->where('anulado','!=','1')->where('users_id', $id)->with('consolidadores')->get();
        }else{
            $vboletos = VboletoP::whereBetween('created_at', [$fechai, $fechaf])->where('anulado','!=','1')->with('consolidadores')->get();
        }
        /*return response()->json([
                 'datos'=>$vboletos->toArray()
             ]);*/
        $consolidadores = Consolidador::orderBy('nombre','asc')->get();
        $aviajes = Aviaje::orderBy('nombre','asc')->get();
        $laereas = Laerea::orderBy('nombre','asc')->get();
        $vendedor = User::orderBy('nombres','asc')->get();
        $tipop = Tpago::orderBy('pago','asc')->get();
        $incentivos = Incentivo::all();
        $message = 'Se registro satisfactoriamente un documento de cobranza para el '. $request->tk;
        return view('vboletos.index',compact('incentivos','vboletos','fechai','fechaf','consolidadores','aviajes','laereas','vendedor','tipop'))->with('message', $message);

    }

    public function status(Request $request, $id){

        $Vboletos = User::where('id','=', $id)->first();
        if ($Vboletos->active == '0'){
            $Vboletos= Vboleto::find($id);
            $Vboletos = User::where('id','=', $id)->first();
            $Vboletos->active   = "1";
            $Vboletos->save();
            $message = $Vboletos?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageVboleto-A')->with('message', $message);
        }else {
            if ($Vboletos->active == '1')
                $Vboletos = User::find($id);
            $Vboletos = User::where('id', '=', $id)->first();
            $Vboletos->active = "0";
            $Vboletos->save();
            $message = $Vboletos ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageVboleto-A')->with('message', $message);
        }
    }



    public function show($id){
        $Vboletos = Vboleto::all()->lists('name', 'id');
        return view('vboletos.show');

    }


    public function destroy($id){

        $Vboletos = Vboleto::find($id);
        $Vboletos->delete($id);
        $message = $Vboletos?'Registro eliminado correctamente' : 'Error al Eliminar';

        return redirect()->route('manageVboleto-A')->with('message', $message);

    }

    public function invoice($nro_ticket)
    {
        $ticket = $nro_ticket;
        $data = $this->getData($ticket);
        $view =  \View::make('vboletos.pdf', compact('data'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('pdf');
    }

    public function getData($ticket)
    {
        $data =  VboletoP::where('nro_ticket',$ticket)->first();
        return $data;
    }

    public function tempData($ticket)
    {
        $data =  VboletoP::where('nro_ticket',$ticket)->first();
        return view('vboletos.pdf');
    }
}
