<?php

namespace App\Http\Controllers\Pagina;

use Illuminate\Http\Request;
use App\Pagina\PaginaDestino;
use App\Pagina\PaginaPeruano;
use App\Pagina\PaginaComunidad;
use App\Pagina\PaginaActividad;
use App\Pagina\PaginaExtranjero;
use App\Pagina\PaginaRestaurante;
use App\Http\Controllers\Controller;
use App\pagina\PaginaActividadRestaurante;

class PaginaRestauranteController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        /* $restaurante= PaginaRestaurante::all();
        
        $peruano= PaginaPeruano::all();
        $extranjero= PaginaExtranjero::all();
        $comunidad= PaginaComunidad::all();      */
        $destinos= PaginaDestino::all();  
        return view('adminweb.restaurantes.index',compact("destinos"));
    }

    public function getRestaurantes(){
        $restaurantes= PaginaRestaurante::all();
        $restaurantes->load("peruano","comunidad","extranjero","destino");
        
        return $restaurantes;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $peruano=new PaginaPeruano();
        $peruano->adulto      =$request->restaurante["peruano_adulto"];
        $peruano->estudiante  =$request->restaurante["peruano_estudiante"];
        $peruano->ninio       =$request->restaurante["peruano_ninio"];
        $peruano->save();
        
        $extranjero=new PaginaExtranjero();
        $extranjero->adulto     =$request->restaurante["extranjero_adulto"];
        $extranjero->estudiante =$request->restaurante["extranjero_estudiante"];
        $extranjero->ninio      =$request->restaurante["extranjero_ninio"];
        $extranjero->save();

        $comunidad=new PaginaComunidad();
        $comunidad->adulto     =$request->restaurante["comunidad_adulto"];
        $comunidad->estudiante =$request->restaurante["comunidad_estudiante"];
        $comunidad->save();

        $restaurante=new PaginaRestaurante;  
        $restaurante->nombre        =$request->restaurante["nombre"];  
        $restaurante->destino_id    =$request->restaurante["destino_id"];
        $restaurante->peruano_id    =$peruano->id;
        $restaurante->extranjero_id =$extranjero->id;
        $restaurante->comunidad_id  =$comunidad->id;
        $restaurante->save();

        return ;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
        //
        /* return $request->all(); */
        $peruano= PaginaPeruano::find($request->restaurante["peruano_id"]);
        $peruano->adulto      =$request->restaurante["peruano_adulto"];
        $peruano->estudiante  =$request->restaurante["peruano_estudiante"];
        $peruano->ninio       =$request->restaurante["peruano_ninio"];
        $peruano->update();
        
        $extranjero= PaginaExtranjero::find($request->restaurante["extranjero_id"]);
        $extranjero->adulto     =$request->restaurante["extranjero_adulto"];
        $extranjero->estudiante =$request->restaurante["extranjero_estudiante"];
        $extranjero->ninio      =$request->restaurante["extranjero_ninio"];
        $extranjero->save();

        $comunidad=PaginaComunidad::find($request->restaurante["comunidad_id"]);
        $comunidad->adulto     =$request->restaurante["comunidad_adulto"];
        $comunidad->estudiante =$request->restaurante["comunidad_estudiante"];
        $comunidad->save();

        $restaurante= PaginaRestaurante::find($request->restaurante["id"]);
        $restaurante->nombre        =$request->restaurante["nombre"];  
        $restaurante->destino_id    =$request->restaurante["destino_id"];
        $restaurante->update();
        return ;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $restaurante= PaginaRestaurante::find($id);
        $restaurante->load('peruano', 'comunidad', 'extranjero', 'actividad.actividad');
        //dd($restaurante);
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
        return ;
    }
} 
