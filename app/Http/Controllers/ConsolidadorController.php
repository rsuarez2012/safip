<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Consolidador;
use App\Empresa;
use App\Role;
use Auth;
class ConsolidadorController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function getManageConsolidador(){

        $consolidadores = Consolidador::paginate(30);
        $consolidador = Consolidador::with('empresas')->get();


        return view('consolidadores.index')->with('consolidadores',$consolidadores)->with('consolidador',$consolidador);

    }

    public function create(){
        $empresas = Empresa::all();

        return view('consolidadores.create',  compact('empresas'));
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $existe_rif = Consolidador::where('rif', '=', $request->rif)->get();

        if (count($existe_rif) == 0) {

                $consolidadores = new Consolidador();
                $consolidadores->empresas_id  = $request->empresa;
                $consolidadores->nombre       = $request->nombre;
                $consolidadores->rif          = $request->rif;
                $consolidadores->direccion    = $request->direccion;
                $consolidadores->telefono     = $request->telefono;
                $consolidadores->email        = $request->email;
                $consolidadores->web          = $request->web;
                $consolidadores->descripcion  = $request->descripcion;
                $consolidadores->save();

                //return view('welcome');
                $message = $consolidadores ? 'Se ha registrado ' . $request->nombre .  'de forma exitosa.' : 'Error al Registrar';

                //Session::flash('message', 'Te has registrado exitosamente ');
                return redirect()->route('manageConsolidador-A')->with('message', $message);


        } else {

            $message2 = 'Esta Consolidador ya se encuentra registrada';
            return redirect()->route('manageConsolidador-A')->with('message2', $message2);

        }
    }

    public function edit($id){

        $consolidadores = Consolidador::where('id','=', $id)->first();
        $empresas = Empresa::all();
        return view('consolidadores.edit')->with('consolidadores', $consolidadores)->with('empresas', $empresas);
    }

    public function update(Request $request, $id){

        $consolidadores= Consolidador::find($id);
        $consolidadores = Consolidador::where('id','=', $id)->first();
        $consolidadores->empresas_id  = $request->empresa;
        $consolidadores->nombre       = $request->nombre;
        $consolidadores->rif          = $request->rif;
        $consolidadores->direccion    = $request->direccion;
        $consolidadores->telefono     = $request->telefono;
        $consolidadores->email        = $request->email;
        $consolidadores->web          = $request->web;
        $consolidadores->descripcion  = $request->descripcion;
        $consolidadores->save();

        $message = $consolidadores?'Se ha actualizado el registro '. $request->nombre .' de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageConsolidador-A')->with('message', $message);


    }

    public function status(Request $request, $id){

        $consolidadores = User::where('id','=', $id)->first();
        if ($consolidadores->active == '0'){
            $consolidadores= Consolidador::find($id);
            $consolidadores = User::where('id','=', $id)->first();
            $consolidadores->active   = "1";
            $consolidadores->save();
            $message = $consolidadores?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageConsolidador-A')->with('message', $message);
        }else {
            if ($consolidadores->active == '1')
                $consolidadores = User::find($id);
            $consolidadores = User::where('id', '=', $id)->first();
            $consolidadores->active = "0";
            $consolidadores->save();
            $message = $consolidadores ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageConsolidador-A')->with('message', $message);
        }
    }



    public function show($id){
        $consolidadores = Consolidador::all()->lists('name', 'id');

        return view('consolidadores.show');

    }


    public function destroy($id){

        $consolidadores = Consolidador::find($id);
        $consolidadores->delete($id);
        $message = $consolidadores?'Registro eliminado correctamente' : 'Error al Eliminar';

            return redirect()->route('manageConsolidador-A')->with('message', $message);

    }
}
