<?php

namespace App\Http\Controllers\Pagina;

use Auth;
use App\Banco;
use App\Tpago;
use App\Bancog;
use App\Aviaje;
use App\Cliente;
use App\Comision;
use App\Consolidador;
use App\Pagina\OtroVenta;
use App\Pagina\QantuVenta;
use App\Pagina\OtroTarifa;
use App\Pagina\QantuTarifa;
use App\Pagina\PaqueteVenta;
use App\Pagina\PaqueteAbono;
use Illuminate\Http\Request;
use App\Pagina\PaginaListado;
use App\Pagina\BancoPagoPaquete;
use App\Pagina\CotizacionPaquete;
use App\Pagina\PaqueteTarifaVenta;
use App\Http\Controllers\Controller;

class VentaOtroProveedorController extends Controller
{
    public function index(Request $request){
    	$cotizacion = CotizacionPaquete::find($request->proveedor)->load("agencia","pais");
		$proveedores = Consolidador::all(["id","nombre"]);
		$tipo_pagos= Tpago::all();
		$bancos = Banco::all();
        $bancosg = Bancog::all();
    	return view("adminweb.paquetes.cotizacion.proceso.otro.index",compact("cotizacion","proveedores","tipo_pagos","bancos","bancosg"));
    } 
    public function comision ($id){
    	$comision = Comision::where("consolidadores_id",$id)->where("only_operator",1)->pluck("comision")->first();
    	if(empty($comision)){
    		$comision = 0;
    	}
    	return $comision;
	}
	public function procesar(Request $request){
		//DATOS DE LA COTIZACION 
		$cotizacion_paquete = CotizacionPaquete::findOrFail($request->datos_venta['cotizacion_id']);
		//BOLETOS
		foreach ($request->boletos as $index => $nuevo_boleto) {
			//VERIFICO MI CLIENTE
			$cliente = $this->tool_check_client($request->pasajeros[$index]);
			/* CREO MI BOLETO */
			$nuevo_boleto = PaqueteVenta::create([
				'nacionalidad'    => $cotizacion_paquete->nacionalidad,
				'costo_neto'      => $request->boletos[$index]['neto'],
				'incentivo'       => $request->boletos[$index]['incentivo'],
				'user_id'         => Auth::id(),
				'cliente_id'      => $cliente['id'],
				'comision'        => $request->datos_venta['comision'],
				'cotizacion_id'   => $cotizacion_paquete->id,
				'total_venta'     => $request->boletos[$index]['tarifa_fee'],
				'pago_mayorista'  => $request->boletos[$index]['pago_mayorista'],
				'a_pagar'         => $request->boletos[$index]['utilidad'],
				'update_by'       => Auth::User()->nombres." ".Auth::User()->apellidos,
				'fecha'           => date("Y-m-d")
			]);
			//AGREGAMOS EL VALOR A_PAGAR DE PAQUETEVENTA A COTIZACION PARA CREAR UNA DEUDA POSITIVA 
			$cotizacion_paquete->por_pagar += $request->boletos[$index]['tarifa_fee'];
			$cotizacion_paquete->estado		= "procesado";
			$cotizacion_paquete->update();
			// ABONO
			$datos_abono = PaqueteAbono::create([
				'monto'             => $request->datos_pago['monto_cancelar'],
                'tipo_pago'         => $request->datos_pago['tipo'],
                'paquete_venta_id'  => $nuevo_boleto->id
			]);
	 		// SI ES DIFERENTE DE EFECTIVO
			if ($request->datos_pago['tipo'] != 1) {
				$banco = BancoPagoPaquete::create([
					'banco_emisor'       => $request->datos_pago['banco_emisor'],
					'banco_receptor'     => $request->datos_pago['banco_receptor'],
					'numero_operacion'   => $request->datos_pago['nro_operacion'],
					'paquete_abono_id'   => $datos_abono->id
				]);
			}
			// CREAMOS EL OTRO_VENTAS
			$otro_venta = OtroVenta::create([
				'proveedor_id'     => $request->datos_venta['agencia_viaje'],
				'tipo'             => $request->datos_venta['tipo_venta'],
				'paquete_venta_id' => $nuevo_boleto->id
			]);
		}
		// ACTUALIZO LA COTIZACION
		$cotizacion_paquete->por_pagar -= $request->datos_pago['monto_cancelar'];
		$cotizacion_paquete->update();
		if ($cotizacion_paquete->por_pagar <= 0) {
			foreach ($cotizacion_paquete->boletos as $boleto) {
				$boleto->estado = "Cancelado";
				$boleto->update();
			}
		}
		//return $request->all();
		return $cotizacion_paquete;
	}
	public function tool_check_client($cliente){
		if($cliente['id'] == 0){
			$nuevo_cliente = new Cliente();
			$nuevo_cliente->tipo_documento 	= $cliente['tipo_documento'];
			$nuevo_cliente->empresas_id 	= 1;
			$nuevo_cliente->cedula_rif  	= $cliente['dni'];
			$nuevo_cliente->nombre      	= $cliente['nombres'];
			$nuevo_cliente->apellido    	= $cliente['apellidos'];
			$nuevo_cliente->telefono    	= $cliente['telefono'];
			$nuevo_cliente->email       	= $cliente['email'];
			$nuevo_cliente->direccion		= $cliente['direccion'];
			$nuevo_cliente->tipo_pasajero	= $cliente['tipo'];
			$nuevo_cliente->users_id 		= Auth::User()->id;
			$nuevo_cliente->save();
			return $nuevo_cliente;
		}else{
			return $cliente;
		}
	}
}
