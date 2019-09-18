<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Pais;
use App\Ciudad;


class WebController extends Controller

{
   public function index(){
       $paises = Pais::all();
       $ciudades = Ciudad::all();
        return view('paginaexterna.center.index',  compact('paises','ciudades'));
   }
   public function contacto(){
        return view('contacto');
   }
   public function reviews(){
        return view('reviews');
   }
}















