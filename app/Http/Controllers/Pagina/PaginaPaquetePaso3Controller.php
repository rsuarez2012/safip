<?php

namespace App\Http\Controllers\Pagina;

use App\Pagina\PaginaDia;
use App\Pagina\PaginaHotel;
use Illuminate\Http\Request;
use App\Pagina\PaginaDestino;
use App\Pagina\PaginaPaquete;
use App\Pagina\PaginaListado;
use App\Pagina\PaginaServicio;
use App\Pagina\PaginaActividad;
use App\Pagina\PaginaRestaurante;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Pagina\PaginaActividadServicio;
use App\Pagina\PaginaActividadRestaurante;
use Intervention\Image\ImageManagerStatic as Image;

class PaginaPaquetePaso3Controller extends Controller
{
    public function changeStateHotels($code,$status){
        $hotels = PaginaListado::where('codigo',$code)->get();
        if($status == "visible"){
            $newStatus="oculto";
        }else{
            $newStatus="visible";
        }

        foreach($hotels as $hotel){
            $hotel->estado=$newStatus;
            $hotel->save();
        }
        return;
    }
    public function changeTypeTarifa($code,$status){
        $hotels = PaginaListado::where('codigo',$code)->get();
        if($status == "visible"){
            $newStatus="oculto";
        }else{
            $newStatus="visible";
        }

        foreach($hotels as $hotel){
            $hotel->estado=$newStatus;
            $hotel->save();
        }
        return;
    }
    public function tool_restaurants($id){
        $paquete = PaginaPaquete::find($id);
        $restaurantes = [];//PaginaRestaurante::all();

        foreach ($paquete->listados as $destinoPaquete) {
            $restaurants = $destinoPaquete->destino->restaurantes;
            foreach ($restaurants as $restaurant) {
                $restaurant->load('destino','peruano', 'comunidad', 'extranjero');
                array_push($restaurantes, $restaurant);
            }
        }

        return $restaurantes;
    }

    public function tool_services($id){
        //return $id;
        $paquete = PaginaPaquete::find($id);
        $servicios = [];
        foreach ($paquete->listados as $destinoPaquete) { // destinos del paquete
            foreach ($destinoPaquete->destino->operadores as $operador) { // operadores asociados al destino
                foreach ($operador->servicios as $servicio) { // cada servicio de operador
                    $servicio->load('operador', 'peruano', 'comunidad', 'extranjero');
                    array_push($servicios, $servicio);
                }
            }
        }

        return $servicios;
    }

    public function tool_others_destinos($id){
        $paquete = PaginaPaquete::find($id);
        $mis_destinos_ids = [];

        // recorremos los detinos asociados para guardar su id
        foreach ($paquete->listados as $destinoPaquete) {
            array_push($mis_destinos_ids, $destinoPaquete->destino->id);
        }

        // buscamos los destinos que no esten en el array mis_destinos
        $other_destinos = PaginaDestino::whereNotIn('id', $mis_destinos_ids)->get();
        return $other_destinos;
    }

    public function tool_other_services(Request $request){
        $destinos = PaginaDestino::whereIn('id', $request->destinos)->get();
        $servicios = [];
        foreach ($destinos as $destino) {
            foreach ($destino->operadores as $operador) {
                foreach ($operador->servicios as $servicio) {
                    $servicio->load('operador', 'peruano', 'comunidad', 'extranjero');
                    array_push($servicios, $servicio);
                }
            }
        }
        return $servicios;
    }

    public function tool_other_restaurants(Request $request){
        $destinos = PaginaDestino::whereIn('id', $request->destinos)->get();
        $restaurantes = [];
        foreach ($destinos as $destino) {
            foreach ($destino->restaurantes as $restaurante) {
                $restaurante->load('destino','peruano', 'comunidad', 'extranjero');
                array_push($restaurantes, $restaurante);
            }
        }
        return $restaurantes;
    }

    public function tool_neto($id){
    	$paquete  = PaginaPaquete::findOrFail($id);
        $enlazados = [];
        $ultimo="";
        foreach ($paquete->enlazados as $enlace) {
            if ($ultimo == $enlace->codigo) {
                // VARIABLE CON NOCHES
                $noches = $enlace->noches->cantidad;
                
                //nuevas variables
                $new_p_swb = 0;
				$new_p_dwb = 0;
				$new_p_tpl = 0;
				$new_p_chd = 0;
				$new_e_swb = 0;
				$new_e_dwb = 0;
				$new_e_tpl = 0;
                $new_e_chd = 0;
                
                if($enlace->hotel->p_swb > 0){ $new_p_swb =  $enlace->hotel->p_swb * $noches; }
			    if($enlace->hotel->p_dwb > 0){ $new_p_dwb = ($enlace->hotel->p_dwb * $noches) / 2; }
			    if($enlace->hotel->p_tpl > 0){ $new_p_tpl = ($enlace->hotel->p_tpl * $noches) / 3; }
			    if($enlace->hotel->p_chd > 0){ $new_p_chd = ($enlace->hotel->p_chd * $noches) / 4; }
			    if($enlace->hotel->e_swb > 0){ $new_e_swb =  $enlace->hotel->e_swb * $noches; }
			    if($enlace->hotel->e_dwb > 0){ $new_e_dwb = ($enlace->hotel->e_dwb * $noches) / 2; }
			    if($enlace->hotel->e_tpl > 0){ $new_e_tpl = ($enlace->hotel->e_tpl * $noches) / 3; }
			    if($enlace->hotel->e_chd > 0){ $new_e_chd = ($enlace->hotel->e_chd * $noches) / 4; }
                
                // AGREGAR HOTEL A LA LISTA
                array_push($enlazados[$ultimo]['hoteles'],$enlace->hotel->nombre);

                if($enlazados[$ultimo]['p_swb'] > 0){ $enlazados[$ultimo]['p_swb'] += $new_p_swb; }
			    if($enlazados[$ultimo]['p_dwb'] > 0){ $enlazados[$ultimo]['p_dwb'] += $new_p_dwb; }
			    if($enlazados[$ultimo]['p_tpl'] > 0){ $enlazados[$ultimo]['p_tpl'] += $new_p_tpl; }
			    if($enlazados[$ultimo]['p_chd'] > 0){ $enlazados[$ultimo]['p_chd'] += $new_p_chd; }
                if($enlazados[$ultimo]['e_swb'] > 0){ $enlazados[$ultimo]['e_swb'] += $new_e_swb; }	    
                if($enlazados[$ultimo]['e_dwb'] > 0){ $enlazados[$ultimo]['e_dwb'] += $new_e_dwb; }
			    if($enlazados[$ultimo]['e_tpl'] > 0){ $enlazados[$ultimo]['e_tpl'] += $new_e_tpl; }
			    if($enlazados[$ultimo]['e_chd'] > 0){ $enlazados[$ultimo]['e_chd'] += $new_e_chd; }
            }else{
                // VARIABLE CON NOCHES
                $noches = $enlace->noches->cantidad;

                //nuevas variables
                $new_p_swb = 0;
				$new_p_dwb = 0;
				$new_p_tpl = 0;
				$new_p_chd = 0;
				$new_e_swb = 0;
				$new_e_dwb = 0;
				$new_e_tpl = 0;
                $new_e_chd = 0;
                
                if($enlace->hotel->p_swb > 0){ $new_p_swb =  $enlace->hotel->p_swb * $noches; }
			    if($enlace->hotel->p_dwb > 0){ $new_p_dwb = ($enlace->hotel->p_dwb * $noches) / 2; }
			    if($enlace->hotel->p_tpl > 0){ $new_p_tpl = ($enlace->hotel->p_tpl * $noches) / 3; }
			    if($enlace->hotel->p_chd > 0){ $new_p_chd = ($enlace->hotel->p_chd * $noches) / 4; }
			    if($enlace->hotel->e_swb > 0){ $new_e_swb =  $enlace->hotel->e_swb * $noches; }
			    if($enlace->hotel->e_dwb > 0){ $new_e_dwb = ($enlace->hotel->e_dwb * $noches) / 2; }
			    if($enlace->hotel->e_tpl > 0){ $new_e_tpl = ($enlace->hotel->e_tpl * $noches) / 3; }
                if($enlace->hotel->e_chd > 0){ $new_e_chd = ($enlace->hotel->e_chd * $noches) / 4; }
                
                // NUEVO INDICE CON DATOS
                $enlazados[$enlace->codigo] = [
                    'hoteles' => [],
                    'codigo' => $enlace->codigo,
                    'estado' => $enlace->estado,
                    'estrella' => $enlace->hotel->estrella,
                    'categoria' =>$enlace->hotel->categoria->nombre,
                    'p_swb' => $new_p_swb,
                    'p_dwb' => $new_p_dwb,
                    'p_tpl' => $new_p_tpl,
                    'p_chd' => $new_p_chd,
                    'e_swb' => $new_e_swb,
                    'e_dwb' => $new_e_dwb,
                    'e_tpl' => $new_e_tpl,
                    'e_chd' => $new_e_chd,
                ];
                // AGREGO EL HOTEL AL ARRAY HOTEL 
                array_push($enlazados[$enlace->codigo]['hoteles'],$enlace->hotel->nombre); 
            }
            
            $ultimo = $enlace->codigo;
        }

        // Lógica creada por cessare
        $aux_enlazados = $enlazados;
        $enlazados = [];
        $stars_array = ['hostel', 'hst', 'hst  2*', 'hst  3*', 'hotel', 'hotel  2*', 'hotel  3*', 'hotel  4*', 'hotel  5*'];
        //dd($aux_enlazados, $stars_array);
        foreach ($stars_array as $star) {
            foreach ($aux_enlazados as $key => $enlazado) {
                //dd(strtolower($enlazado['star']) == 'hst', $star);
                if(strtolower($enlazado['estrella']) == $star){
                    array_push($enlazados, $enlazado);
                }
            }
        }

        $doble_aux = $enlazados;
        $enlazados = [];
        foreach($doble_aux as $en){
            $enlazados[$en['codigo']] =
                [
                    'hoteles'   => $en['hoteles'],
                    'codigo'    => $en['codigo'],
                    'estado'    => $en['estado'],
                    'estrella'  => $en['estrella'],
                    'categoria' => $en['categoria'],
                    'e_swb' => $en['e_swb'],
                    'e_dwb' => $en['e_dwb'],
                    'e_tpl' => $en['e_tpl'],
                    'e_chd' => $en['e_chd'],
                    'p_swb' => $en['p_swb'],
                    'p_dwb' => $en['p_dwb'],
                    'p_tpl' => $en['p_tpl'],
                    'p_chd' => $en['p_chd'],
                ];
        }

        return $enlazados;
    }
    public function tool_create_edit($paquete)
    {
        // DATOS NECESARIOS EN LA VISTA DE ITINERARIO
        $restaurantes = $this->tool_restaurants($paquete->id);
        $servicios = $this->tool_services($paquete->id);
        
        // ARRAY DE SUBTOTAL > ACTIVIDADES 
        $subtotal = [
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
                    $subtotal['p_adulto']     += $actividad->servicio[0]->servicio->peruano->adulto;
                    $subtotal['p_estudiante'] += $actividad->servicio[0]->servicio->peruano->estudiante;
                    $subtotal['e_adulto']     += $actividad->servicio[0]->servicio->extranjero->adulto;
                    $subtotal['e_estudiante'] += $actividad->servicio[0]->servicio->extranjero->estudiante;
                    $subtotal['c_adulto']     += $actividad->servicio[0]->servicio->comunidad->adulto;
                    $subtotal['c_estudiante'] += $actividad->servicio[0]->servicio->comunidad->estudiante;
                    $subtotal['p_ninio']      += $actividad->servicio[0]->servicio->peruano->ninio;
                    $subtotal['e_ninio']      += $actividad->servicio[0]->servicio->extranjero->ninio;
                }elseif($actividad->tipo == 'restaurante'){
                    //dd($actividad->restaurante[0]->restaurante->peruano->adulto);
                    if(count($actividad->restaurante) > 0):
                        $subtotal['p_adulto']     += $actividad->restaurante[0]->restaurante->peruano->adulto;
                        $subtotal['p_estudiante'] += $actividad->restaurante[0]->restaurante->peruano->estudiante;
                        $subtotal['e_adulto']     += $actividad->restaurante[0]->restaurante->extranjero->adulto;
                        $subtotal['e_estudiante'] += $actividad->restaurante[0]->restaurante->extranjero->estudiante;
                        $subtotal['c_adulto']     += $actividad->restaurante[0]->restaurante->comunidad->adulto;
                        $subtotal['c_estudiante'] += $actividad->restaurante[0]->restaurante->comunidad->estudiante;
                        $subtotal['p_ninio']      += $actividad->restaurante[0]->restaurante->peruano->ninio;
                        $subtotal['e_ninio']      += $actividad->restaurante[0]->restaurante->extranjero->ninio;
                    endif;
                }
            }
        }

        // ARRAY TOTAL DE HOTELES ENLAZADOS  
        $enlazados = [];
            $ultimo="";
            foreach ($paquete->enlazados as $enlace) {
                if ($ultimo == $enlace->codigo) {
                // VARIABLE CON NOCHES
                    $noches = $enlace->noches->cantidad;
                // AGREGAR HOTEL A LA LISTA
                    array_push($enlazados[$ultimo]['hoteles'],$enlace->hotel->nombre);
                    $e_swb = ($enlace->hotel->e_swb * $noches);
                    $e_dwb = (($enlace->hotel->e_dwb * $noches)/2);
                    $e_tpl = (($enlace->hotel->e_tpl * $noches)/3);
                    $e_chd = ($enlace->hotel->e_chd * $noches);
                    $p_swb = ($enlace->hotel->p_swb * $noches);
                    $p_dwb = (($enlace->hotel->p_dwb * $noches)/2);
                    $p_tpl = (($enlace->hotel->p_tpl * $noches)/3);
                    $p_chd = ($enlace->hotel->p_chd * $noches);
                    $c_swb = ($enlace->hotel->p_swb * $noches);
                    $c_dwb = (($enlace->hotel->p_dwb * $noches)/2);
                    $c_tpl = (($enlace->hotel->p_tpl * $noches)/3);
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
                    $e_dwb = (($enlace->hotel->e_dwb * $noches)/2);
                    $e_tpl = (($enlace->hotel->e_tpl * $noches)/3);
                    $e_chd = ($enlace->hotel->e_chd * $noches);
                    $p_swb = ($enlace->hotel->p_swb * $noches);
                    $p_dwb = (($enlace->hotel->p_dwb * $noches)/2);
                    $p_tpl = (($enlace->hotel->p_tpl * $noches)/3);
                    $p_chd = ($enlace->hotel->p_chd * $noches);
                    $c_swb = ($enlace->hotel->p_swb * $noches);
                    $c_dwb = (($enlace->hotel->p_dwb * $noches)/2);
                    $c_tpl = (($enlace->hotel->p_tpl * $noches)/3);
                    if ($e_swb > 0) {
                        $e_swb += $subtotal['e_adulto'];
                    }
                    if ($e_dwb > 0) {
                        $e_dwb += $subtotal['e_adulto'];
                    }
                    if ($e_tpl > 0) {
                        $e_tpl += $subtotal['e_adulto'];
                    }
                    if ($e_chd  > 0) {
                        $e_chd += $subtotal['e_ninio'];
                    }
                    if ($p_swb  > 0) {
                        $p_swb += $subtotal['p_adulto'];    
                    }
                    if ($p_dwb > 0) {
                        $p_dwb += $subtotal['p_adulto'];    
                    }
                    if ($p_tpl > 0) {
                        $p_tpl += $subtotal['p_adulto'];    
                    }
                    if ($p_chd  > 0) {
                        $p_chd += $subtotal['p_ninio'];    
                    }
                    if ($c_swb  > 0) {
                        $c_swb += $subtotal['c_adulto'];    
                    }
                    if ($c_dwb  > 0) {
                        $c_dwb += $subtotal['c_adulto'];    
                    }
                    if ($c_tpl  > 0) {
                        $c_tpl += $subtotal['c_adulto'];
                    }
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

        $list = [];
        foreach ($enlazados as $key => $enlazado) {
            //echo $key;
            $e_swb = $enlazado['e_swb'];
            $e_dwb = $enlazado['e_dwb'];
            $e_tpl = $enlazado['e_tpl'];
            $e_chd = $enlazado['e_chd'];
            $p_swb = $enlazado['p_swb'];
            $p_dwb = $enlazado['p_dwb'];
            $p_tpl = $enlazado['p_tpl'];
            $p_chd = $enlazado['p_chd'];
            $c_swb = $enlazado['c_swb'];
            $c_dwb = $enlazado['c_dwb'];
            $c_tpl = $enlazado['c_tpl'];
 
            // Aplicando 12%
            $e_swb += $e_swb*0.12;
            $e_dwb += $e_dwb*0.12;
            $e_tpl += $e_tpl*0.12;
            $e_chd += $e_chd*0.12;
            $p_swb += $p_swb*0.12;
            $p_dwb += $p_dwb*0.12;
            $p_tpl += $p_tpl*0.12;
            $p_chd += $p_chd*0.12;
            $c_swb += $c_swb*0.12;
            $c_dwb += $c_dwb*0.12;
            $c_tpl += $c_tpl*0.12;

            // Aplicando 10%
            $e_swb += $e_swb*0.10;
            $e_dwb += $e_dwb*0.10;
            $e_tpl += $e_tpl*0.10;
            $e_chd += $e_chd*0.10;
            $p_swb += $p_swb*0.10;
            $p_dwb += $p_dwb*0.10;
            $p_tpl += $p_tpl*0.10;
            $p_chd += $p_chd*0.10;
            $c_swb += $c_swb*0.10;
            $c_dwb += $c_dwb*0.10;
            $c_tpl += $c_tpl*0.10;
            
            // Aplicando + 12, set el formato float e incorporar valores
            if ($e_swb > 0) {
                $enlazado['e_swb'] = number_format($e_swb + 12, 2, ',', '.');
            }
            if ($e_dwb > 0) {
                $enlazado['e_dwb'] = number_format($e_dwb + 12, 2, ',', '.');
            }
            if ($e_tpl > 0) {
                $enlazado['e_tpl'] = number_format($e_tpl + 12, 2, ',', '.');
            }
            if ($e_chd > 0) {
                $enlazado['e_chd'] = number_format($e_chd + 12, 2, ',', '.');               
            }
            if ($p_swb > 0) {
                $enlazado['p_swb'] = number_format($p_swb + 12, 2, ',', '.');
            }
            if ($p_dwb > 0) {
                $enlazado['p_dwb'] = number_format($p_dwb + 12, 2, ',', '.');
            } 
            if ($p_tpl > 0) {
                $enlazado['p_tpl'] = number_format($p_tpl + 12, 2, ',', '.');
            }
            if ($p_chd > 0) {
                $enlazado['p_chd'] = number_format($p_chd + 12, 2, ',', '.');    
            }
            if ($c_swb > 0) {
                $enlazado['c_swb'] = number_format($c_swb + 12, 2, ',', '.');
            }
            if ($c_dwb > 0) {
                $enlazado['c_dwb'] = number_format($c_dwb + 12, 2, ',', '.');
            }
            if ($c_tpl > 0) {
                $enlazado['c_tpl'] = number_format($c_tpl + 12, 2, ',', '.');
            }
            
            $list[$key] = $enlazado;
        }
        $enlazados = $list;

        return compact('paquete','enlazados','restaurantes','servicios','subtotal');
    }
    public function index($id){
        $paquete = PaginaPaquete::findOrFail($id);
        if($paquete->statusCreado != 'terminado'){
            $paquete->statusCreado = '3';
            $paquete->update();
        }
        return view('adminweb.paquetes.pasos.paso3')->with('paquete_id',$paquete->id);
    }

    public function agregarDia(Request $request,$paquete_id)
    { 
        foreach($request->days as $index => $day)
        {
            $dia 		      = new PaginaDia(); 
            $dia->nombre      = $day["name"];
            $dia->descripcion = $day["description"];
            $dia->paquete_id  = $paquete_id;
            if ($day["libre"] == "false") 
            {
                $carpetas = [["original",null],["miniature",100],["medium",300],["big",700]];	
                if ($request->file("img-".$index)) 
                {
                    $imagenOriginal = $request->file("img-".$index);
                    $temp_name ="img_dia_" .str_random(15) . '_'. date("ymd") .".". $imagenOriginal->getClientOriginalExtension();
                    foreach($carpetas as $index => $carpeta){
                        if($index != 0)
                        { 
                            $imagen = Image::make($imagenOriginal)->resize($carpeta[1],null,
                            function($constraint){
                                $constraint->aspectRatio();
                            })
					        ->resizeCanvas($carpeta[1],null);
                        }else{
                            $imagen = Image::make($imagenOriginal);
                        }
                    $ruta = public_path().'/storage/'.$carpeta[0]."/dia";
                    $imagen->save($ruta . $temp_name, 100);
                    }
                    $dia->imagen = $temp_name;
                }
            }else{
                $dia->imagen = "dia_libre.jpg";
            }
            $dia->save();    
        }
        return $request->days;
    }
    public function updatedDia(Request $data,$paquete_id){
        $dia=PaginaDia::find($data->day_id);
        

			if ($data->file('img')) 
			{
                if($dia->imagen != "dia_libre.jpg"){
                    Storage::disk('public')->delete('big/'.$dia->imagen);
                    Storage::disk('public')->delete('medium/'.$dia->imagen);
                    Storage::disk('public')->delete('miniature/'.$dia->imagen);
                    Storage::disk('public')->delete('original/'.$dia->imagen);
                }
                $carpetas = [["original",null],["big",700],["medium",300],["miniature",100]];
				$imagenOriginal = $data->file('img');
				$imagen = Image::make($imagenOriginal);
				$temp_name ="img_paquete_" .str_random(15) . '_'. date("ymd") .".". $imagenOriginal->getClientOriginalExtension();
				foreach($carpetas as $index => $carpeta){
				if($index != 0){
					$imagen->heighten($carpeta[1], function ($constraint) {
						$constraint->aspectRatio();
					});
				}
				$ruta = public_path().'/storage/'."/".$carpeta[0]."/";
				$imagen->save($ruta . $temp_name, 100);
                }

                if ($dia->nombre != "Dia Libre") {
                    
                    Storage::disk('public')->delete('big/'.$dia["imagen"]);
                    Storage::disk('public')->delete('medium/'.$dia["imagen"]);
                    Storage::disk('public')->delete('miniature/'.$dia["imagen"]);
                    Storage::disk('public')->delete('original/'.$dia["imagen"]);
                }

                $dia->imagen  = $temp_name;
            }elseif($data->name == "Dia Libre"){
                $dia->imagen = "dia_libre.jpg";
            }
            /* elseif($data->name == "Dia Libre") {
                $dia->imagen  = "dia_libre.jpg";
                 
                 Storage::disk('public')->delete('big/'.$dia["imagen"]);
                 Storage::disk('public')->delete('medium/'.$dia["imagen"]);
                 Storage::disk('public')->delete('miniature/'.$dia["imagen"]);
                 Storage::disk('public')->delete('original/'.$dia["imagen"]);
            } */
        
        
        $dia->nombre      = $data->name;
        $dia->descripcion = $data->text;
        $dia->update();
        return;
    }
    public function agregarActividad(Request $data,PaginaDia $day)
    {
        $actividad         = new PaginaActividad();
    	$actividad->nombre = $data->activity['name'];
        $actividad->tipo   = $data->activity['type'];
        /* $actividad->codigo   = $data->activity['code']; */
    	$actividad->dia_id    = $day->id;
    	$actividad->save();
    	if ($actividad->tipo == "restaurante") {
    		$nuevo                 = new PaginaActividadRestaurante();
    		$nuevo->restaurante_id = $data->activity['item_id'];
    		$nuevo->actividad_id   = $actividad->id;
    		$nuevo->save(); 
    	    return $actividad->load('restaurante.restaurante.peruano',
                                    'restaurante.restaurante.comunidad',
                                    'restaurante.restaurante.extranjero',
                                    'restaurante.restaurante.destino');
        }elseif ($actividad->tipo == "servicio") {
            $nuevo                = new PaginaActividadServicio();
    		$nuevo->servicio_id   = $data->activity['item_id'];
    		$nuevo->actividad_id  = $actividad->id;
    		$nuevo->save(); 
            return $actividad->load('servicio.servicio.peruano',
                                    'servicio.servicio.comunidad',
                                    'servicio.servicio.extranjero',
                                    'servicio.servicio.operador');
    	}
    	/*return back();//redirect()->route('managePaquete-paso-3-A' , [$dia->paquete_id] );*/
    }

    public function tool($actividad){
        $actividad = PaginaActividad::find($actividad);
        if ($actividad->tipo == 'restaurante') {
            foreach ($actividad->restaurante as $actRestaurante) {
                $actRest = PaginaActividadRestaurante::find($actRestaurante->id);
                $actRest->delete();
            }
        } elseif ($actividad->tipo == 'servicio') {
            foreach ($actividad->servicio as $actServicio) {
                $actServ = PaginaActividadServicio::find($actServicio->id);
                $actServ->delete();
            }
        }
        $actividad->delete();
    }

    public function eliminarActividad($actividad){
        $this->tool($actividad);
        return back()->with('info', 'La actividad fue eliminada exitosamente!.');
    }

    public function eliminarDia(PaginaDia $dia){
        if (count($dia->actividades) > 0) {
            
            foreach ($dia->actividades as $actividad) {
                $this->tool($actividad->id);
            }
        }
        if($dia->imagen != "dia_libre.jpg"){
            Storage::disk('public')->delete('big/'.$dia->imagen);
            Storage::disk('public')->delete('medium/'.$dia->imagen);
            Storage::disk('public')->delete('miniature/'.$dia->imagen);
            Storage::disk('public')->delete('original/'.$dia->imagen);
        }
        $dia->delete();
        return;
    }

    public function edit($id){
        return view('adminweb.paquetes.pasos.paso3')->with(['edit' => true,'paquete_id' => $id ]);
    }
    public function getPackage(PaginaPaquete $id){
        $id->load("dias.actividades.servicio.servicio.operador",
                  "dias.actividades.servicio.servicio.peruano",
                  "dias.actividades.servicio.servicio.comunidad",
                  "dias.actividades.servicio.servicio.extranjero",
                  "dias.actividades.restaurante.restaurante.peruano",
                  "dias.actividades.restaurante.restaurante.comunidad",
                  "dias.actividades.restaurante.restaurante.extranjero",
                  "listados.noches");
        /* dd($id); */
        return $id; 
    }
    public function changeUtility($utility , PaginaPaquete $package){
        $package->utilidad_promocion = $utility;
        $package->save();
        return;
    }
    /* public function cargarImagenes($data){
		
		return $temp_name;
		
	} */
}
