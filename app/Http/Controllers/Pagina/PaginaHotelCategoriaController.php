<?php

namespace App\Http\Controllers\Pagina;

use App\Pagina\PaginaHotel;
use Illuminate\Http\Request;
use App\Pagina\PaginaListado;
use App\Http\Controllers\Controller;
use App\Pagina\PaginaCategoriaHotel;
class PaginaHotelCategoriaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $categoria=new PaginaCategoriaHotel();
        $categoria->nombre=$request->nombre;
        $categoria->save();
        //return ;
        $info = $categoria ? 'Se ha registrado la categoria "'. $request->nombre .'" de forma exitosa.!.' : 'Error al Editar';
        return redirect()->back()->with('info', $info);
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
        $categoria=PaginaCategoriaHotel::find($request->datos_categorias['id']);
        $categoria->nombre=$request->datos_categorias['nombre'];
        $categoria->save();
        return ;
    }

    public function destroyCategoria($categoria_delete){
        $categoria=PaginaCategoriaHotel::find($categoria_delete);
        $categoria->load('hoteles');
        // buscar para eliminar todos los hoteles que pertenecen a esta categoria
        foreach ($categoria->hoteles as $hotel) {
            $hotel = PaginaHotel::find($hotel->id);
            $hotel->load('listados');
            // buscar para eliminar todos el listado de enlaces de este hotel
            foreach ($hotel->listados as $listado) {
                $listadoHotelesEnlazados = PaginaListado::where('codigo', $listado->codigo)->get();
                // buscar para eliminar los enlaces con el mismo codigo
                foreach ($listadoHotelesEnlazados as $hotelenlazado) {
                    $hotelist = PaginaListado::find($hotelenlazado->id);
                    $hotelist->delete();
                }
            }
            $hotel->delete();
        }
        $categoria->delete();
        return redirect()->back();
    }

}
