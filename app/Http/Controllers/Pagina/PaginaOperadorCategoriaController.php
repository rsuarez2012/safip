<?php

namespace App\Http\Controllers\Pagina;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pagina\PaginaCategoriaOperador;
class PaginaOperadorCategoriaController extends Controller{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $categoria=new PaginaCategoriaOperador();
        $categoria->nombre=$request->nombre;
        $categoria->save();
       return redirect()->route('manageOperador-A');
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
        //
        $categoria=PaginaCategoriaOperador::find($request->id);
        $categoria->nombre=$request->nombre;
        $categoria->save();
        return redirect()->route('manageOperador-A');
    }

    public function destroy(PaginaCategoriaOperador $categoria) {
        $categoria->delete();
        $message = $categoria ?'Registro eliminado correctamente' : 'Error al Eliminar';
        return redirect()->route('manageOperador-A')->with('message', $message);
        //dd($categoria);
    }
}
