<?php

namespace App\Http\Controllers\Pagina;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pagina\CotizacionPaquete;
use App\Pagina\PaginaPaquete;
use App\Cliente;
use App\Consolidador;
use App\Tpago;
use App\Banco;   
use App\Bancog;

class ProcesarCotizacionPaqueteController extends Controller
{
	public function qantu(Request $data){
		$cotizacion = CotizacionPaquete::find($data->cotizacion);
		$pasajeros  = Cliente::all();
		$bancos = Banco::all();
		$bancosg = Bancog::all();
		return view("adminweb.paquetes.cotizacion.proceso.qantu.index",compact('cotizacion','pasajeros','bancos','bancosg'));
	}
	public function buscarCodigo($codigo){
		$paquete = PaginaPaquete::where('codigo', $codigo)->first();
		if ($paquete) {
			$paquete->load('enlazados','listados');
			$paquete->listados->load('destino');
			$paquete->enlazados->load('noches','hotel');

			// CALCULO DE TOTAL DE PAQUETE
			$total = [
				'p_adulto'     => 0,
				'p_estudiante' => 0,
				'c_adulto'     => 0,
				'c_estudiante' => 0,
				'e_adulto'     => 0,
				'e_estudiante' => 0,
				'e_ninio'      => 0,
				'p_ninio'      => 0, 
			];
			foreach ($paquete->dias as $dia) {
				foreach ($dia->actividades as $actividad) {
					if ($actividad->tipo == 'servicio') {
						$total['p_adulto']     += $actividad->servicio[0]->servicio->peruano->adulto;
						$total['p_estudiante'] += $actividad->servicio[0]->servicio->peruano->estudiante;
						$total['e_adulto']     += $actividad->servicio[0]->servicio->extranjero->adulto;
						$total['e_estudiante'] += $actividad->servicio[0]->servicio->extranjero->estudiante;
						$total['c_adulto']     += $actividad->servicio[0]->servicio->comunidad->adulto;
						$total['c_estudiante'] += $actividad->servicio[0]->servicio->comunidad->estudiante;
						$total['p_ninio']      += $actividad->servicio[0]->servicio->peruano->ninio;
						$total['e_ninio']      += $actividad->servicio[0]->servicio->extranjero->ninio;
					}elseif($actividad->tipo == 'restaurante'){
						if(count($actividad->restaurante) > 0):
							$total['p_adulto']     += $actividad->restaurante[0]->restaurante->peruano->adulto;
							$total['p_estudiante'] += $actividad->restaurante[0]->restaurante->peruano->estudiante;
							$total['e_adulto']     += $actividad->restaurante[0]->restaurante->extranjero->adulto;
							$total['e_estudiante'] += $actividad->restaurante[0]->restaurante->extranjero->estudiante;
							$total['c_adulto']     += $actividad->restaurante[0]->restaurante->comunidad->adulto;
							$total['c_estudiante'] += $actividad->restaurante[0]->restaurante->comunidad->estudiante;
							$total['p_ninio']      += $actividad->restaurante[0]->restaurante->peruano->ninio;
							$total['e_ninio']      += $actividad->restaurante[0]->restaurante->extranjero->ninio;
						endif;
					}
				}
			}
			// FIN TOTAL DE PAQUETE

			// CALCULO DE HOTELES CON SERVICIOS
			$enlazados = [];
			$ultimo="";
			foreach ($paquete->enlazados as $enlace) {
				if ($ultimo == $enlace->codigo) {
                // VARIABLE CON NOCHES
					$noches = $enlace->noches->cantidad;
                // AGREGAR HOTEL A LA LISTA
					array_push($enlazados[$ultimo]['hoteles'],$enlace->hotel->nombre);
					$e_swb = ($enlace->hotel->e_swb * $noches);
					$e_dwb = ($enlace->hotel->e_dwb * $noches);
					$e_tpl = ($enlace->hotel->e_tpl * $noches);
					$e_chd = ($enlace->hotel->e_chd * $noches);
					$p_swb = ($enlace->hotel->p_swb * $noches);
					$p_dwb = ($enlace->hotel->p_dwb * $noches);
					$p_tpl = ($enlace->hotel->p_tpl * $noches);
					$p_chd = ($enlace->hotel->p_chd * $noches);
					$c_swb = ($enlace->hotel->p_swb * $noches);
					$c_dwb = ($enlace->hotel->p_dwb * $noches);
					$c_tpl = ($enlace->hotel->p_tpl * $noches);
                // SUMAR TARIFAS DEL HOTEL
					$enlazados[$ultimo]['e_swb'] += $e_swb;
					$enlazados[$ultimo]['e_dwb'] += $e_dwb;
					$enlazados[$ultimo]['e_tpl'] += $e_tpl;
					$enlazados[$ultimo]['e_chd'] += $e_chd;
					$enlazados[$ultimo]['p_swb'] += $p_swb;
					$enlazados[$ultimo]['p_dwb'] += $p_dwb;
					$enlazados[$ultimo]['p_tpl'] += $p_tpl;
					$enlazados[$ultimo]['p_chd'] += $p_chd;
					$enlazados[$ultimo]['c_swb'] += $c_swb;
					$enlazados[$ultimo]['c_dwb'] += $c_dwb;
					$enlazados[$ultimo]['c_tpl'] += $c_tpl;
				}else{
                // VARIABLE CON NOCHES
					$noches = $enlace->noches->cantidad;
                // NUEVO INDICE CON DATOS
					$e_swb = ($enlace->hotel->e_swb * $noches);
					$e_dwb = ($enlace->hotel->e_dwb * $noches);
					$e_tpl = ($enlace->hotel->e_tpl * $noches);
					$e_chd = ($enlace->hotel->e_chd * $noches);
					$p_swb = ($enlace->hotel->p_swb * $noches);
					$p_dwb = ($enlace->hotel->p_dwb * $noches);
					$p_tpl = ($enlace->hotel->p_tpl * $noches);
					$p_chd = ($enlace->hotel->p_chd * $noches);
					$c_swb = ($enlace->hotel->p_swb * $noches);
					$c_dwb = ($enlace->hotel->p_dwb * $noches);
					$c_tpl = ($enlace->hotel->p_tpl * $noches);
					
					$e_swb += $total['e_adulto'];
					$e_dwb += $total['e_adulto'];
					$e_tpl += $total['e_adulto'];
					$e_chd += $total['e_ninio'];
					$p_swb += $total['p_adulto'];
					$p_dwb += $total['p_adulto'];
					$p_tpl += $total['p_adulto'];
					$p_chd += $total['p_ninio'];
					$c_swb += $total['c_adulto'];
					$c_dwb += $total['c_adulto'];
					$c_tpl += $total['c_adulto'];
					// dd($e_swb,$e_dwb,$e_tpl,$e_chd,$p_swb,$p_dwb,$p_tpl,$p_chd);
					$enlazados[$enlace->codigo] = 
					['hoteles' => [],
					'e_swb' => $e_swb,
					'e_dwb' => $e_dwb,
					'e_tpl' => $e_tpl,
					'e_chd' => $e_chd,
					'p_swb' => $p_swb,
					'p_dwb' => $p_dwb,
					'p_tpl' => $p_tpl,
					'p_chd' => $p_chd,
					'c_swb' => $c_swb,
					'c_dwb' => $c_dwb,
					'c_tpl' => $c_tpl,];
                // AGREGO EL HOTEL AL ARRAY HOTEL 
					array_push($enlazados[$enlace->codigo]['hoteles'],$enlace->hotel->nombre);
					
				}

				$ultimo = $enlace->codigo;
			}
		}
		return response()->json([
			'mensaje' => $paquete,
			'datos'   => $enlazados
		]);
	}
	public function agregarCliente(Request $data){
		$cliente                = new Cliente();
		$cliente->empresas_id   = $data->empresa;
		$cliente->cedula_rif    = $data->dni;
		$cliente->nombre        = strtoupper($data->nombre);
		$cliente->apellido      = strtoupper($data->apellido);
		$cliente->telefono      = $data->telefono;
		$cliente->direccion     = $data->direccion;
		$cliente->email         = $data->email;
		$cliente->tipo_pasajero =strtoupper($data->tipo);
		$cliente->save();
		return response()->json([
			'mensaje' => $cliente,
		]); 
	}

	// FUNCIONES DE PROCESAR COTIZACION  DE OTRO PROVEEDOR

	public function proveedor(Request $data){
		$cotizacion = CotizacionPaquete::find($data->proveedor);
		// dd($cotizacion);
		$pasajeros  = Cliente::all();
		$consolidadores = Consolidador::all();
		$tpagos= TPago::all();
		$bancos = Banco::all();
		$bancosg = Bancog::all();
		return view("adminweb.paquetes.cotizacion.proceso.proveedor.index",compact('cotizacion','pasajeros','consolidadores','tpagos','bancos','bancosg'));
	}
}
