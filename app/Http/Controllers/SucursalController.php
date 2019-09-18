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
class SucursalController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function getManageAgente(){

        $sucursales = Agente::all();
        $agente = Agente::with('empresas')->get();
        $agente = Agente::with('sucursales')->get();


        return view('sucursales.index')->with('sucursales',$sucursales)->with('agente',$agente);

    }

    public function create(){
        $empresas = Empresa::all();
        $sucursales = Sucursal::all();

        return view('sucursales.create',  compact('empresas'), compact('sucursales'));
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $existe_rif = Sucursal::where('rif', '=', $request->rif)->get();

        if (count($existe_rif) == 0) {

                $sucursales = new Sucursal();
                $sucursales->empresas_id  = $request->empresa;
                $sucursales->rif            = $request->rif;
                $sucursales->nombre       = $request->nombre;
                $sucursales->direccion  = $request->direccion;
                $sucursales->users_id   = Auth::User()->id;
                $sucursales->save();

                //return view('welcome');
                $message = $sucursales ? 'Se ha registrado la sucursal de forma exitosa.' : 'Error al Registrar';

                //Session::flash('message', 'Te has registrado exitosamente ');
                return redirect()->route('manageEmpresa-A')->with('message', $message);


        } else {

            $message2 = 'Esta sucursal ya se encuentra registrada';
            return redirect()->route('manageEmpresa-A')->with('message2', $message2);

        }
    }

    public function edit($id){

        $sucursales = Sucursal::where('id','=', $id)->first();
        return view('sucursales.edit')->with('sucursales', $sucursales);
    }

    public function update(Request $request, $id){

        $sucursales= Sucursal::find($id);
        $sucursales = Sucursal::where('id','=', $id)->first();
        $sucursales->empresas_id  = $request->empresa;
        $sucursales->nombre       = $request->nombre;
        $sucursales->rif          = $request->rif;
        $sucursales->direccion    = $request->direccion;
        $sucursales->users_id   = Auth::User()->id;
        $sucursales->save();

        $message = $sucursales?'Se ha actualizado el registro '. $request->nombre .' de forma exitosa.' : 'Error al actualizar';

            return redirect('tablero/empresas/admin/show/'. $request->empresa)->with('message', $message);


    }

    public function status(Request $request, $id){

        $sucursales = User::where('id','=', $id)->first();
        if ($sucursales->active == '0'){
            $sucursales= Agente::find($id);
            $sucursales = User::where('id','=', $id)->first();
            $sucursales->active   = "1";
            $sucursales->save();
            $message = $sucursales?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageAgente-A')->with('message', $message);
        }else {
            if ($sucursales->active == '1')
                $sucursales = User::find($id);
            $sucursales = User::where('id', '=', $id)->first();
            $sucursales->active = "0";
            $sucursales->save();
            $message = $sucursales ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageAgente-A')->with('message', $message);
        }
    }



    public function show($id){
        $sucursales = Agente::all()->lists('name', 'id');

        return view('sucursales.show');

    }


    public function destroy($id){

        $sucursales = Sucursal::find($id);
        $sucursales->delete($id);
        $message = $sucursales?'Registro eliminado correctamente' : 'Error al Eliminar';

        return back()->with('message', $message);

    }
}
