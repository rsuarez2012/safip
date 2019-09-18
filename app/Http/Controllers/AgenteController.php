<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Agente;
use App\Empresa;
use App\Sucursal;
use App\Role;
use Auth;
class AgenteController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function getManageAgente(){

        $agentes = Agente::all();
        $agentes = Agente::with('empresas')->get();
        $agentes = Agente::with('sucursales')->get();


        return view('agentes.index')->with('agentes',$agentes);

    }

    public function create(){
        $empresas = Empresa::all();
        $sucursales = Sucursal::all();

        return view('agentes.create',  compact('empresas'), compact('sucursales'));
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $existe_rif = Agente::where('cedula_rif', '=', $request->rif)->get();

        if (count($existe_rif) == 0) {

                $agentes = new Agente();
                $agentes->empresas_id  = $request->empresa;
                $agentes->sucursales_id  = $request->sucursal;
                $agentes->nombre       = $request->nombre;
                $agentes->apellido     = $request->apellido;
                $agentes->cedula_rif   = $request->cedula_rif;
                $agentes->direccion    = $request->direccion;
                $agentes->telefono     = $request->telefono;
                $agentes->email        = $request->email;
                $agentes->cargo        = $request->cargo;
                $agentes->users_id   = Auth::User()->id;
                $agentes->save();

                //return view('welcome');
                $message = $agentes ? 'Se ha registrado ' . $request->nombre .  'de forma exitosa.' : 'Error al Registrar';

                //Session::flash('message', 'Te has registrado exitosamente ');
                return redirect()->route('manageAgente-A')->with('message', $message);


        } else {

            $message2 = 'Esta Agente ya se encuentra registrada';
            return redirect()->route('manageAgente-A')->with('message2', $message2);

        }
    }

    public function edit($id){

        $agentes = Agente::where('id','=', $id)->first();
        $empresas = Empresa::all();
        $sucursales = Sucursal::all();
        return view('agentes.edit')->with('agentes', $agentes)->with('empresas', $empresas)->with('sucursales', $sucursales);
    }

    public function update(Request $request, $id){

        $agentes= Agente::find($id);
        $agentes = Agente::where('id','=', $id)->first();
        $agentes->empresas_id  = $request->empresa;
        $agentes->sucursales_id  = $request->sucursal;
        $agentes->nombre       = $request->nombre;
        $agentes->apellido     = $request->apellido;
        $agentes->cedula_rif   = $request->cedula_rif;
        $agentes->direccion    = $request->direccion;
        $agentes->telefono     = $request->telefono;
        $agentes->email        = $request->email;
        $agentes->cargo        = $request->cargo;
        $agentes->users_id   = Auth::User()->id;
        $agentes->save();

        $message = $agentes?'Se ha actualizado el registro '. $request->nombre .' de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageAgente-A')->with('message', $message);


    }

    public function status(Request $request, $id){

        $agentes = User::where('id','=', $id)->first();
        if ($agentes->active == '0'){
            $agentes= Agente::find($id);
            $agentes = User::where('id','=', $id)->first();
            $agentes->active   = "1";
            $agentes->save();
            $message = $agentes?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageAgente-A')->with('message', $message);
        }else {
            if ($agentes->active == '1')
                $agentes = User::find($id);
            $agentes = User::where('id', '=', $id)->first();
            $agentes->active = "0";
            $agentes->save();
            $message = $agentes ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageAgente-A')->with('message', $message);
        }
    }



    public function show($id){
        $agentes = Agente::all()->lists('name', 'id');

        return view('agentes.show');

    }


    public function destroy($id){

        $agentes = Agente::find($id);
        $agentes->delete($id);
        $message = $agentes?'Registro eliminado correctamente' : 'Error al Eliminar';

            return redirect()->route('manageAgente-A')->with('message', $message);

    }
}
