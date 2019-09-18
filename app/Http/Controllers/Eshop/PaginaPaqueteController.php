<?php

namespace App\Http\Controllers\Eshop;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\modelsPagina\PaginaDestino;
use App\modelsPagina\PaginaPaquete;
use App\modelsPagina\PaginaCategoriaPaquete;
use App\Http\Requests\PaqueteProductoRequest;

class PaginaPaqueteController extends Controller
{
    public function index(){
        $paquetes = PaginaPaquete::all();
        return view('adminweb.paquetes.index',compact('paquetes'));
    }

    
}