<?php

namespace App\Http\Controllers\Pagina;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaginaVentaCotizacionController extends Controller
{
   public function index(){
		

		return view('adminweb.paquetes.ventas.index');	
	}
}
