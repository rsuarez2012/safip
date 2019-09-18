<?php

namespace App\Http\Controllers\Eshop;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\modelsPagina\PaginaDestino;
use App\Http\Requests\modelsPagina\PaginaDestinoRequest;
class PaginaDestinoController extends Controller
{
    public function index($id){
        $destino=PaginaDestino::find($id);
        return view('e-shop.products.tarifas.index',compact('destino'));
    }

     public function store(Request $data)
    {
        $destino = new PaginaDestino();
        $destino->nombre=$data->nombre;
        $destino->save();
        $message = $destino ? 'Categoría agregada correctamente' : 'La categoría NO pudo agregarse';

        return redirect()->route('manageProduct-A')->with('message', $message);
    }
    public function update($id){
        dd($id);
    	$destino= PaginaDestino::find($data->editar_destino['id']);
        $destino->nombre=$data->editar_destino['nombre'];
        $destino->save();
        return ;
    }
    public function destroy($id)
    {
        $destino = PaginaDestino::find($id);
        $destino->delete();
        $message = $destino ? 'Categoría eliminada correctamente' : 'La categoría NO pudo eliminarse';
        return redirect()->route('manageProduct-A')->with('message', $message);
    }
}