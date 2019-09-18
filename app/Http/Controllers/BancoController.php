<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Banco;
use App\Role;
use Auth;
class BancoController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function getManageBanco(){

        $bancos = Banco::all();

        return view('bancos.index')->with('bancos',$bancos);

    }

    public function create(){

        return view('bancos.create');
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

                $bancos = new Banco();
                $bancos->banco         = $request->banco;
                $bancos->nrocuenta     = $request->nrocuenta;
                $bancos->monto         = $request->monto;
                $bancos->users_id      = Auth::User()->id;
                $bancos->save();

                //return view('welcome');
                $message = $bancos ? 'Se ha registrado ' . $request->tipo .  'de forma exitosa.' : 'Error al Registrar';

                //Session::flash('message', 'Te has registrado exitosamente ');
                return redirect()->route('manageBanco-A')->with('message', $message);

    }

    public function edit($id){

        $bancos = Banco::where('id','=', $id)->first();
        return view('bancos.edit')->with('bancos', $bancos);
    }

    public function update(Request $request, $id){

        $bancos= Banco::find($id);
        $bancos = Banco::where('id','=', $id)->first();
        $bancos->banco         = $request->banco;
        $bancos->nrocuenta     = $request->nrocuenta;
        $bancos->monto         = $request->monto;
        $bancos->save();

        $message = $bancos?'Se ha actualizado el registro '. $request->tipo .' de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageBanco-A')->with('message', $message);


    }

    public function status(Request $request, $id){

        $bancos = Banco::where('id','=', $id)->first();
        if ($bancos->status == '0'){
            $bancos= Banco::find($id);
            $bancos = Banco::where('id','=', $id)->first();
            $bancos->status   = "1";
            $bancos->save();
            $message = $bancos?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageBanco-A')->with('message', $message);
        }else {
            if ($bancos->status == '1')
                $bancos = Banco::find($id);
            $bancos = Banco::where('id', '=', $id)->first();
            $bancos->status = "0";
            $bancos->save();
            $message = $bancos ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageBanco-A')->with('message', $message);
        }
    }


    public function show($id){
        $bancos = Banco::all()->lists('name', 'id');

        return view('bancos.show');

    }


    public function destroy($id){

        $bancos = Banco::find($id);
        $bancos->delete($id);
        $message = $bancos?'Registro eliminado correctamente' : 'Error al Eliminar';

            return redirect()->route('manageBanco-A')->with('message', $message);

    }
}
