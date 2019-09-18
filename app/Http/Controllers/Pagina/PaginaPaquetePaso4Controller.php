<?php

namespace App\Http\Controllers\Pagina;

use Illuminate\Http\Request;
use App\Pagina\PaginaPaquete;
use App\Pagina\PaginaDatoPaquete;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;

class PaginaPaquetePaso4Controller extends Controller
{
    public function index(PaginaPaquete $paquete){
        /* if($paquete->dias->count() == 0){
            return back()->with('error', 'No puede dar siguiente si no ha creado días!.');
        }
        foreach ($paquete->dias as $dia) {
            if ($dia->actividades->count() == 0) {
                return back()->with('error', 'No puede dar siguiente si alguno de sus días no posee actividades!.');
            }
        } */
    	// CAMBIAR ESTATUS DE PAQUETE
    	//$paquete = PaginaPaquete::find($paquete_id);
       

        $datos = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'incluido')->get();
        $llevar = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'llevar')->get();
        $politicas = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'politcareserva')->get();
        $fechas = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'fechas')->get();
        $noincluidos = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'noincluido')->get();
        $tarifas = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'politicatarifa')->get();
        $responsabilidades = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'responsabilidades')->get();
        $importantes = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'importante')->get();
        //dd($datos);
        $paquete_id = $paquete;
        $dat = $paquete->id;


    	$paquete->statusCreado=4;
    	$paquete->save();
        //dd($paquete);
    	return view('adminweb.paquetes.pasos.paso4',compact('paquete', 'categorias', 'id', 'codigo', 'nombre', 'estado', 'descripcion', 'extracto', 'categoria_id', 'cupos', 'fecha_salida', 'fecha_llegada','datos', 'paquete_id', 'llevar', 'politicas', 'fechas', 'noincluidos', 'tarifas', 'responsabilidades', 'importantes', 'dat'));
    }

    public function cargar_data_base(PaginaPaquete $paquete){
        return $paquete->load('datos');
        //return $paquete->with('datos')->get();
    }

    public function edit(PaginaPaquete $paquete)
    {
        //dd($paquete);
        $datos = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'incluido')->get();
        $llevar = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'llevar')->get();
        $politicas = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'politcareserva')->get();
        $fechas = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'fechas')->get();
        $noincluidos = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'noincluido')->get();
        $tarifas = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'politicatarifa')->get();
        $responsabilidades = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'responsabilidades')->get();
        $importantes = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'importante')->get();
        //dd($datos);
        $paquete_id = $paquete;
        $dat = $paquete->id;
        return view('adminweb.paquetes.pasos.paso4',compact('paquete', 'categorias', 'id', 'codigo', 'nombre', 'estado', 'descripcion', 'extracto', 'categoria_id', 'cupos', 'fecha_salida', 'fecha_llegada','datos', 'paquete_id', 'llevar', 'politicas', 'fechas', 'noincluidos', 'tarifas', 'responsabilidades', 'importantes', 'dat'));
    }

    public function agregarDato($paquete_id, Request $data){
        /*if($data->ajax()){
            dd($data->all());

        }*/
        /*if($data->ajax()) {
            $dato = PaginaDatoPaquete::create($data->all());
        //return response()->json(['message' => 'Insertado correctamente']);
        return redirect()->back();
        }*/
        //if($data->ajax()){
        	$dato             = new PaginaDatoPaquete();
        	//$dato->texto      = $data->texto_dato;
        	//$dato->tipo       = $data->tipo_dato;
        	//$dato->paquete_id = $paquete_id;
            $dato->texto      = $data->texto;
            $dato->tipo       = $data->tipo;
            $dato->paquete_id = $data->paquete_id;
        	$dato->save();
        	//return;
            return back();
            //return response()->json($dato);

        //}
    }

    public function editarDato(PaginaDatoPaquete $dato, Request $request){
        //dd($request->all());
        if($request->ajax()){

            $dato->texto = $request->texto;
            $dato->update();
            return;
            //dd($request->all());
            ///$dato = PaginaDatoPaquete::all()->where('id', $dato);
            //$dato->texto = $request->texto;
            //$dato->update();
            //return;


        }
    }

    public function eliminarDato(Request $request, $dato_id){
        //dd($dato_id);
        /*$dato = PaginaDatoPaquete::findOrFail($dato_id);
        $dato->delete();*/
        /* $dato_id */
        if($request->ajax()){

            $datos = PaginaDatoPaquete::all();
            //$where = array('id', $dato_id);
            $dato = PaginaDatoPaquete::where('id', $dato_id)->first();
            $dato->delete();
            return; /* response()->json([
                'mensaje' => "Se Elimino El Dato Correctamente",
            ]); */
        }
    }

    public function buscar_paquete(Request $request){
        $nombre = $request->get('name_paquete');
        $id_act = $request->get('id_paquete_act');
        $paquetes = PaginaPaquete::where('nombre','LIKE', "%$nombre%")->orWhere('codigo', 'LIKE', "%$nombre%")->where('id', '!=', $id_act)->get();
        $paquetes->load('datos');
        return  /* $request->get('name_paquete'); */
                $paquetes;
    }

    public function agregar_datos_paquete($tipo, PaginaPaquete $paquete, PaginaPaquete $paquete_act){
        $datos = $paquete->datos()->where('tipo', $tipo)->get();
        foreach($datos as $dato){
            PaginaDatoPaquete::create([
                'texto'         => $dato->texto,
                'tipo'          => $dato->tipo,
                'paquete_id'    => $paquete_act->id
            ]);
        }
        return;
    }
    public function imprmirPaquete($id){
        $paquete = PaginaPaquete::findOrFail($id);
        $paquete->load("dias","listados","salidas","enlazados");

        $enlazados = [];
        $itinerario = [];
        if($paquete->enlazados->count() > 0){
            $enlazados = $paquete->calculate_itinerary_final($paquete);
        } else {
            $itinerario = $paquete->calcularActividades($paquete);
        }

        $datos = [
            'incluidos'         => [],
            'noincluidos'       => [],
            'llevar'            => [],
            'importantes'       => [],
            'politicaTarifa'    => [],
            'politicaReserva'   => [],
            'fechas'            => [],
            'responsabilidades' => []
        ];
        foreach ($paquete->datos as $dato) {
            if ($dato->tipo == "incluido") {
                array_push($datos['incluidos'], $dato->texto);
            }elseif ($dato->tipo == "noincluido") {
                array_push($datos['noincluidos'], $dato->texto);
            }elseif ($dato->tipo == "llevar") {
                array_push($datos['llevar'], $dato->texto);
            }elseif ($dato->tipo == "importante") {
                array_push($datos['importantes'], $dato->texto);
            }elseif ($dato->tipo == "politicatarifa") {
                array_push($datos['politicaTarifa'], $dato->texto);
            }elseif ($dato->tipo == "politcareserva"){
                array_push($datos['politicaReserva'], $dato->texto);
            }elseif ($dato->tipo == "fechas") {
                array_push($datos['fechas'], $dato->texto);
            }elseif ($dato->tipo == "responsabilidades") {
                array_push($datos['responsabilidades'], $dato->texto);
            }
        }
        //dd($enlazados, $itinerario, $datos);

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

        //dd($enlazados, $itinerario, $datos);
        /* dd($enlazados["$2y$10$5rOb.qClWqFMuL6KWGYA.uVxYbhLGNvjmjPGBJ5MU1YGKBhy8kMBm181218"]); */
        
        /* $view =  \View::make('pdf.ticket')->with('reservation',$reservation)->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('boleto.pdf'); */
        /* dd($paquete->datos); */
        /* return view("adminweb.paquetes.pasos.pdf.paquete")->with('paquete',$paquete)->with('enlazados',$enlazados); */
        $pdf = PDF::loadView('adminweb.paquetes.pasos.pdf.paquete',compact("paquete", "enlazados", 'itinerario', 'datos'));
        /* return view('adminweb.paquetes.pasos.pdf.paquete',compact("paquete", "enlazados", 'itinerario', 'datos')); */
        return $pdf->download('PAQUETE-'.$paquete->nombre.'.pdf');
                
        /* $view =  \View::make('adminweb.paquetes.pasos.pdf.paquete')->with('paquete',$paquete)->with('enlazados',$listado_costos)->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream("paquete.pdf"); */
    }
}
