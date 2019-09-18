<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Pais;
use App\VboletoP;
use App\Publicaciones;
use App\Http\Requests;
use App\TipoPublicaciones;
use App\Coperacionesbancarias;
use App\Http\Controllers\Controller;

class GraficasController extends Controller
{
    public function getvBoletosP($anio_mes)
    {
        $vboletos = VboletoP::where('created_at', 'LIKE', "%$anio_mes%")->get();
        $ope_ban = Coperacionesbancarias::where('fecha', 'LIKE', "%$anio_mes%")->where('tipo_operacion','Gastos')->get();
        return Response()->json(['vboletosp'=>$vboletos,'ope_ban'=>$ope_ban]);
    }

    public function getUltimoDiaMes($elAnio,$elMes) {
     return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
    }

    public function registros_mes($anio,$mes)
    {
        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );
        $usuarios= VboletoP::whereBetween('created_at', [$fecha_inicial,  $fecha_final])->get();
        $ct=count($usuarios);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;     
        }

        foreach($usuarios as $usuario){
        $diasel=intval(date("d",strtotime($usuario->created_at) ) );
        $registros[$diasel]++;    
        }

        $data=array("totaldias"=>$ultimo_dia, "registrosdia" =>$registros);
        return   json_encode($data);
    }

    public function ventas($anio,$mes)
    {
        $primer_dia=1;
        $ultimo_dia=$this->getUltimoDiaMes($anio,$mes);
        $fecha_inicial=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$primer_dia) );
        $fecha_final=date("Y-m-d H:i:s", strtotime($anio."-".$mes."-".$ultimo_dia) );
        $usuarios= VboletoP::whereBetween('created_at', [$fecha_inicial,  $fecha_final])->orderBy('users_id','desc')->get();
        $ct=count($usuarios);

        for($d=1;$d<=$ultimo_dia;$d++){
            $registros[$d]=0;
        }

        foreach($usuarios as $usuario){
            $diasel=intval(date("d",strtotime($usuario->created_at) ) );
            $registros[$diasel]++;
        }

        $data=array("totaldias"=>$ultimo_dia, "registrosdia" =>$registros);
        return   json_encode($data);
    }


    public function total_publicaciones(){
        $usuarios=User::where('nombres','!=','root')->where('apellidos','!=','root')->where('type_user','=', '1')->get();
        $count_users = $usuarios->count();
        $ventas_b = VboletoP::all();
        //return $usuarios[0];
        $ct =count($ventas_b);
        
        for($i=0;$i<=$count_users-1;$i++){
         $idTP=$usuarios[$i]->id;
         $numerodepubli[$idTP]=0;
        }

        for($i=0;$i<=$ct-1;$i++){
         $idTP=$ventas_b[$i]->users_id;
         $numerodepubli[$idTP]++;
           
        }

        $data=array("totaltipos"=>$count_users,"tipos"=>$usuarios, "numerodepubli"=>$numerodepubli);
        return json_encode($data);
    }


    public function index()
    {
        $anio=date("Y");
        $mes=date("m");
        return view("listados.listado_graficas")
               ->with("anio",$anio)
               ->with("mes",$mes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
