<?php

namespace App\Http\Controllers\Pagina;

use App\Pagina\PaginaHotel;
use App\Pagina\PaginaNoche;
use Illuminate\Http\Request;
use App\Pagina\PaginaPaquete;
use App\Pagina\PaginaDestino;
use App\Pagina\PaginaListado;
use App\Pagina\PaginaDestinoPaquete;
use App\Http\Controllers\Controller;
 
class PaginaPaquetePaso2Controller extends Controller
{
    # Herramienta para simplificacion y uso de estos datos en varias funciones
    public function tool($id){
        $destinos = PaginaDestino::all();
        $paquete  = PaginaPaquete::findOrFail($id);
        $hoteles  = PaginaHotel::all();

        $enlazados = []; 
        $ultimo="";
        foreach ($paquete->enlazados as $enlace) {
            if ($ultimo == $enlace->codigo) {
                // VARIABLE CON NOCHES
                $noches = $enlace->noches->cantidad;
                // AGREGAR HOTEL A LA LISTA
                array_push($enlazados[$ultimo]['hoteles'],$enlace->hotel->nombre);
                // SUMAR TARIFAS DEL HOTEL
                $enlazados[$ultimo]['e_swb']+=($enlace->hotel->e_swb * $noches);
                $enlazados[$ultimo]['e_dwb']+=(($enlace->hotel->e_dwb * $noches)/2);
                $enlazados[$ultimo]['e_tpl']+=(($enlace->hotel->e_tpl * $noches)/3);
                $enlazados[$ultimo]['e_chd']+=($enlace->hotel->e_chd * $noches)/4;
                $enlazados[$ultimo]['p_swb']+=($enlace->hotel->p_swb * $noches);
                $enlazados[$ultimo]['p_swb']+=(($enlace->hotel->p_dwb * $noches)/2);
                $enlazados[$ultimo]['p_tpl']+=(($enlace->hotel->p_tpl * $noches)/3);
                $enlazados[$ultimo]['p_chd']+=($enlace->hotel->p_chd * $noches)/4; 
            }else{
                // VARIABLE CON NOCHES
                $noches = $enlace->noches->cantidad;
                // NUEVO INDICE CON DATOS
                $enlazados[$enlace->codigo] =
                ['hoteles' => [],
                'estado' => $enlace->estado,
                'codigo' => $enlace->codigo,
                'estrella' => $enlace->hotel->estrella,
                'categoria' =>$enlace->hotel->categoria->nombre,
                'e_swb' => ($enlace->hotel->e_swb * $noches),
                'e_dwb' => (($enlace->hotel->e_dwb * $noches)/2),
                'e_tpl' => (($enlace->hotel->e_tpl * $noches)/3),
                'e_chd' => ($enlace->hotel->e_chd * $noches)/4,
                'p_swb' => ($enlace->hotel->p_swb * $noches),
                'p_dwb' => (($enlace->hotel->p_dwb * $noches)/2),
                'p_tpl' => (($enlace->hotel->p_tpl * $noches)/3),
                'p_chd' => ($enlace->hotel->p_chd * $noches)/4];
                // AGREGO EL HOTEL AL ARRAY HOTEL 
                array_push($enlazados[$enlace->codigo]['hoteles'],$enlace->hotel->nombre); 
            }
            
            $ultimo = $enlace->codigo;
        }
        dd($enlazados);
        return compact('destinos','paquete','hoteles','enlazados');
    }

    // CRUD
    public function create(PaginaPaquete $paquete){
        //dd($paquete);
        $paquete->load('listados.destino.hoteles.categoria', 'listados.noches','enlazados.hotel', 'enlazados.noches');
        $destinos = PaginaDestino::all();

        return view('adminweb.paquetes.pasos.paso2')->with([
            'edit'      => false,
            'paquete'   => $paquete,
            'destinos' => $destinos,
        ]);
    }

    // DESTINOS
    public function agregarDestino(Request $request, PaginaPaquete $paquete)
    {
        //dd($request->all());
        $paque = $request->id;

        $destinoPaquete = PaginaDestinoPaquete::where('paquete_id', $paquete->id)->where('destino_id', $request['destino_id'])->count();

        /*foreach ($request['destinos'] as $destino) {

            $noche = PaginaNoche::create([
                'cantidad' => $destino['noches']
            ]);
            
            PaginaDestinoPaquete::create([
                'noche_id'      => $noche->id,
                'destino_id'    => $destino['destino_id'],
                'paquete_id'    => $destino['paquete_id'],
            ]);
        }*/
        $noche = PaginaNoche::create([
            'cantidad' => $request->noches,
        ]);
        
        PaginaDestinoPaquete::create([
            'noche_id'      => $noche->id,
            'destino_id'    => $request->destino_id,
            'paquete_id'    => $paque,
        ]);

        $destinosP = PaginaDestinoPaquete::where('paquete_id', $paque)->get();
        //dd($destinosP);
        
        //return 1;
        return redirect()->route('paquete.editar',$paque)->with('destinosP');
    }

    public function destroyDestino(Request $request) 
    {
        //dd($request->all());
        $destinoPaquete = PaginaDestinoPaquete::findOrFail($request['id']);
        //dd($destinoPaquete);
        $destinoPaquete->delete();
        $paque = $destinoPaquete->paquete_id;
        $destinosP = PaginaDestinoPaquete::where('paquete_id', $paque)->get();
        //return;
        return redirect()->route('paquete.editar',$paque)->with('destinosP');
    }

    public function enlazar(PaginaPaquete $paquete, Request $request){

        //dd($request->all());
        $dest = null;
        foreach ($request['destinos'] as $destino) {
            $codigo = bcrypt(str_random(15) . rand(1,999)).date("ymd");
            $dest = $destino['destino_id'];
            $noche = PaginaNoche::create([
                'cantidad' => $destino['noches']
            ]);    
            PaginaListado::create([
                'codigo'        => $codigo,
                'noche_id'      => $noche->id,
                'hotel_id'      => $destino['hotel_id'],
                'paquete_id'    => $destino['paquete_id'],
            ]);
        }
        /*if(count($request->multis) > 0){
            //bcrypt(str_random(15) . rand(1,999)).date("ymd");
            foreach($request->multis as $ml){
                $codigo = bcrypt(str_random(15) . rand(1,999)).date("ymd");
                if(count($request->destinos) > 0 && $request->destinos[0]['hijo'] > 0){
                    PaginaListado::create([
                        'codigo'        => $codigo,
                        'noche_id'      => $request->noche,
                        'hotel_id'      => $ml,
                        'paquete_id'    => $paquete->id,
                    ]);
                    foreach($request->destinos as $dest){
                        if($dest['hijo'] > 0){
                            PaginaListado::create([
                                'codigo'        => $codigo,
                                'noche_id'      => $dest['noche'],
                                'hotel_id'      => $dest['hijo'],
                                'paquete_id'    => $paquete->id,
                            ]);
                        }
                    }
                } else {
                    PaginaListado::create([
                        'codigo'        => $codigo,
                        'noche_id'      => $request->noche,
                        'hotel_id'      => $ml,
                        'paquete_id'    => $paquete->id,
                    ]);
                }
            }
            //return;
        } else {
            $codigo = bcrypt(str_random(15) . rand(1,999)).date("ymd");
            foreach($request->destinos as $dest){
                if($dest['hijo'] > 0){
                    PaginaListado::create([
                        'codigo'        => $codigo,
                        'noche_id'      => $dest['noche'],
                        'hotel_id'      => $dest['hijo'],
                        'paquete_id'    => $paquete->id,
                    ]);
                }
            }
            //return;
        }*/
        $paquete->load('listados.destino.hoteles.categoria', 'listados.noches','enlazados.hotel', 'enlazados.noches');
        return $paquete;
        //return redirect()->route('paquete.editar', $paquete);
        //return redirect()->back()->with($paquete);
    }

    public function estado($codigo){
        $hoteles = PaginaListado::where("codigo","=",$codigo)->get();
        $estado = "";
        foreach ($hoteles as $hotel) {
            if ($hotel->estado == "oculto") {
                $hotel->estado = 'visible';
                $hotel->save();
                $estado = true;
            }else{
                $hotel->estado = 'oculto';
                $hotel->save();
                $estado = false;
            }
        }
        return response()->json([
            'estado' => $estado,
        ]);
    }

    public function eliminarEnlace(Request $request)
    {
        //dd($request->all());
        $enlace = PaginaListado::where('paquete_id', $request['enlazado_id'])->get();
        //$enlace = PaginaListado::where('id', $request['enlazado_id'])->first();
        //dd($enlace);
        $enlace->each->delete();

        $enlazados = PaginaListado::all();
        $response = [];

        foreach($enlazados as $enlazado) {
            array_push($response, ['id' => $enlazado->id, 
                                   'hotel' => $enlazado->hotel->nombre,
                                   'estrella' => $enlazado->hotel->estrella,
                                   'p_swb' => $enlazado->hotel->p_swb,
                                   'p_dwb' => $enlazado->hotel->p_dwb,
                                   'p_tpl' => $enlazado->hotel->p_tpl,
                                   'p_chd' => $enlazado->hotel->p_chd,
                                   'e_swb' => $enlazado->hotel->e_swb,
                                   'e_dwb' => $enlazado->hotel->e_dwb,
                                   'e_tpl' => $enlazado->hotel->e_tpl,
                                   'e_chd' => $enlazado->hotel->e_chd,

                                    ]);
        }
        return response()->json($response);
    }

    public function destacar_ind(Request $request)
    {
        $listados = PaginaListado::where('codigo',$request->codigo)->get();
        foreach($listados as $list){
            if($list->destacado == 0){
                $set_to = 1;
                $list->destacado = 1;
                $list->update();
                $message = 'Hoteles colocados como Destacados!.';
            } else {
                $set_to = 0;
                $list->destacado = 0;
                $list->update();
                $message = 'Estos hoteles ya no están como Destacados!.';
            }
        }
        $paquete = PaginaPaquete::find($request->paquete_id)
                                ->load('listados.destino.hoteles.categoria',
                                        'listados.noches','enlazados.hotel',
                                        'enlazados.noches');
        return response()->json([
            'set_to'    => $set_to,
            'message'   => $message,
            'paquete'  => $paquete,
        ]);
    }
    public function destacar_varios(PaginaPaquete $paquete, Request $request)
    {
        foreach($paquete->enlazados as $en){
            $en->destacado = 0;
            $en->update();
        }

        if(count($request->cinco) > 0){
            foreach($request->cinco as $c){
                $enlaces = PaginaListado::where("codigo",$c)->get();
                foreach($enlaces as $enl){
                    $enl->destacado = 1;
                    $enl->update();
                }
            };
        }

        $paquete = PaginaPaquete::find($paquete->id)
                                ->load('listados.destino.hoteles.categoria',
                                        'listados.noches','enlazados.hotel',
                                        'enlazados.noches');
        return response()->json([
            'paquete'  => $paquete,
        ]);
    }

    public function edit(PaginaPaquete $paquete){
        $paquete->load('listados.destino.hoteles.categoria', 'listados.noches','enlazados.hotel', 'enlazados.noches');
        $destinos = PaginaDestino::get();

        return view('adminweb.paquetes.pasos.paso2')->with([
            'edit'      => true,
            'paquete'   => $paquete,
            'destinos' => $destinos,
        ]);
    }
    /*public function editDays(Request $request)
    {
        dd($request->all());
        //$dias_actuales = PaginaDestinoPaquete::where('paquete_id', $request['paquete_id'])->where('destino_id', $request['destino_id'])->count();
        $dias_actuales = PaginaDestinoPaquete::where('paquete_id', $request['id'])->where('destino_id', $request['destino_id'])->count();

        if($request['dias'] > $dias_actuales)
            $nuevos_dias = $request['dias'] - $dias_actuales;

        $noches = PaginaNoche::find($request['id']);
        $noches->cantidad = $request['dias'];
        $noches->save();

        for($i = 0; $i < $nuevos_dias; $i++)
        {
            $d = PaginaDestinoPaquete::create([
                'noche_id' => $noches->id,
                'destino_id' => $request['destino_id'],
                //'paquete_id' => $request['paquete_id']
                'paquete_id' => $request['id']
            ]);

            dd($d);
        }

        return 1;

    }*/

     public function editDays(Request $request)
    {

        $dias_actuales = PaginaDestinoPaquete::where('paquete_id', $request['paquete_id'])->where('destino_id', $request['destino_id'])->count();

        if($request['dias'] > $dias_actuales)
            $nuevos_dias = $request['dias'] - $dias_actuales;

        $noches = PaginaNoche::find($request['id']);
        $noches->cantidad = $request['dias'];
        $noches->save();

        for($i = 0; $i < $nuevos_dias; $i++)
        {
            $d = PaginaDestinoPaquete::create([
                'noche_id' => $noches->id,
                'destino_id' => $request['destino_id'],
                'paquete_id' => $request['paquete_id']
            ]);

            dd($d);
        }

        return 1;

    }
    
    public function load_paquete(PaginaPaquete $paquete)
    {
        $paquete->load('listados.destino.hoteles.categoria', 'listados.noches','enlazados.hotel', 'enlazados.noches');
        return $paquete;
    }

    public function load_destinos(Request $request)
    {
        // buscamos los destinos que no esten en el mis_destinos
        /* $other_destinos = PaginaDestino::whereNotIn('id', $request->destinos)->get();
        $other_destinos->load('hoteles');
        return $other_destinos; */
        $paquete = PaginaPaquete::find($request->paquete);
        $mis_destinos_ids = [];
        $otros = [];
        // recorremos los detinos asociados para guardar su id
        foreach ($paquete->listados as $destinoPaquete) {
            array_push($mis_destinos_ids, $destinoPaquete->destino->id);
        }
        // buscamos los destinos que no esten en el array mis_destinos
        $other_destinos = PaginaDestino::whereNotIn('id', $mis_destinos_ids)->get();
        $other_destinos->load('hoteles');
        foreach ($other_destinos as $other) {
            if(count($other->hoteles) > 0){
                array_push($otros, $other);
            }
        }
        return $otros;
    }
}