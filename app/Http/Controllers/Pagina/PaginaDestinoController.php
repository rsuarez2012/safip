<?php

namespace App\Http\Controllers\Pagina;

use App\Operador;
use App\Pagina\PaginaHotel;
use App\Pagina\PaginaNoche;
use Illuminate\Http\Request;
use App\Pagina\PaginaListado;
use App\Pagina\PaginaDestino;
use App\Pagina\PaginaPeruano;
use App\Pagina\PaginaComunidad;
use App\Pagina\PaginaActividad;
use App\Pagina\PaginaExtranjero;
use App\Pagina\PaginaRestaurante;
use App\Pagina\PaginaDestinoPaquete;
use App\Http\Controllers\Controller;
use App\pagina\PaginaActividadRestaurante;

class PaginaDestinoController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $destino= PaginaDestino::all();
        return view('adminweb.destinos.index', compact('destino'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //
        $destinos=new PaginaDestino();
        $destinos->nombre=$request->nuevo_destino;
        $destinos->save();
        return ;
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $destinos= PaginaDestino::find($request->nuevo_destino['id']);
        $destinos->nombre=$request->nuevo_destino['nombre'];
        $destinos->save();
        return ;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($destino)
    {   
        $destino = PaginaDestino::find($destino);
        foreach ($destino->operadores as $operador) {
            $operador = Operador::findOrFail($operador->id);
            $operador->delete();
        }
        
        $destino->load('hoteles', 'listados', 'restaurantes');
        foreach ($destino->restaurantes as $restaurante) {
            $restaurante = PaginaRestaurante::find($restaurante->id);
            foreach ($restaurante->actividad as $actividadRestaurante) {
                $actRest = PaginaActividadRestaurante::find($actividadRestaurante->id);
                $actividad = PaginaActividad::find($actRest->actividad_id);
                $actividad->delete();
                $actRest->delete();
            }
            if ($restaurante->peruano != null) {
                $peruano = PaginaPeruano::find($restaurante->peruano_id);
                $peruano->delete();
            }
            if ($restaurante->comunidad != null) {
                $comunidad = PaginaComunidad::find($restaurante->comunidad_id);
                $comunidad->delete();
            }
            if ($restaurante->extranjero != null) {
                $extranjero = PaginaExtranjero::find($restaurante->extranjero_id);
                $extranjero->delete();
            }
            $restaurante->delete();
        }

        // buscar y eliminar los Hoteles dentro de este destino
        foreach ($destino->hoteles as $hotel) {
            $hotel = PaginaHotel::find($hotel->id);
            $hotel->load('listados');
            // buscar el listado de enlaces que tienes este hotel
            foreach ($hotel->listados as $listado) {
                $listadoHotelesEnlazados = PaginaListado::where('codigo', $listado->codigo)->get();
                // buscar el enlace de hoteles con el mismo codigo
                foreach ($listadoHotelesEnlazados as $hotelenlazado) {
                    $hotelist = PaginaListado::find($hotelenlazado->id);
                    $hotelist->delete();
                }
            }
            $hotel->delete();
        }
       
        //buscar y eliminar los destinoPaquetes
        foreach ($destino->listados as $destinoPaquete) {
            $destinoPaquete = PaginaDestinoPaquete::find($destinoPaquete->id);
            $noche = PaginaNoche::find($destinoPaquete->noche_id);
            $destinoPaquete->delete();
            $noche->delete();
        }
        $destino->delete();

        return ;
    }
}