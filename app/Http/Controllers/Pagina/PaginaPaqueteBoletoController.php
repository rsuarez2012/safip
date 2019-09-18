<?php

namespace App\Http\Controllers\Pagina;

use Auth;
use App\Aviaje;
use App\Cliente;
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

class PaginaPaqueteBoletoController extends Controller
{
		public function index(){
		$qantu = [];
		$otro = [];

		if (Auth::user()->role == "Administrador") {
			$boletos  = PaqueteVenta::whereDate('created_at', date('Y-m-d'))->get();
		}else{
			$boletos  = PaqueteVenta::whereDate('created_at', date('Y-m-d'))
			->where('user_id', Auth::id())->get();
		}
		$boletos->load('qantu', 'otro', 'cotizacion.agencia', 'abonos', 'vendedor', 'cliente');
		foreach ($boletos as $boleto) {
			if($boleto->qantu != null){
                array_push($qantu, $boleto);
			} else {
				array_push($otro, $boleto);
			}
		}
		$agencias = Aviaje::all();
		return view("adminweb.paquetes.ventas.index-back",compact('boletos', 'qantu', 'otro','agencias'));
	}


	public function storeBoletoQantu(Request $data){
		$abono = $data->get('pago');
		$boletos = $data->get('listaBoletos');
		for ($i=0; $i < count($boletos) ; $i++) { 
			// BOLETO
			$venta                = new PaqueteVenta();
			$venta->costo_neto    = $boletos[$i]['neto'];
			$venta->nacionalidad  = $boletos[$i]['nacionalidad'];
			$venta->incentivo     = $boletos[$i]['incentivo'];
			$venta->user_id       = Auth::User()->id;
			$venta->cliente_id    = $boletos[$i]['cliente_id'];
			$venta->cotizacion_id = $boletos[$i]['cotizacion_id'];
			$venta->total_venta   = $boletos[$i]['total'];
			$venta->a_pagar       = $boletos[$i]['a_pagar'];
			$venta->save();

			$cotizacion            = CotizacionPaquete::find($venta->cotizacion_id);
			$cotizacion->por_pagar = ($cotizacion->por_pagar + $venta->a_pagar);
			$cotizacion->estado = "procesado";
			$cotizacion->save();

			// ABONOS
			$datos_abono                   = new PaqueteAbono();
			$datos_abono->tipo_pago        = $abono[0]['tipo'];
			$datos_abono->paquete_venta_id = $venta->id;
			$datos_abono->save();
			// SI ES DIFERENTE DE EFECTIVO
			if ($datos_abono->tipo_pago != "Efectivo") {
				$banco               = new BancoPagoPaquete();
				$banco->banco_emisor = $abono[0]['banco_e'];
				$banco->banco_receptor = $abono[0]['banco_r'];
				$banco->numero_operacion = $abono[0]['operacion'];
				$banco->paquete_abono_id = $datos_abono->id;
				$banco->save();
			}
			// GUARDAR DATOS DE PAQUETE QANTU
			$qantu                   = new QantuVenta();
			$qantu->codigo_enlace    = $boletos[$i]['codigo_hoteles'];
			$qantu->tipo_pasajero    = $boletos[$i]['tipo_cliente'];
			$qantu->comision    = $boletos[$i]['comision'];
			// $qantu->tipo_habitacion  = 
			if ($boletos[$i]['tipo_venta'] == "venta") {
				$qantu->tipo         =  "Directa";
			}else{
				$qantu->tipo         =  "Agencia";
			}
			$qantu->porcentaje       = $boletos[$i]['diez'];
			$qantu->paquete_id       = $boletos[$i]['paquete_id'];
			$qantu->paquete_venta_id = $venta->id;
			$qantu->save();

			if ($qantu->tipo == "Directa") {
				$tarifa                 = new PaqueteTarifaVenta();
				$tarifa->tarifa_fee     = $boletos[$i]['tarifa_fee'];
				$tarifa->utilidad       = $boletos[$i]['utilidad'];
				$tarifa->total_utilidad = $boletos[$i]['total_utilidades'];
				$tarifa->save();
				$pivote                          = new QantuTarifa();
				$pivote->qantu_venta_id          = $qantu->id;  
				$pivote->paquete_tarifa_venta_id = $tarifa->id;
				$pivote->save();
			}
		}

		// ACTUALIZO LA COTIZACION
		$cotizacion            = CotizacionPaquete::find($venta->cotizacion_id);
		$cotizacion->por_pagar = ($cotizacion->por_pagar - $abono[0]['abono']);
		$cotizacion->save();

		
		if ($cotizacion->por_pagar <= 0) {
			foreach ($cotizacion->boletos as $boleto) {
				$boleto->estado = "Cancelado";
				$boleto->save();
			}
		}
		return "si";
	}

	public function storeBoletoProveedor(Request $request){
        $abono = $request->get('pago');
        $boletos = $request->get('listaBoletos');
        //return $boletos;
        /*if ($abono[0]['tipo'] != "Efectivo") {
		    return $abono[0]['tipo'];
        }		
        */
		foreach ($boletos as $key => $boleto) {

			// creamos el PaqueteVenta
			$paquete_venta = PaqueteVenta::create([
				'nacionalidad'    => $boleto['nacionalidad'],
				'costo_neto'      => $boleto['costo_neto'],
				'incentivo'       => $boleto['incentivo'],
				'user_id'         => Auth::id(),
				'cliente_id'      => $boleto['cliente_id'],
				'cotizacion_id'   => $boleto['cotizacion_id'],
				'total_venta'     => $boleto['total_venta'],
				'a_pagar'         => $boleto['a_pagar'],
			]);

            // Agregamos el valor a_pagar de PaqueteVenta a cotizacion para crear una deuda positiva 
			$cotizacion            = CotizacionPaquete::findOrFail($boleto['cotizacion_id']);
			$cotizacion->por_pagar += $paquete_venta->a_pagar;
			$cotizacion->estado = "procesado";
			$cotizacion->update();

			// ABONO
			$datos_abono = PaqueteAbono::create([
				'monto'             => $abono[0]['abono'],
                'tipo_pago'         => $abono[0]['tipo'],
                'paquete_venta_id'  => $paquete_venta->id
			]);

			// SI ES DIFERENTE DE EFECTIVO
			if ($abono[0]['tipo'] != "Efectivo") {
				$banco = BancoPagoPaquete::create([
					'banco_emisor'       => $abono[0]['banco_e'],
					'banco_receptor'     => $abono[0]['banco_r'],
					'numero_operacion'   => $abono[0]['operacion'],
					'paquete_abono_id'   => $datos_abono->id
				]);
			}
            
			// creamos el otro_ventas
			$otro_venta = OtroVenta::create([
				'proveedor_id'     => $boleto['proveedor_id'],
				'tipo'             => $boleto['tipo_venta'],
				'paquete_venta_id' => $paquete_venta->id
			]);
            
			// si el tipo de venta es venta directa
			if ($boleto['tipo_venta'] == "directa") {
				$tarifa = PaqueteTarifaVenta::create([
					'tarifa_fee'     => $boleto['tarifa_fee'],
					'utilidad'       => $boleto['utilidad'],
					'total_utilidad' => $boleto['total_utilidad'],
				]);

				$pivote = OtroTarifa::create([
					'paquete_tarifa_venta_id' => $tarifa->id,
					'otro_venta_id'           => $otro_venta->id
				]);
			}
		}

		// ACTUALIZO LA COTIZACION
		$cotizacion            = CotizacionPaquete::find($boleto['cotizacion_id']);
		$cotizacion->por_pagar -= $abono[0]['abono'];
		$cotizacion->update();

		if ($cotizacion->por_pagar <= 0) {
			foreach ($cotizacion->boletos as $boleto) {
				$boleto->estado = "Cancelado";
				$boleto->update();
			}
		}

        return;
	}

	public function verBoleto(PaqueteVenta $boleto){
		$boleto->load('cliente','qantu');
		$hoteles = PaginaListado::where('codigo','=',$boleto->qantu->codigo_enlace)->get()->load('hotel');
		return response()->json([
			'hoteles' => $hoteles,
			'boleto' => $boleto
		]); 
	}
	public function pdfBoleto(PaqueteVenta $boleto){
		$listado = PaginaListado::where('codigo','=',$boleto->qantu->codigo_enlace)->get()->load('hotel');
		$view =  \View::make('adminweb.paquetes.ventas.boletoPdf')->with('boleto',$boleto)->with('listado',$listado)->render();
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($view);
		return $pdf->stream("BoletoPaquete_".$boleto->id.'.pdf');
	}
	public function fechaBoleto(Request $data){
		$cotizacion = CotizacionPaquete::find($data->f_cotizacion);
		foreach ($cotizacion->boletos as $boleto) {
			$boleto->created_at = $data->f_fecha;
			$boleto->save();
		}
		return redirect()->route('manageVentaPaquete-A')->with('info','Fecha de Creacion Modificada Correctamente'); 
	}
	public function filtro(request $data){	
		//dd($data);
		//BUSCO BOLETOS
		if (Auth::user()->role == "Administrador") {
			$boletos  = PaqueteVenta::all()
									->load('cotizacion','cliente');
		}else{
			$boletos  = PaqueteVenta::where('user_id', Auth::id())
									->load('cotizacion','cliente')->get();
		}
		//SI TRAE FECHAS
		if ($data->desde_filtro != null && $data->hasta_filtro != null) {
			$hasta=explode("-",$data->hasta_filtro);
			$hasta[2] = $hasta[2]+1;
			$hasta=implode("-",$hasta);
			$boletos  = $boletos->where('created_at',">=",$data->desde_filtro)
								->where("created_at","<",$hasta);
		}
		//SI TRAE AGENCIA
		if ($data->agencia_filtro != null) {
			$array = [];
			foreach ($boletos as $boleto) {
				if($boleto->cotizacion->agencia_id ==  $data->agencia_filtro){
					array_push($array, $boleto);
				}
			}
			$boletos = $array;
		}
		//SI TRAE NOMBRE
		if ($data->nombre_filtro != null) {
			$array = [];
			foreach ($boletos as $boleto) {
				if($boleto->cliente->nombre ==  $data->nombre_filtro){
					array_push($array, $boleto);
				}
			}
			$boletos = $array;
		}
		//SI TRAE APELLIDO
		if ($data->apellido_filtro != null) {
			$array = [];
			foreach ($boletos as $boleto) {
				if($boleto->cliente->apellido ==  $data->apellido_filtro){
					array_push($array, $boleto);
				}
			}
			$boletos = $array;
		}
		//FINAL
		$qantu = [];
		$otro = [];
		$agencias = Aviaje::all();
		if(count($boletos) > 0){
			foreach ($boletos as $boleto) {
				if($boleto->qantu != null){
					array_push($qantu, $boleto);
				} else {
					array_push($otro, $boleto);
				}
			}
			return view("adminweb.paquetes.ventas.index",compact('boletos', 'qantu', 'otro','agencias'));
		}else {
			return view("adminweb.paquetes.ventas.index",compact('boletos', 'qantu', 'otro','agencias'))->with("");
		}
	}
}