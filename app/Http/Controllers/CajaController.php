<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Caja;
use App\Role;
use App\Otros_gastos;
use App\Sucursal;
use App\VboletoP;
use Auth;

class CajaController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function getManageCaja(Request $data = null){
        $anio = date("Y");
        $mes = date("m");
        if ($data->anio == null) {
            $boletos = VboletoP::where('tipo_pago',1)->whereMonth('created_at', $mes)->whereYear('created_at', $anio)->orderBy("id","DESC")->get();
            $gastos = Otros_gastos::all();
        }else{
            $boletos = VboletoP::where('tipo_pago',1)->whereMonth('created_at', $data->mes)->whereYear('created_at', $data->anio)->orderBy("id","DESC")->get();
            $gastos = Otros_gastos::whereMonth('fecha',  $data->mes)->whereYear('fecha',  $data->anio)->get();
            $anio = $data->anio;
            $mes = $data->mes;
        }
        $cajas = Caja::all();
        $sucursal= Sucursal::all();
        $total=round($boletos->sum("tarifa_fee") - $gastos->sum("monto"),2);
       /*  dd($mes); */
        return view('cajas.index',compact('gastos','saldo','opcion','total',"anio","mes","sucursal","boletos"));
    }

    public function create(){
        return view('cajas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $existe_caja = Caja::all();
        if(count($existe_caja)== 0){
                $cajas = new Caja();
                $cajas->monto          = $request->monto;
                $cajas->descripcion    = $request->descripcion;
                $cajas->users_id        = Auth::User()->id;
                $cajas->save();
                //return view('welcome');
                $message = $cajas ? 'Se ha registrado ' . $request->monto .  'de forma exitosa.' : 'Error al Registrar';
                //Session::flash('message', 'Te has registrado exitosamente ');
                return redirect()->route('manageCaja-A')->with('message', $message);
        }else{
            $message2 = 'no puedes crear mas de una Caja Chica';
            //Session::flash('message', 'Te has registrado exitosamente ');
            return redirect()->route('manageCaja-A')->with('message2', $message2);
        }

    }

    public function edit($id){

        $cajas = Caja::where('id','=', $id)->first();
        return view('cajas.edit')->with('cajas', $cajas);
    }

    public function update(Request $request, $id){

        $cajas= Caja::find($id);
        $cajas = Caja::where('id','=', $id)->first();
        $cajas->monto         = $request->monto;
        $cajas->descripcion   = $request->descripcion;
        $cajas->save();
        $message = $cajas?'Se ha actualizado el registro '. $request->monto .' de forma exitosa.' : 'Error al actualizar';
            return redirect()->route('manageCaja-A')->with('message', $message);


    }

    public function status(Request $request, $id){

        $cajas = Caja::where('id','=', $id)->first();
        if ($cajas->status == '0'){
            $cajas= Caja::find($id);
            $cajas = Caja::where('id','=', $id)->first();
            $cajas->status   = "1";
            $cajas->save();
            $message = $cajas?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';
            return redirect()->route('manageCaja-A')->with('message', $message);
        }else{
            if ($cajas->status == '1')
                $cajas = Caja::find($id);
            $cajas = Caja::where('id', '=', $id)->first();
            $cajas->status = "0";
            $cajas->save();
            $message = $cajas ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';
            return redirect()->route('manageCaja-A')->with('message', $message);
        }
    }


    public function show($id){
        $cajas = Caja::all()->lists('name', 'id');
        return view('cajas.show');
    }


    public function destroy($id){
        $cajas = Caja::find($id);
        $cajas->delete($id);
        $message = $cajas?'Registro eliminado correctamente' : 'Error al Eliminar';
            return redirect()->route('manageCaja-A')->with('message', $message);
    }
    public function retiro($id){
        $cajas = Caja::find($id);
        $sucursal = Sucursal::all();
        return view('cajas.retiro')->with('caja',$cajas)->with('opcion',$sucursal);
    }
    public function retiro_save (Request $data){
        /* $aux=Caja::find($data->id);
        $aux->monto=$data->monto;
        $aux->save(); */
        $message = "Se retiro la cantidad de ".$data->retiro."soles de la caja";
        //-------------------------guardar gastos-------------------------------------
        $gasto= new Otros_gastos();
        $gasto->tipo=$data->texto;
        $gasto->monto=$data->retiro;
        $gasto->fecha=$data->fecha;
        $gasto->sucursal=$data->sucursal;
        $gasto->impuesto=$data->impuesto;
        $gasto->save();
        return redirect()->route('manageCaja-A')->with('message',$message);
    }
    public function fechas(Request $data){
        $this->getManageCaja($data->anio,$data->mes);
        /* $gastos = Otros_gastos::whereMonth('fecha', '=', $data->mes)->whereYear('fecha', '=', $data->anio)->get();
        $cajas = Caja::all();
        $sucursal= Sucursal::all();
        return view('cajas.index')->with('gastos',$gastos)->with('saldo',$cajas)->with('opcion',$sucursal); */
    }
    //cosas que se perdieron
    public function eliminarMonto(Otros_gastos $gasto){
        $gasto->delete();
        $message = "Gasto Eliminado con exito!!!";
        return redirect()->route('manageCaja-A')->with('message',$message);

    }
}
