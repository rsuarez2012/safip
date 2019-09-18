<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\Deuda;
use App\User;
use App\Role;
use Auth;
class DeudaController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function getManageDeuda(){

        $deudas = Deuda::all();
        $deuda = Deuda::with('usuarios')->get();
        return view('deudas.index')->with('deudas',$deudas)->with('deuda',$deuda);

    }

    public function create(){

        return view('deudas.create',  compact('roles'));
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

                $deudas = new Deuda();
                $deudas->tipo_deuda         = $request->tipo;
                $deudas->descripcion       = $request->descripcion;
                $deudas->users_id        = Auth::User()->id;
               
                $deudas->save();

                //return view('welcome');
                $message = $deudas ? 'Se ha registrado ' . $request->deuda .  'de forma exitosa.' : 'Error al Registrar';

                //Session::flash('message', 'Te has registrado exitosamente ');
                return redirect()->route('manageDeuda-A')->with('message', $message);

    }

    public function edit($id){

        $deudas = Deuda::where('id','=', $id)->first();
        return view('deudas.edit')->with('deudas', $deudas);
    }

    public function update(Request $request, $id){

        $deudas= Deuda::find($id);
        $deudas = Deuda::where('id','=', $id)->first();
        $deudas->tipo_deuda         = $request->tipo;
        $deudas->descripcion       = $request->descripcion;
        $deudas->save();

        $message = $deudas?'Se ha actualizado el registro '. $request->deuda .' de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageDeuda-A')->with('message', $message);


    }

    public function status(Request $request, $id){

        $deudas = Deuda::where('id','=', $id)->first();
        if ($deudas->status == '0'){
            $deudas= Deuda::find($id);
            $deudas = Deuda::where('id','=', $id)->first();
            $deudas->save();
            $message = $deudas?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageDeuda-A')->with('message', $message);
        }else {
            if ($deudas->status == '1')
                $deudas = Deuda::find($id);
            $deudas = Deuda::where('id', '=', $id)->first();
            $deudas->status = "0";
            $deudas->save();
            $message = $deudas ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageDeuda-A')->with('message', $message);
        }
    }



    public function show($id){
        $deudas = Deuda::all()->lists('name', 'id');

        return view('deudas.show');

    }


    public function destroy($id){

        $deudas = Deuda::find($id);
        $deudas->delete($id);
        $message = $deudas?'Registro eliminado correctamente' : 'Error al Eliminar';

            return redirect()->route('manageDeuda-A')->with('message', $message);

    }
}
