<?php

namespace App\Http\Controllers\Pagina;

use App\Pagina\PaginaDia;
use App\Pagina\PaginaNoche;
use Illuminate\Http\Request;
use App\Pagina\PaginaDestino;
use App\Pagina\PaginaPaquete;
use App\Pagina\PaginaServicio;
use App\Pagina\PaginaActividad;
use App\Pagina\PaginaRestaurante;
use App\Http\Controllers\Controller;
use App\Pagina\PaginaDestinoPaquete;
use App\Pagina\PaginaCategoriaPaquete;
use Illuminate\Support\Facades\Storage;
use App\Pagina\PaginaActividadServicio;
use App\Pagina\PaginaActividadRestaurante;
use Intervention\Image\ImageManagerStatic as Image;

class PaginaPaqueteFullDayController extends Controller
{
    public function index(){
        $cat_full_day = PaginaCategoriaPaquete::where('nombre', 'FULL DAY')->first();
        $paquetes = [];
        if($cat_full_day != null){
            $paquetes = PaginaPaquete::where('categoria_id', $cat_full_day->id)->orderBy('id', 'desc')->get();
        }
        return view('adminweb.paquetes.full_Day.index', compact('paquetes'));
    }

    public function create(){
        $cat_full_day = PaginaCategoriaPaquete::where('nombre', 'FULL DAY')->first();
        return view('adminweb.paquetes.full_Day.create')
                ->with([
                    'paquete_id' => 0/* 92 */,
                    'categoria_id' => $cat_full_day->id,
                ]);
    }

    public function edit(PaginaPaquete $paquete){
        $cat_full_day = PaginaCategoriaPaquete::where('nombre', 'FULL DAY')->first();
        return view('adminweb.paquetes.full_Day.create')
                ->with([
                    'paquete_id' => $paquete->id,
                    'categoria_id' => $cat_full_day->id,
                ]);
    }

    public function cargarImagenes($data){
        $carpetas = [["original",null],["miniature",150],["medium",300],["big",700]];
        
            if ($data->file('imagen')) 
            {
                $imagenOriginal = $data->file('imagen');
                
                $temp_name ="img_paquete_full_day_" .str_random(15) . '_'. date("ymd") .".". $imagenOriginal->getClientOriginalExtension();
                foreach($carpetas as $index => $carpeta){
                    if($index != 0){
                        /* $imagen->heighten($carpeta[1], function ($constraint) {
                            $constraint->aspectRatio();
                        }); */
                        $imagen = Image::make($imagenOriginal)->resize($carpeta[1],null,
                        function($constraint){
                            $constraint->aspectRatio();
                        })
                        ->resizeCanvas($carpeta[1],null);
                    }else{
                        $imagen = Image::make($imagenOriginal);
                    }
                    $ruta = public_path().'/storage/'.$carpeta[0].'/full_day/';
                    $imagen->save($ruta . $temp_name, 100);
                }
            }
        return $temp_name;
    }

    public function store_basic_data(Request $request){
        $paquete = PaginaPaquete::create([
            'codigo'        => strtoupper($request->codigo),
            'nombre'        => $request->nombre,
            'descripcion'   => $request->descripcion,
            'extracto'      => $request->extracto,
            'imagen'        => $this->cargarImagenes($request),
            'tipo_tarifa'   => 'neto',
            'categoria_id'  => $request->categoria_id,
        ]);
        return $this->load_paquete($paquete);
    }

    public function update_basic_data(PaginaPaquete $paquete, Request $request){
        if($request->file('imagen')){
            Storage::disk('public')->delete('big/'.$paquete->imagen);
            Storage::disk('public')->delete('medium/'.$paquete->imagen);
            Storage::disk('public')->delete('miniature/'.$paquete->imagen);
            Storage::disk('public')->delete('original/'.$paquete->imagen);
            $paquete->imagen = $this->cargarImagenes($request);
        }
        $paquete->nombre = $request->nombre;
        $paquete->update();

        $paquete = PaginaPaquete::find($paquete->id)->load('listados', 'dias.actividades');
        return $paquete;
    }

    public function load_paquete(PaginaPaquete $paquete){
        $mis_destinos_ids   = [];
        $other_destinos     = [];
        if($paquete->listados->count() > 0){
            foreach ($paquete->listados as $destinoPaquete) {
                array_push($mis_destinos_ids, $destinoPaquete->destino->id);
            }
        }
        //->load('restaurantes', 'operadores.servicios')
        $other_destinos = PaginaDestino::whereNotIn('id', $mis_destinos_ids)->get();
        return response()->json([
            'paquete'       => $paquete->load('listados.destino', 'dias.actividades'),
            'otros_destinos'=> $other_destinos->load('restaurantes', 'operadores.servicios'),
        ]);
    }

    public function load_mis_destinos(PaginaPaquete $paquete){
        $mis_destinos_ids   = [];
        $mis_destinos       = [];
        if($paquete->listados->count() > 0){
            foreach ($paquete->listados as $destinoPaquete) {
                array_push($mis_destinos_ids, $destinoPaquete->destino->id);
            }
            if(count($mis_destinos_ids) > 0){
                $mis_destinos = PaginaDestino::whereIn('id', $mis_destinos_ids)->get();
            }
        }
        $paquete->load('dias.actividades.restaurante.restaurante.peruano','dias.actividades.restaurante.restaurante.comunidad',
                        'dias.actividades.restaurante.restaurante.extranjero','dias.actividades.servicio.servicio.peruano',
                        'dias.actividades.servicio.servicio.comunidad','dias.actividades.servicio.servicio.extranjero');

        if(count($mis_destinos_ids) > 0){
            $mis_destinos->load('restaurantes','operadores.servicios.operador');
        }

        return response()->json([
            'paquete'       => $paquete,
            'cant_dest'     => count($mis_destinos),
            'mis_destinos'  => $mis_destinos,
        ]);
    }

    public function store_destino(PaginaPaquete $paquete, Request $request){
        $destinoPaquete = PaginaDestinoPaquete::where('paquete_id', $paquete->id)
                                            ->where('destino_id', $request->destino_id)
                                            ->count();
        if($destinoPaquete == 0){
            $noche = PaginaNoche::create([
                'cantidad'  => 0
            ]);
            PaginaDestinoPaquete::create([
                'noche_id'      => $noche->id,
                'destino_id'    => $request->destino_id,
                'paquete_id'    => $paquete->id,
            ]);
        }
        return $this->load_paquete($paquete);
    }

    public function delete_destino(PaginaPaquete $paquete, Request $request){
        $destinoPaquete = PaginaDestinoPaquete::findOrFail($request->destino_id);
        $destinoPaquete->delete();
        return $this->load_paquete($paquete);
    }

    public function save_dia(Request $request){
        $path = Storage::disk('public')->put('full_day/dia', $request->file('imagen'));
        PaginaDia::create([
            'nombre'        => $request->nombre,
            'descripcion'   => $request->descripcion,
            'paquete_id'    => $request->paquete_id,
            'imagen'        => $path
        ]);
        return;
    }

    public function update_dia(PaginaDia $dia, Request $request){
        $path = $dia->imagen;
        if($request->file('imagen')){
            Storage::disk('public')->delete($dia->imagen);
            $path = Storage::disk('public')->put('full_day/dia', $request->file('imagen'));
        }
        $dia->nombre        = $request->nombre;
        $dia->descripcion   = $request->descripcion;
        $dia->imagen = $path;
        $dia->update();
        return;
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

    public function delete_dia(PaginaDia $dia){
        if (count($dia->actividades) > 0) {
            foreach ($dia->actividades as $actividad) {
                $this->tool($actividad->id);
            }
        }
        Storage::disk('public')->delete($dia->imagen);
        $dia->delete();
        return;
    }

    public function save_new_percent(PaginaPaquete $paquete, Request $request){
        $paquete->utilidad_promocion = 0;
        $paquete->percent_full_day = $request->new_percent;
        $paquete->update();
        return;
    }

    public function delete_paquete(PaginaPaquete $paquete){
        $paquete->delete();
        return back()->with("info", "Paquete eliminado con exito!.");
    }

    public function change_state(PaginaPaquete $paquete, Request $request){
        $paquete->estado = $request->estado;
        $paquete->update();
        return response()->json([
            'paquete' => $paquete,
            'estado' => $request->estado,
        ]);
    }
}
