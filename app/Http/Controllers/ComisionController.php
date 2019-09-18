<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Role;
use App\Laerea;
use App\Comision;
use App\Consolidador;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;

class ComisionController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function getManageComision(){

        $comisiones = Comision::all();
        $consolidadores = Consolidador::all();
        $laereas = Laerea::all();
        return view('comisiones.index', compact('comisiones', 'consolidadores', 'laereas'));
        /*dd($comisiones);*/
    }

    public function create(){
        $consolidadores = Consolidador::all();
        $laereas = Laerea::all();

        return view('comisiones.create',  compact('consolidadores'), compact('laereas'));
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //dd($request->all());
       // $oo = $request->only_operator;
        $la = null;
        if($request->only_operator === "0"){
            $la = $request->laerea_id;
        }
        $this->validate($request, [
            'consolidador_id'  => 'required|int',
            'comision'          => 'required|int',
        ], [
            'consolidador_id.required'    => 'Error. Este campo es requerido',
            'consolidador_id.int'         => 'El valor debe ser numerico',
            'comision.required'             => 'Error. Este campo es requerido',
            'comision.int'                  => 'El valor debe ser numerico'
        ]);
        $comi_exist = Comision::where('consolidadores_id', $request->consolidador_id)->where('only_operator', '1')->count();
        if($comi_exist > 0){
            return back()->with('error', 'El consolidador seleccionado ya tiene una comision asignada cuando no posee linea aerea.');
        }
        //dd($request->all(), $la, $comi_exist);
        $c = Comision::make([
            'consolidadores_id'     => $request->consolidador_id,
            'laereas_id'            => $la,
            'comision'              => $request->comision,
            'only_operator'         => $request->only_operator,
            'user_id'               => Auth::id(),
        ]);
        dd($request->all(), $la, $comi_exist);
        
        //Session::flash('message', 'Te has registrado exitosamente ');
        return redirect()->route('manageComision-A')->with('message', 'Se ha registrado la comision de forma exitosa!.');
    }

    public function edit($id){

        $comisiones = Comision::where('id','=', $id)->first();

        return view('comisiones.edit')->with('comisiones', $comisiones);
    }

    public function update(Request $request, $id){

        $comisiones= Comision::find($id);
        $comisiones = Comision::where('id','=', $id)->first();
        $comisiones->consolidadores_id  = $request->consolidador_id;
        $comisiones->laereas_id  = $request->laerea_id;
        $comisiones->comision       = $request->comision;
        $comisiones->users_id   = Auth::User()->id;
        $comisiones->save();

        $message = $comisiones?'Se ha actualizado el registro '. $request->nombre .' de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageComision-A')->with('message', $message);


    }

    public function status(Request $request, $id){

        $comisiones = User::where('id','=', $id)->first();
        if ($comisiones->active == '0'){
            $comisiones= Comision::find($id);
            $comisiones = User::where('id','=', $id)->first();
            $comisiones->active   = "1";
            $comisiones->save();
            $message = $comisiones?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageComision-A')->with('message', $message);
        }else {
            if ($comisiones->active == '1')
                $comisiones = User::find($id);
            $comisiones = User::where('id', '=', $id)->first();
            $comisiones->active = "0";
            $comisiones->save();
            $message = $comisiones ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageComision-A')->with('message', $message);
        }
    }



    public function show($id){
        $comisiones = Comision::all()->lists('name', 'id');

        return view('comisiones.show');

    }


    public function destroy($id){

        $comisiones = Comision::find($id);
        $comisiones->delete($id);
        $message = $comisiones?'Registro eliminado correctamente' : 'Error al Eliminar';

            return redirect()->route('manageComision-A')->with('message', $message);

    }
}
