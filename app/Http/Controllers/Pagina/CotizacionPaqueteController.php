<?php

namespace App\Http\Controllers\Pagina;

use Auth;
use App\Pais;
use App\Aviaje;
use App\Empresa;
use App\Pagina\QantuVenta;
use App\Pagina\QantuTarifa;
use Illuminate\Http\Request;
use App\Pagina\PaginaDestino;
use App\Pagina\BancoPagoPaquete;
use App\Pagina\CotizacionPaquete;
use App\Pagina\PaqueteTarifaVenta;
use App\Http\Controllers\Controller;

class CotizacionPaqueteController extends Controller
{
	public function index(){
		$cotizaciones = CotizacionPaquete::orderBy('updated_at','DESC')->get();
		$paises       = Pais::all();
		$agencias     = Aviaje::all();
		$destinos     = PaginaDestino::all();
		return view('adminweb.paquetes.cotizacion.index', compact('cotizaciones','paises','agencias','destinos'));	
	}
	public function created(){
		$paises   = Pais::all();
		$agencias = Aviaje::all();
		$destinos = PaginaDestino::all();
		$empresas = Empresa::all();
		return view('adminweb.paquetes.cotizacion.created', compact('paises','agencias','destinos','empresas'));	
	}
	public function store(Request $data){
		$cotizacion                = new CotizacionPaquete;
		$cotizacion->agencia_id    = $data->agencia_id;
		$cotizacion->pais_id       = $data->pais_id;
		$cotizacion->destino_id    = $data->destino_id;
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
		$cotizacion->load('pais','destino','agencia','vendedor');

		$message = $cotizacion ? 'Se ha registrado la cotizacion de forma exitosa.' : 'Error al Registrar';

		return redirect()->route('manageCotizacion-A')->with('message', $message);
	}

	public function procesoqantu(){
		return view('adminweb.paquetes.cotizacion.proceso.qantu.index');
	}

	public function procesoproveedor(){
		return view('adminweb.paquetes.cotizacion.proceso.proveedor.index');
	}

	public function destroy(CotizacionPaquete $cotizacion){
		$cotizacion->load('boletos.abonos', 'boletos.otro.tarifa.tarifa', 'boletos.qantu');
        //dd($cotizacion->boletos[0]->otro->tarifa);
		foreach ($cotizacion->boletos as $boleto){
			// ELIMINO BOLETO
			foreach ($boleto->abonos as $abono) {
				if ($abono->tipo_pago != "Efectivo") {
					// ELIMINO BANCO
					$banco = BancoPagoPaquete::find($abono->banco->id);
					$banco->delete();
				}
				// ELIMINO EL BOLETO
				$abono->delete();
			}
			if ($boleto->qantu != null) {
				if ($boleto->qantu != "Agencia") {
						// ELIMINO TARIFA
					$pivote = QantuTarifa::find($boleto->qantu->tarifa->id);
					$pivote->remove();
					$tarifa = PaqueteTarifaVenta::$boleto->qantu->tarifa->tarifa->id;
					$tarifa->delete();
				}
				    // ELIMINO QANTU 
				$qantu = QantuVenta::find($boleto->qantu->id);
				$qantu->delete();
			}
			$boleto->delete();
			if($boleto->otro != null){
				if ($boleto->otro->tarifa->count() > 0) {
					foreach ($boleto->otro->tarifa as $tarifa) {
						$ptventa = PaqueteTarifaVenta::find($tarifa->tarifa->id);
						$ptventa->delete();
					}
				}
			}
		}
		$cotizacion->estado = "anulado";
		$cotizacion->save();
		return;
	}
}