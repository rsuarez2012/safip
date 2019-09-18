<?php

namespace App\Http\Controllers;

use Auth;
use Excel;
use App\User;
use App\Role;
use App\Tpago;
use App\Banco;
use App\Bancog;
use App\Vboleto;
use App\Empresa;
use App\VboletoP;
use App\Sucursal;
use Carbon\Carbon;
use App\DagenciaViajes;
use App\Contabilidadopb;
use App\DeuagenciaViajes;
use Illuminate\Http\Request;
use App\DpagoConsolidadores;
use App\Coperacionesbancarias;
use App\DeupagoConsolidadores;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Facades\Datatables;

class CoperacionesbancariasController extends Controller
{
    protected $all_item_excel;

    public function __construct() {
        $this->middleware('web');
        $this->all_item_excel = [];
    }

    /* INICIO FUNCIONES CREADAS POR CESSARE JULIUS */

    public function load_data_ope($fecha_d, $fecha_h){
        $opebanks_ident = Coperacionesbancarias::whereBetween('fecha', [$fecha_d, $fecha_h])->where('status', 'identificado')->get();
        $opebanks_no_ident = Coperacionesbancarias::whereBetween('fecha', [$fecha_d, $fecha_h])->where('status', 'no_identificado')->get();
        $pay_types = Tpago::all();
        $receptor_banks = Banco::all();
        $emisor_banks = Bancog::all();

        //return $opebanks_ident;
        foreach ($opebanks_ident as $index => $obj) {
            $deudas_agencia = DeuagenciaViajes::where('nro_operacion', $obj->nro_operacion)->get();
            $deudas_agencia->load('consolidadores', 'laereas');
            $array = $obj->toArray();
            $array['deuda_agencia'] = $deudas_agencia->toArray();
            //dd($array);
            $opebanks_ident[$index] = $array;
        }


        return response()->json([
            'pay_types' => $pay_types,
            'emisor_banks' => $emisor_banks,
            'receptor_banks' => $receptor_banks,
            'opebanks_ident' => $opebanks_ident,
            'opebanks_no_ident' => $opebanks_no_ident,
        ]);
    }

    public function tool_load_data_deudas($deudas_agencia, $monto){
        if($deudas_agencia->count() > 0){
            $total_deudas = [];
            foreach ($deudas_agencia as $deuda) {
                if(/*floatval($deuda->porpagar) <= floatval($monto) &&*/ floatval($deuda->porpagar) > 0){
                    array_push($total_deudas, $deuda);
                }
            }
            $deudas_agencia = $total_deudas;
        }
        return $deudas_agencia;
    }

    public function load_data_deudas_agencia($nro_ope, $monto){
        $deudas_agencia = DeuagenciaViajes::where('nro_operacion', $nro_ope)->get();
        $deudas_agencia->load('consolidadores', 'laereas');
        $deudas_agencia = $this->tool_load_data_deudas($deudas_agencia, $monto);
        return response()->json([
            'deudas_agencia' => $deudas_agencia,
        ]);
    }

    public function load_data_deudas_fechas($fecha_d, $fecha_h, $monto){
        $deudas_agencia = DeuagenciaViajes::whereBetween('fecha', [$fecha_d, $fecha_h])->get();
        $deudas_agencia->load('consolidadores', 'laereas');
        $deudas_agencia = $this->tool_load_data_deudas($deudas_agencia, $monto);
        return response()->json([
            'deudas_agencia' => $deudas_agencia,
        ]);
    }


    // PAGOS A CONSOLIDADORES

    public function load_data_deudas_pagos_conso($nro_ope, $monto){
        $deudas_pagos_conso = DeupagoConsolidadores::where('nro_operacion', $nro_ope)->where('anulado','!=','1')->get();
        $deudas_pagos_conso->load('laereas', 'consolidadores');
        $deudas_pagos_conso = $this->tool_load_data_deudas($deudas_pagos_conso, $monto);
        return response()->json([
            'deudas_pagos_conso' => $deudas_pagos_conso,
        ]);
    }

    public function load_data_deudas_pagos_conso_fechas($fecha_d, $fecha_h, $monto){
        $deudas_pagos_conso = DeupagoConsolidadores::whereBetween('fecha', [$fecha_d, $fecha_h])->where('anulado','!=','1')->get();
        $deudas_pagos_conso->load('laereas', 'consolidadores');
        $deudas_pagos_conso = $this->tool_load_data_deudas($deudas_pagos_conso, $monto);
        return response()->json([
            'deudas_pagos_conso' => $deudas_pagos_conso,
        ]);
    }

    // END PAGOS

    public function processExcel(Request $request){
        $file = $request->file('file');
        //dd($file);
        $data = Excel::load($file, function($reader) {
            //$reader->formatDates(false);
        })->get();

        /*dd($data[0][756], $data[0][756]['fecha'], $data[0][757], $data[0][757]['fecha']);
        $ar_item = explode('/', str_replace('-', '/', $data[0][753]['fecha']));
        dd($ar_item);
        $fecha = $ar_item[0];
        if(strlen($ar_item[2]) == 2){
            $ar_item[2] = '20'.$ar_item[2];
            if(intval($ar_item[1]) > 12){
                $fecha = $ar_item[1].'/'.$ar_item[0].'/'.$ar_item[2];
            } else {
                $fecha = $ar_item[0].'/'.$ar_item[1].'/'.$ar_item[2];
            }
        } else if(count($ar_item) > 1){
            //dd($ar_item, $fecha, 'hola 1');
            $fecha = $ar_item[1].'/'.$ar_item[0].'/'.$ar_item[2];
        }
        //dd($ar_item, $fecha, 'hola 2');
        if($fecha !== $ar_item[0].'/'.$ar_item[1].'/'.$ar_item[2]){
            if(intval($ar_item[1]) > 12){
                $fecha = $ar_item[1].'/'.$ar_item[0].'/'.$ar_item[2];
            } else {
                $fecha = $ar_item[0].'/'.$ar_item[1].'/'.$ar_item[2];
            }
        } else {
            if(intval($ar_item[1]) > 12){
                $fecha = $ar_item[1].'/'.$ar_item[0].'/'.$ar_item[2];
            }
        }
        $ar_item = explode('/', $fecha);
        dd($ar_item, $fecha, $data[0][753]);*/

        $file->move('files', $file->getClientOriginalName());
        if($data->getTitle() == ""){
            foreach ($data as $i => $row) {
                $this->tool_row_process_excel($row);
            }
        } else $this->tool_row_process_excel($data);

        //dd($this->all_item_excel);
        
        $bancos = Bancog::all();
        $data = $this->all_item_excel;
        $this->all_item_excel = [];
        //dd($data);
        return view('opebanks.process_excel', compact('data', 'bancos'));
    }

    public function tool_row_process_excel($row){
        foreach ($row as $index => $value) {
            if($value['fecha'] != null && $value['fecha'] != 'null'){
                // DANGER ZONE
                /*if($value['operacion_numero'] != null){
                    if(intval($value['operacion_numero']) > 0){
                        Coperacionesbancarias::where('nro_operacion', $value['operacion_numero'])->delete();
                    }
                }*/
                //dd($value);
                /*$ar_item = explode('/', str_replace('-', '/', $value['fecha']));
                $fecha = $ar_item[0];
                if(strlen($ar_item[2]) == 2){
                    $ar_item[2] = '20'.$ar_item[2];
                    if(intval($ar_item[1]) > 12){
                        $fecha = $ar_item[1].'/'.$ar_item[0].'/'.$ar_item[2];
                    } else {
                        $fecha = $ar_item[0].'/'.$ar_item[1].'/'.$ar_item[2];
                    }
                } else if(count($ar_item) > 1){
                    $fecha = $ar_item[1].'/'.$ar_item[0].'/'.$ar_item[2];
                }
                if($fecha !== $ar_item[0].'/'.$ar_item[1].'/'.$ar_item[2]){
                    if(intval($ar_item[1]) > 12){
                        $fecha = $ar_item[1].'/'.$ar_item[0].'/'.$ar_item[2];
                    } else {
                        $fecha = $ar_item[0].'/'.$ar_item[1].'/'.$ar_item[2];
                    }
                } else {
                    if(intval($ar_item[1]) > 12){
                        $fecha = $ar_item[1].'/'.$ar_item[0].'/'.$ar_item[2];
                    }
                }
                $ar_item = explode('/', $fecha);*/
                $item = [
                    'index'                     => $index,
                    'fecha'                     => /*Carbon::createFromDate($ar_item[2], $ar_item[1], $ar_item[0])*/$value['fecha']->toDateTimeString(),
                    'descripcion_operacion'     => $value['descripcion_operacion'],
                    'monto'                     => $value['monto'],
                    'saldo'                     => $value['saldo'],
                    'sucursal_agencia'          => $value['sucursal_agencia'],
                    'operacion_numero'          => $value['operacion_numero'],
                    'operacion_hora'            => $value['operacion_hora'],
                    'usuario'                   => $value['usuario'],
                    'utc'                       => $value['operacion_numero'],
                    'referencia_2'              => $value['referencia_2'],
                    '0'                         => '0',
                ];
                array_push($this->all_item_excel, $item);
            } //else dd('El campo fecha se encuentra en nulo en el registro: '.($index+1).', Nro de operacion: '.$value['operacion_numero'], $value);
        }
    }

    public function save_process_excel(Request $request){
        $exists = [];
        $no_exists = [];
        $crear = true;
        $message = '';
        $type = 1;
        foreach ($request->registros as $item) {
            if($item['operacion_numero'] > 0){
                $opes = Coperacionesbancarias::where('nro_operacion', $item['operacion_numero'])->get();
                	/*return response()->json([
			            'type'  => $type,
			            'message' => $message,
			            'data_exists' => $exists,
			            'data_no_exists' => $no_exists,
			            'opes'	=> $opes,
			        ], 200);*/
			    $positivo = !1;
			    $negativo = !1;
                if($opes->count() > 0){
                    foreach ($opes as $ope) {
                        if(floatval($ope->monto) > 0) $positivo = !0;
                        if(floatval($ope->monto) <= 0) $negativo = !0;
                    }
                    if($positivo && $negativo){
                        array_push($exists, $item);
                        $crear = !1;
                    } else if($positivo && !$negativo){
                        if(floatval($item['monto']) > 0){
                            array_push($exists, $item);
                            $crear = !1;
                        } else $crear = !0;
                    } else if(!$positivo && $negativo){
                        if(floatval($item['monto']) <= 0){
                            array_push($exists, $item);
                            $crear = !1;
                        } else $crear = !0;
                    } else $crear = !0;
                } else $crear = !0;
            } else if($item['operacion_numero'] == 0) $crear = !0;

            if($crear){
                $h = '';
                if(is_array($item['operacion_hora'])){
                    $item['operacion_hora'] = $item['operacion_hora']['date'];
                }
                if($item['operacion_hora'] != null){
                    $ar_f = explode(" ", $item['operacion_hora']);
                    if(count($ar_f) > 1){
                        $ar_h = explode('.', $ar_f[1]);
                        if(count($ar_h) > 1){
                            $h = $ar_h[0];
                        } else $h = $ar_f[0];
                    } else $h = $ar_f[0];
                }
                Coperacionesbancarias::create([
                    'empresa'           => $request->banco,
                    'moneda'            => $request->moneda,
                    'procedencia'       => 'No Identificado',
                    'tipo_operacion'    => 'No Identificado',
                    'fecha'             => explode(' ', $item['fecha'])[0],
                    'descripcion'       => $item['descripcion_operacion'],
                    'monto'             => $item['monto'],
                    'saldo'             => $item['saldo'],
                    'sucursal'          => $item['sucursal_agencia'],
                    'nro_operacion'     => $item['operacion_numero'],
                    'hora_operacion'    => $h,
                    'usuario'           => $item['usuario'],
                    'utc'               => $item['utc'],
                    'referencia'        => $item['referencia_2'],
                ]);
                array_push($no_exists, $item);
            }
        }
        if(count($exists) > 0 && count($no_exists) == 0){
            $message = 'Todas las operaciones seleccionadas ya se cuentran registradas!.';
            $type = 0;
        } else if(count($exists) > 0 && count($no_exists) > 0){
            $message = 'Operaciones seleccionadas procesadas pero algunas ya se encuentran registradas!.';
            $type = 2;
        } else if(count($exists) == 0 && count($no_exists) > 0){
            $message = 'Todos los registros procesados con exito!.';
            $type = 1;
        }
        return response()->json([
            'type'  => $type,
            'message' => $message,
            'data_exists' => $exists,
            'data_no_exists' => $no_exists,
        ], 200);
    } 

    public function register_payments_deudas(Request $request){
        /*return response()->json([
            'request' => $request->all(),
        ], 200);*/

        // Validacion para cada nro de operacion de cada pago que se va a realizar segun el tipo que venga ['conso', 'deuda']
        if($request->rg_sm){
            foreach ($request->sm['pagos'] as $pg) {
                if($pg['type'] != 1){
                    if($request->type == 'deuda'){
                        $dag = DagenciaViajes::where('nro_operacion', $pg['nro_ope'])->first();
                    } else if($request->type == 'conso'){
                        $dag = DpagoConsolidadores::where('nro_operacion', $pg['nro_ope'])->first();
                    }
                    if($dag != null){
                        return response()->json([
                            'message' => 'El Nro de Operacion: '.$pg['nro_ope'].' ya se encuentra registrado!.',
                        ], 409);
                    }
                }
            }
        } else {
            foreach ($request->deudas as $deu) {
                foreach ($deu['pagos'] as $pg) {
                    if($pg['type'] != 1){
                        if($request->type == 'deuda'){
                            $dag = DagenciaViajes::where('nro_operacion', $pg['nro_ope'])->first();
                        } else if($request->type == 'conso'){
                            $dag = DpagoConsolidadores::where('nro_operacion', $pg['nro_ope'])->first();
                        }
                        if($dag != null){
                            return response()->json([
                                'message' => 'El Nro de Operacion: '.$pg['nro_ope'].' ya se encuentra registrado!.',
                            ], 409);
                        }
                    }
                }
            } 
        }

        foreach ($request->deudas as $deuda_req) {
        	$vboleto = null;
            if($request->type == 'deuda'){
                $deuda = DeuagenciaViajes::findOrFail($deuda_req['id']);
            } else if($request->type == 'conso'){
                $deuda = DeupagoConsolidadores::findOrFail($deuda_req['id']);
            }
            
            if($request->rg_sm){
                if(floatval($deuda_req['tarifa_fee']) == floatval($deuda_req['porpagar'])){
                    $vboleto = VboletoP::where('nro_ticket', $deuda_req['nro_ticket'])->first();
                    if($vboleto != null){
                        $vboleto->pagado    = 1;
                    }
                    $deuda->status      = 1;
                    $deuda->porpagar    = 0;//$request->sm['resta'];
                } else {
                    $deuda->porpagar    = $deuda_req['excedente'];
                }
            } else {
                $vboleto = VboletoP::where('nro_ticket', $deuda_req['ticket'])->first();
                if($deuda_req['resta'] == 0){
                    if($vboleto != null){
                        $vboleto->pagado    = 1;
                    }
                    $deuda->status      = 1;
                    $deuda->porpagar    = $deuda_req['resta'];
                }else{
                    if($vboleto != null){
                        $vboleto->pagado    = 0;
                    }
                    $deuda->status      = 0;
                    $deuda->porpagar    = $deuda_req['resta'];
                }
            }

            $deuda->nro_operacion = $request->operation['nro_operacion'];
            if($vboleto != null){
                if($vboleto->nro_operacion == null || $vboleto->nro_operacion == ''){
                    $vboleto->nro_operacion = $request->operation['nro_operacion'];
                }
            }

            $deuda->update();
            if($vboleto != null){
                $vboleto->update();
            }

            if($request->type == 'deuda'){
                if($request->rg_sm){
                    $pagos = DagenciaViajes::where('venta_boleto_id', $deuda_req['venta_boleto_id'])
                                        ->where('nro_ticket', $deuda_req['nro_ticket'])
                                        ->get();

                } else {
                    $pagos = DagenciaViajes::where('venta_boleto_id', $deuda_req['nro_cot'])
                                        ->where('nro_ticket', $deuda_req['ticket'])
                                        ->get();
                }
            } else if($request->type == 'conso'){
                if($request->rg_sm){
                    $pagos = DpagoConsolidadores::where('venta_boleto_id', $deuda_req['venta_boleto_id'])
                                    ->where('nro_ticket', $deuda_req['nro_ticket'])
                                    ->get();
                } else {
                        $pagos = DpagoConsolidadores::where('venta_boleto_id', $deuda_req['nro_cot'])
                                    ->where('nro_ticket', $deuda_req['ticket'])
                                    ->get();  
                }
            }

            /*if($pagos->count() > 0){
                foreach ($pagos as $p) {
                    $p->delete();
                }
            }*/

            if($request->rg_sm){
                foreach ($request->sm['pagos'] as $pago) {
                    if($request->type == 'deuda'){
                        DagenciaViajes::create([
                            'venta_boleto_id'           => $deuda_req['venta_boleto_id'],
                            'nro_ticket'                => $deuda_req['nro_ticket'],
                            'abono'                     => floatval($pago['abono']),
                            'tipo_pago'                 => $pago['type'],
                            'banco_emisor'              => $pago['banco_emi'],
                            'banco_receptor'            => $pago['banco_recep'],
                            'nro_operacion'             => $pago['nro_ope'],
                            'nro_operacion_bancaria'    => $request->operation['nro_operacion'],
                        ]);
                    } else if($request->type == 'conso'){
                        DpagoConsolidadores::create([
                            'venta_boleto_id'           => $deuda_req['venta_boleto_id'],
                            'nro_ticket'                => $deuda_req['nro_ticket'],
                            'abono'                     => floatval($pago['abono']),
                            'tipo_pago'                 => $pago['type'],
                            'banco_emisor'              => $pago['banco_emi'],
                            'banco_receptor'            => $pago['banco_recep'],
                            'nro_operacion'             => $pago['nro_ope'],
                            'nro_operacion_bancaria'    => $request->operation['nro_operacion'],
                        ]);
                    }
                }
            } else {
                foreach ($deuda_req['pagos'] as $pago) {
                    if($request->type == 'deuda'){
                        DagenciaViajes::create([
                            'venta_boleto_id'           => $deuda_req['nro_cot'],
                            'nro_ticket'                => $deuda_req['ticket'],
                            'abono'                     => floatval($pago['abono']),
                            'tipo_pago'                 => $pago['type'],
                            'banco_emisor'              => $pago['banco_emi'],
                            'banco_receptor'            => $pago['banco_recep'],
                            'nro_operacion'             => $pago['nro_ope'],
                            'nro_operacion_bancaria'    => $request->operation['nro_operacion'],
                        ]);
                    } else if($request->type == 'conso'){
                        DpagoConsolidadores::create([
                            'venta_boleto_id'           => $deuda_req['nro_cot'],
                            'nro_ticket'                => $deuda_req['ticket'],
                            'abono'                     => floatval($pago['abono']),
                            'tipo_pago'                 => $pago['type'],
                            'banco_emisor'              => $pago['banco_emi'],
                            'banco_receptor'            => $pago['banco_recep'],
                            'nro_operacion'             => $pago['nro_ope'],
                            'nro_operacion_bancaria'    => $request->operation['nro_operacion'],
                        ]);
                    }
                }
            }
        }
        $ope_bank = Coperacionesbancarias::find($request->operation['id']);
        $ope_bank->procedencia = $request->proced;
        $ope_bank->tipo_operacion = $request->option[0]['acron']; 
        $ope_bank->status = 'identificado';
        $ope_bank->update();

        return response()->json([
            'message' => 'Pagos procesados exitosamente!.',
        ], 200);
    }

    public function register_gastos(Request $request){
        /*return response()->json([
            'request' => $request->all(),
        ], 200);*/

        $ope_bank = Coperacionesbancarias::find($request->operation['id']);
        $ope_bank->procedencia      = $request->proced;
        $ope_bank->tipo_operacion   = $request->option[0]['acron'];
        $ope_bank->descripcion      = $request->descripcion_gasto;
        $ope_bank->status           = 'identificado';
        $ope_bank->update();

        if($request->add_contability){
            Contabilidadopb::create([
                'monto'         => $ope_bank->monto,
                'tipo'          => $request->tipo_gasto,
                'sucursal'      => $request->sucursal,
                'nro_operacion' => $request->operation['nro_operacion'],
                'fecha'         => $ope_bank->fecha,
            ]);
        }

        return response()->json([
            'message' => 'Gasto procesado exitosamente!.',
        ], 200);
    }

    public function delete_ope_bank(Request $request){
        $ope_bank = Coperacionesbancarias::findOrFail($request->operation);
        $ope_bank->delete();
        return response()->json([
            'message' => 'Operación Bancaria eliminada exitosamente!.',
        ], 200);
    }

    // FIN FUNCTIONS CREATED'S BY CJ

    public function getManageCoperacionesbancarias(Request $request){
       
        if (($request->fechai != "") and ($request->fechaf != "")){
            $fechai = $request->fechai;
            $fechaf = $request->fechaf;
        }else{
            $fechai = date('Y-m-d');
            $fechaf = date('Y-m-d');
        }

        $operaciones = Coperacionesbancarias::whereBetween('fecha', [$fechai, $fechaf])->get();
        $contador = Coperacionesbancarias::count();
        $bancosg = Bancog::all();
        //dd($operaciones);
        return view('coperacionesbancarias.index',compact('operaciones','contador','fechai','fechaf','bancosg'));

    }
    public function getManageCoperacionesbancariasfecha(Request $request){
        if ($request->fechai == "" || $request->fechaf == ""){
            $fechai = date('Y-m-d');
            $fechaf = date('Y-m-d');
        }else{
            /* dd("lleno"); */
            $fechai = $request->fechai;
            $fechaf = $request->fechaf;
        }


        $operaciones =  Coperacionesbancarias::whereBetween('fecha', [$fechai, $fechaf])->get();
        $contador = Coperacionesbancarias::count();
        $bancosg = Bancog::all();
        //dd($operaciones);
        return view('coperacionesbancarias.index',compact('operaciones','contador','fechai','fechaf','bancosg'));

    }

    public function consultabancos(Request $request){
        if (($request->fechai != "") and ($request->fechaf != "")){
            $fechai = $request->fechai;
            $fechaf = $request->fechaf;
        }else{
            $fechai = date('Y-m-d');
            $fechaf = date('Y-m-d');
        }
        $banco = $request->bancoem;
        $operacionespos =  Coperacionesbancarias::where('empresa',$request->bancoem)->where('status','=','Identificado')->whereBetween('fecha', [$fechai, $fechaf])->get();
        $operacionesneg =  Coperacionesbancarias::where('empresa',$request->bancoem)->where('status','=','NO identificado')->whereBetween('fecha', [$fechai, $fechaf])->get();
        $contador = Coperacionesbancarias::count();
        $bancosg = Bancog::all();
        return view('coperacionesbancarias.totalesbancos',compact('operacionespos', 'operacionesneg','contador','fechai','fechaf','bancosg','banco'));

    }
    public function consultabancosi(Request $request){
        if (($request->fechai != "") and ($request->fechaf != "")){
            $fechai = $request->fechai;
            $fechaf = $request->fechaf;
        }else{
            $fechai = date('Y-m-d');
            $fechaf = date('Y-m-d');
        }
        $banco = "";
        $operacionespos =  "0";
        $operacionesneg =  "0";
        $contador = Coperacionesbancarias::count();
        $bancosg = Bancog::all();
        return view('coperacionesbancarias.totalesbancos',compact('operacionespos', 'operacionesneg','contador','fechai','fechaf','bancosg','banco'));

    }
    public function getManageCoperacionesbancariasbusqueda(Request $request)
    {
        if (($request->fechai != "") and ($request->fechaf != "")){
            $fechai = $request->fechai;
            $fechaf = $request->fechaf;
        }else{
            $fechai = date('Y-m-d');
            $fechaf = date('Y-m-d');
        }
//dd($request->all());
        $consulta= Coperacionesbancarias::select('id','procedencia','tipo_operacion','fecha','descripcion','monto', 'saldo' ,
            'sucursal','nro_operacion','hora_operacion',
            'usuario','utc','referencia','status',
            'empresa','moneda','created_at','updated_at');

        /*---------------------------------------Estatus lleno------------------*/
        if ($request->has('statusm')){
            if($request->has('status')){
                $consulta->Where('status',$request->statusm);
            }

            if($request->has('bancoem')){
                $consulta->Where('empresa',$request->bancoem);
            }

            if($request->has('monedam')){
                $consulta->Where('moneda',$request->monedam);
            }
            if($request->has('tipom')){
                $consulta->Where('tipo_operacion',$request->tipom);
            }
            $consulta->whereBetween('fecha', [$fechai, $fechaf]);

        }
        /*---------------------------------------Fin Estatus lleno------------------*/
        /*---------------------------------------Banco lleno------------------*/
        if ($request->has('bancoem')){

            if($request->has('bancoem')){
                $consulta->Where('empresa',$request->bancoem);
            }

            if($request->has('status')){
                $consulta->Where('status',$request->statusm);
            }

            if($request->has('monedam')){
                $consulta->Where('moneda',$request->monedam);
            }
            if($request->has('tipom')){
                $consulta->Where('tipo_operacion',$request->tipom);
            }
            $consulta->whereBetween('fecha', [$fechai, $fechaf]);

        }
        /*---------------------------------------Fin Banco lleno------------------*/
        /*---------------------------------------Moneda lleno------------------*/
        if ($request->has('monedam')){
            if($request->has('monedam')){
                $consulta->Where('moneda',$request->monedam);
            }

            if($request->has('bancoem')){
                $consulta->Where('empresa',$request->bancoem);
            }

            if($request->has('status')){
                $consulta->Where('status',$request->statusm);
            }


            if($request->has('tipom')){
                $consulta->Where('tipo_operacion',$request->tipom);
            }
            $consulta->whereBetween('fecha', [$fechai, $fechaf]);

        }
        /*---------------------------------------Fin Moneda lleno------------------*/

        /*---------------------------------------Operacion lleno------------------*/
        if ($request->has('tipom')){
            if($request->has('tipom')){
                $consulta->Where('tipo_operacion',$request->tipom);
            }

            if($request->has('monedam')){
                $consulta->Where('moneda',$request->monedam);
            }

            if($request->has('bancoem')){
                $consulta->Where('empresa',$request->bancoem);
            }

            if($request->has('status')){
                $consulta->Where('status',$request->statusm);
            }
            $consulta->whereBetween('fecha', [$fechai, $fechaf]);

        }
        /*---------------------------------------Fin Operacion lleno------------------*/
        $consulta= $consulta->get();
        $operaciones= $consulta;
        $contador = Coperacionesbancarias::count();
        // dd($request->all(),$consulta);
        $bancosg = Bancog::all();
        //dd($operaciones);
        return view('coperacionesbancarias.index',compact('contador','bancosg'))->with('operaciones',$operaciones)->with('fechai', $fechai)->with('fechaf', $fechaf);
    }

    public function importExcel(){
        $file = Input::file('file');
        $file_name = $file->getClientOriginalName();
        $file->move('files',$file_name); 
        $results = Excel::load('files/'.$file_name, function($reader)
        {
            $reader->all();
        })->get();
        /* dd($results);*/
        $bancos = Bancog::all();

        return view('coperacionesbancarias.operaciones', ['operaciones'=>$results, 'bancos'=>$bancos]);
    }

    public function mostrar(){


        return view('coperacionesbancarias.index');

    }

    public function create(){
        $empresas = Empresa::all();
        $sucursales = Sucursal::all();

        return view('Vboletos.create',  compact('empresas'), compact('sucursales'));
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        for($i=0; $i<sizeof($request->checkeado);$i++){
            $opb = new Coperacionesbancarias();
            $opb->empresa           = $request->empresa;
            $opb->moneda            = $request->moneda;
            $opb->procedencia       = $request->procedencia[$i];
            $opb->tipo_operacion    = $request->tipo_operacion[$i];
            $opb->fecha             = $request->fecha[$i];
            $opb->descripcion       = $request->descripcion[$i];
            $opb->monto             = $request->monto[$i];
            $opb->saldo             = $request->saldo[$i];
            $opb->sucursal          = $request->sucursal[$i];
            $opb->nro_operacion     = $request->nro_operacion[$i];
            $opb->hora_operacion    = $request->hora_operacion[$i];
            $opb->usuario           = $request->usuario[$i];
            $opb->utc               = $request->utc[$i];
            $opb->referencia        = $request->referencia[$i];
            $opb->status            = $request->status[$i];
            $opb->save();

            //return view('welcome');
        }
        $message = $opb ? 'Se ha Guardado de forma exitosa.' : 'Error al Registrar';


        //Session::flash('message', 'Te has registrado exitosamente ');
        return redirect()->route('manageCoperacionesbancarias-A')->with('message', $message);
        /*dd($request->all());*/
    }
    public function storeindex(Request $request){
        /* dd($request->all());   */
        for($i=0; $i<sizeof($request->checkeado);$i++){
            if ($request->checkeado[$i] == 1) {
                $opb = Coperacionesbancarias::where('nro_operacion','=', $request->nro_operacion[$i])
                                            ->where('descripcion','=', $request->descripcion[$i])
                                            ->where('fecha','=', $request->fecha[$i])->first();
                $opb->empresa           = $request->empresa[$i];
                $opb->moneda            = $request->moneda[$i];
                $opb->procedencia       = $request->procedencia[$i];
                $opb->tipo_operacion    = $request->tipo_operacion[$i];
                $opb->fecha             = $request->fecha[$i];
                $opb->descripcion       = $request->descripcion[$i];
                $opb->monto             = $request->monto[$i];
                $opb->saldo             = $request->saldo[$i];
                $opb->sucursal          = $request->sucursal[$i];
                $opb->nro_operacion     = $request->nro_operacion[$i];
                $opb->hora_operacion    = $request->hora_operacion[$i];
                $opb->usuario           = $request->usuario[$i];
                $opb->utc               = $request->utc[$i];
                $opb->referencia        = $request->referencia[$i];
                $opb->status            = $request->status[$i];
                $opb->save();
                //$opb->status = Auth::User()->sucursal;
                if($request->gastos[$i]!=null){
                    $gasto = new Contabilidadopb();
                    $gasto->fecha=$request->fecha[$i];
                    $gasto->monto=$request->monto[$i];
                    $gasto->sucursal=$request->gastos[$i];
                    $gasto->nro_operacion=$request->nro_operacion[$i];
                    $gasto->tipo=$request->descripcion[$i];
                    $gasto->save();
                }

                //return view('welcome');
            }
        }

        $message = 'Se ha Actualizo el Registro exitosamente, *Recuerda que solo se guardaran los items Seleccionados con el el Checkbox que cada linea tiene a su izquierda*';


        //Session::flash('message', 'Te has registrado exitosamente ');
       /*  return redirect()->route('manageCoperacionesbancarias-A')->with('message', $message); */
       return $this->getManageCoperacionesbancariasfecha($request);
        /*dd($request->all());*/
    }

    public function edit($id){

        $Vboletos = Vboleto::where('id','=', $id)->first();
        $empresas = Empresa::all();
        return view('Vboletos.edit')->with('Vboletos', $Vboletos)->with('empresas', $empresas);
    }

    public function update(Request $request, $id){

        $Vboletos= Vboleto::find($id);
        $Vboletos = Vboleto::where('id','=', $id)->first();
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

        $message = $Vboletos?'Se ha actualizado el registro '. $request->nombre .' de forma exitosa.' : 'Error al actualizar';

        return redirect()->route('manageVboleto-A')->with('message', $message);


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

        return view('Vboletos.show');

    }


    public function destroy($id){

        $Vboletos = Vboleto::find($id);
        $Vboletos->delete($id);
        $message = $Vboletos?'Registro eliminado correctamente' : 'Error al Eliminar';

        return redirect()->route('manageVboleto-A')->with('message', $message);

    }
}
