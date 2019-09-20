<?php

namespace App\Http\Controllers\Pagina;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Pagina\Tiket;
use App\Pagina\Contact;
use App\Pagina\PaginaDia;
use App\Pagina\PaginaNoche;
use App\Pagina\Reservation;
use App\Pagina\PaginaPaquete;
use App\Pagina\PaginaListado;
use App\Pagina\PuntoEncuentro;
use App\Pagina\PaginaActividad;
use App\Pagina\SalidaConfirmada;
use App\Pagina\PaginaDatoPaquete;
use App\Pagina\ContactReservation;
use App\Pagina\PaginaDestinoPaquete;
use App\Pagina\PaginaCategoriaPaquete;
use App\Pagina\PaginaActividadServicio;
use Illuminate\Support\Facades\Storage;
use App\Pagina\PaginaActividadRestaurante;
use Intervention\Image\ImageManagerStatic as Image;

class PaginaPaqueteController extends Controller
{
    public function debug_paquetes(){
        if(Auth::check()){
            if(Auth::user()->role == 'Administrador' && Auth::user()->email == 'wizzt@gmail.com'){
                $paquetes = PaginaPaquete::all();
                //$paquete = PaginaPaquete::find(38);
                foreach($paquetes as $paquete){
                    $enlazados = $paquete->enlazados()->orderBy('codigo', 'asc')->get();
                    if($paquete->listados->count() > 0){
                        $id_noches = [];
                        $enlazados_not_found = [];
                        $exist = false;
                        foreach($paquete->listados as $listado){
                            array_push($id_noches, $listado->noche_id);
                        }
                        foreach($enlazados as $enlazado){
                            foreach($id_noches as $index => $noche){
                                //dd($enlazado, $index, count($id_noches), $noche);
                                if($noche == $enlazado->noche_id){
                                    $exist = true;
                                } else {
                                    if(!$exist){
                                        $exist = false;
                                    }
                                }
        
                                if($index+1 == count($id_noches)){
                                    if(!$exist){
                                        array_push($enlazados_not_found, $enlazado->id);
                                    }
                                }
                            }
                            $exist = false;
                        }
                    }
                    $enlaces_not_found = PaginaListado::whereIn('id',$enlazados_not_found)->get();
                    $aux_content = [];
                    $ultimo = '';
                    foreach($enlaces_not_found as $no){
                        foreach($paquete->listados as $listado){
                            if($no->hotel->destino_id == $listado->destino_id){
                                $no->noche_id = $listado->noche_id;
                                $no->update();
                            }
                        }
        
                        if($no->codigo == $ultimo){
                            array_push($aux_content, $no);
                        } else {
                            if($ultimo == ''){
                                array_push($aux_content, $no);
                            } else {
                                $codigo = bcrypt(str_random(15) . rand(1,999)).date("ymd");
                                foreach($aux_content as $aux){
                                    $aux->codigo = $codigo;
                                    $aux->update();
                                }
                                $aux_content = [];
                                array_push($aux_content, $no);
                            }
                        }
                        $ultimo = $enlazado->codigo;
                    };
                    /* 
                    foreach($enlazados as $enlazado){
                        if($enlazado->codigo == $ultimo){
                            array_push($aux_content, $enlazado);
                        } else {
                            if($ultimo == ''){
                                array_push($aux_content, $enlazado);
                            } else {
                                $codigo = bcrypt(str_random(15) . rand(1,999)).date("ymd");
                                foreach($aux_content as $aux){
                                    $aux->codigo = $codigo;
                                    $aux->update();
                                }
                                $aux_content = [];
                                array_push($aux_content, $enlazado);
                            }
                        }
                        $ultimo = $enlazado->codigo;
                    } */
                    //dd($enlazado);
                }
                dd("finalizó");
            } else {
                abort(401, "Acceso no Autorizado!.");
            }
        }
    }

    //CAMBIAR TIPO TARIFA
    public function changeTypeTarifa($package_id ,$type, $ppm){
        $package=PaginaPaquete::find($package_id);
        $package->tipo_tarifa   = $type;
        if($ppm > 0){
            $package->utilidad_promocion = $ppm;
        }
        $package->save();
        return ;
    }
    // INDEX
    public function index(){
        //$cat_full_day = PaginaCategoriaPaquete::where('nombre', 'FULL DAY')->first();
        //$paquetes = PaginaPaquete::where('categoria_id', '!=', $cat_full_day->id)->orderBy('id', 'desc')->get();
        //dd($paquetes[0]->categoria);
        $paquetes = PaginaPaquete::orderBy('id', 'Desc')->get();
        return view('adminweb.paquetes.index',compact('paquetes'));
    }
    // FIN INDEX

    // ESTADOS
    public function destacar($id){
        $x=PaginaPaquete::find($id);
        $x->estado=2;
        $x->save();
        return redirect()->route('manageProduct-A');       
    }
    public function ocultar($id){
        $x=PaginaPaquete::find($id);
        $x->estado=0;
        $x->save();
        return redirect()->route('manageProduct-A');       
    }
    public function visible($id){
        $x=PaginaPaquete::find($id);
        $x->estado=1;
        $x->save();
        return redirect()->route('manageProduct-A');       
    }
    // FIN ESTADOS

    public function finalizar(PaginaPaquete $paquete){
        $paquete->statusCreado = "terminado";
        $paquete->save();
        //dd($paquete->categoria->nombre);
        if($paquete->categoria->nombre == 'FULL DAY'){
            return redirect()->route('full_day.index');
        }
        return redirect()->route('manageProduct-A');   
    }

    public function estado(PaginaPaquete $paquete, $valor){
        $estado_viejo = $paquete->estado; 
        $paquete->estado=$valor;
        $paquete->save();
        return response()->json([
            'e_v' => $estado_viejo,
            'e_n' => $valor
        ]); 
    }

    public function delete(PaginaPaquete $paquete){
        $paquete->load('dias', 'salidas', 'enlazados.noches', 'reservations');

        if($paquete->dias->count() > 0){
            foreach($paquete->dias as $dia){
                $dia = PaginaDia::findOrFail($dia->id);
                if($dia->actividades->count() > 0){
                    foreach($dia->actividades as $actividad){
                        $actividad = PaginaActividad::findOrFail($actividad->id);
                        $actividad->delete();
                    }
                }
                $dia->delete();
            }
        }
        if($paquete->salidas->count() > 0){
            foreach($paquete->salidas as $salida){
                $salida = SalidaConfirmada::findOrFail($salida->id);
                //dd($salida);
                $salida->delete();
            }
        }

        if($paquete->enlazados->count() > 0){
            foreach($paquete->enlazados as $enlazado){
                //$enlazado = PaginaListado::find($enlazado->id);
                if($enlazado->noches != null){
                    //$noche = PaginaNoche::findOrFail($enlazado->noches->id);
                    $enlazado->noches->delete();
                    //dd('HOLA DENTRO DE NOCHES');
                }
                $enlazado->delete();
                //dd($paquete);
            }
        }
        if($paquete->listados->count() > 0){
            foreach($paquete->listados as $listado){
                // $listado = PaginaDestinoPaquete::findOrFail($listado->id);
                $listado->delete();
            }
        }
        if($paquete->datos->count() > 0){
            foreach($paquete->datos as $dato){
                $dato = PaginaDatoPaquete::findOrFail($dato->id);
                $dato->delete();
            }
        }
        if($paquete->reservations->count() > 0){
            foreach($paquete->reservations as $reservation){
                $reservation = Reservation::findOrFail($reservation->id);
                foreach($reservation->tikets as $ticket){
                    $ticket = Tiket::findOrFail($ticket->id);
                    $ticket->delete();
                }
                if($reservation->contactos->count() > 0){
                    foreach($reservation->contactos as $contacto){
                        $contacto = ContactReservation::findOrFail($contacto->id);
                        $contacto->delete();
                    }
                }
                $reservation->delete();
            }
        }
        //dd($paquete);
        /*
            paquete -> dias (PaginaDia) -> actividades
            paquete -> salida (SalidaConfirmada),
            paquete -> enlazados (PaginaListado)
            paquete -> listados (PaginaDestinoPaquete)
            paquete -> datos (PaginaDatoPaquete)
        */
        Storage::disk('public')->delete('big/'.$paquete->imagen);
		Storage::disk('public')->delete('medium/'.$paquete->imagen);
		Storage::disk('public')->delete('miniature/'.$paquete->imagen);
		Storage::disk('public')->delete('original/'.$paquete->imagen);
        $paquete->delete();
        return back()->with('info', 'Se ha eliminado el paquete correctamente!.');
    }

    public function clonar_paquete(Request $request)
	{   
        //dd(bcrypt(str_random(15) . rand(1,999)).date("ymd"));
		$paquete = PaginaPaquete::findOrFail($request->paquete_id);
		$paquete->load('dias.actividades.restaurante.restaurante', 'dias.actividades.servicio.servicio', 'salidas.punto', 'enlazados.noches', 'listados.noches', 'datos');
        //dd($paquete->dias[0]->actividades[0]->servicio);
		// COMIENZA PROCESO DE CLONADO
		$new_paquete = PaginaPaquete::create([
			'nombre' 			=> $paquete->nombre,
			'codigo' 			=> $request->codigo_paquete,
			'estado' 			=> $paquete->estado,
            'tipo_tarifa'		=> $paquete->tipo_tarifa,
			'utilidad_promocion'=> $paquete->utilidad_promocion,
			'descripcion' 		=> $paquete->descripcion,
			'extracto' 			=> $paquete->extracto,
			'imagen'	 		=> $paquete->imagen,
			'statusCreado' 		=> $paquete->statusCreado,
			'categoria_id' 		=> $paquete->categoria_id,
		]);

		if($paquete->dias->count() > 0){
            foreach($paquete->dias as $dia){
				$new_dia = PaginaDia::create([
					'nombre'		=> $dia->nombre,
					'descripcion'	=> $dia->descripcion,
					'paquete_id'	=> $new_paquete->id,
					'imagen'		=> $dia->imagen,
				]);
                if($dia->actividades->count() > 0){
                    foreach($dia->actividades as $actividad){
						$new_actividad = PaginaActividad::create([
							'nombre' 	=> $actividad->nombre,
							'tipo' 		=> $actividad->tipo,
							'dia_id' 	=> $new_dia->id,
                        ]);
                        if($actividad->restaurante->count() > 0){
                            foreach($actividad->restaurante as $rest){
                                PaginaActividadRestaurante::create([
                                    'restaurante_id'    => $rest->restaurante_id,
                                    'actividad_id'      => $new_actividad->id,
                                ]);
                            }
                        }
                        if($actividad->servicio->count() > 0){
                            foreach($actividad->servicio as $serv){
                                PaginaActividadServicio::create([
                                    'servicio_id'   => $serv->servicio_id,
                                    'actividad_id'  => $new_actividad->id,
                                ]);
                            }
                        }
                    }
                }
            }
		}
        //dd($paquete->salidas[0]->punto->nombre);
		if($paquete->salidas->count() > 0){
            foreach($paquete->salidas as $salida){
                $new_salida = SalidaConfirmada::create([
					'fecha_salida' 	=> $salida->fecha_salida,
					'fecha_llegada' => $salida->fecha_llegada,
					'cupos' 		=> $salida->cupos,
					'paquete_id' 	=> $new_paquete->id,
                ]);
                PuntoEncuentro::create([
                    'nombre'    => $salida->punto->nombre,
                    'latitud'   => $salida->punto->latitud,
                    'longitud'  => $salida->punto->longitud,
                    'salida_id' => $new_salida->id,
                ]);
            }
		}

		if($paquete->listados->count() > 0){
            foreach($paquete->listados as $listado){
				$new_noche = PaginaNoche::create([
					'cantidad' => $listado->noches->cantidad
				]);
				$ultimo = '';
				$new_codigo = '';
				foreach($paquete->enlazados as $enlazado){
					if($listado->noche_id == $enlazado->noche_id){
						if ($ultimo == $enlazado->codigo) {
							$new_enlazado = PaginaListado::create([
								'codigo' => $new_codigo,
								'hotel_id' => $enlazado->hotel_id,
								'noche_id' => $new_noche->id,
								'estado' => $enlazado->estado,
								'paquete_id' => $new_paquete->id,
							]);
						}else{
							$new_codigo = bcrypt(str_random(15) . rand(1,999)).date("ymd");
							$new_enlazado = PaginaListado::create([
								'codigo'        => $new_codigo,
								'hotel_id'      => $enlazado->hotel_id,
								'noche_id'      => $new_noche->id,
								'estado'        => $enlazado->estado,
								'paquete_id'    => $new_paquete->id,
							]);
						}
						$ultimo = $enlazado->codigo;
					}
				}

				// creamos la pivote con los destinos de este paquete
                PaginaDestinoPaquete::create([
					'noche_id' 		=> $new_noche->id,
					'paquete_id' 	=> $new_paquete->id,
					'destino_id'	=> $listado->destino_id,
				]);
            }
		}

		if($paquete->datos->count() > 0){
            foreach($paquete->datos as $dato){
                PaginaDatoPaquete::create([
					'texto'			=> $dato->texto,
					'tipo'			=> $dato->tipo,
					'paquete_id'	=> $new_paquete->id,
				]);
            }
        }
		return back()->with('info', 'Se ha clonado el paquete correctamente!.');
    }
    
    public function moveImagesStorage(){
        /* creo paquetes y array */
        $paquetes = PaginaPaquete::orderBy("id","ASC")->get();
        $carpetas = [["original",null],["miniature",100],["medium",300],["big",700]];	
        /* recorro paquetes */
        foreach ($paquetes as $index => $paquete) {
            $url = asset("/uploads/paquetes/".$paquete->imagen);
            foreach($carpetas as $index => $carpeta){
                if($index != 0)
                { 
                    $imagen = Image::make($url)->resize($carpeta[1],null,
                    function($constraint){
                        $constraint->aspectRatio();
                    })
                    ->resizeCanvas($carpeta[1],null);
                }else{
                    $imagen = Image::make($url);
                }
            $ruta = public_path().'/storage/'."/".$carpeta[0]."/";
            $imagen->save($ruta . $paquete->imagen, 100);
            }
            dd("funciono");
        }
    } 

    public function create(PaginaPaquete $paquete)
    {
        $categorias = PaginaCategoriaPaquete::all();
        return view('adminweb.paquetes.nuevo.create', compact('categorias', 'paquete')); 
    }
}