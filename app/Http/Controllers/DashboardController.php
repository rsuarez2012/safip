<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VboletoP;
use App\User;
use App\Anio;
use DB;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware('web');
    }

    public function dashboard(){
        $banio = Anio::where('anio','=',date('Y'))->get();
        //dd($banio);
        $anios = Anio::all();
        if(count($banio) == 0){
            $banio = new Anio();
            $banio->anio = date('Y');
            $banio->save();
            $message = "Feliz Año nuevo". date('Y') ;
            $anio = Anio::orderBy('anio','desc')->pluck('anio')->first();
            $mes = date('m');
            //dd($mv, $contador,$o,$id,$tdatos);
            return view('/layouts.center.index',compact('anio','mes'))->with('message',$message);
        }else{
            $anio = Anio::orderBy('anio','desc')->pluck('anio')->first();
            $mes = date('m');
            //dd($mv, $contador,$o,$id,$tdatos);
            return view('/layouts.center.index',compact('anio','mes','anios'));
        }


    }

}
