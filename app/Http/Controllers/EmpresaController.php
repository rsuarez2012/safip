<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Empresa;
use App\Sucursal;
use App\Role;
use Auth;
class EmpresaController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function getManageEmpresa(){

        $empresas = Empresa::all();
        return view('empresas.index')->with('empresas',$empresas);

    }

    public function create(){

        return view('empresas.create',  compact('roles'));
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $existe_rif = Empresa::where('rif', '=', $request->rif)->get();

        if (count($existe_rif) == 0) {

                $empresas = new Empresa();
                $empresas->logo         = $request->logo;
                $empresas->nombre       = $request->nombre;
                $empresas->rif          = $request->rif;
                $empresas->direccion    = $request->direccion;
                $empresas->email        = $request->email;
                $empresas->telefono_1   = $request->telefono_1;
                $empresas->telefono_2   = $request->telefono_2;
                $empresas->web          = $request->web;
                $empresas->slogan       = $request->slogan;
                $empresas->save();

                //return view('welcome');
                $message = $empresas ? 'Se ha registrado ' . $request->nombre .  'de forma exitosa.' : 'Error al Registrar';

                //Session::flash('message', 'Te has registrado exitosamente ');
                return redirect()->route('manageEmpresa-A')->with('message', $message);


        } else {

            $message2 = 'Esta empresa ya se encuentra registrada';
            return redirect()->route('manageEmpresa-A')->with('message2', $message2);

        }
    }

    public function edit($id){

        $empresas = Empresa::where('id','=', $id)->first();
        return view('empresas.edit')->with('empresas', $empresas);
    }

    public function update(Request $request, $id){

        $empresas= Empresa::find($id);
        $empresas = Empresa::where('id','=', $id)->first();
        $empresas->logo         = $request->logo;
        $empresas->nombre       = $request->nombre;
        $empresas->rif          = $request->rif;
        $empresas->direccion    = $request->direccion;
        $empresas->email        = $request->email;
        $empresas->telefono_1   = $request->telefono_1;
        $empresas->telefono_2   = $request->telefono_2;
        $empresas->web          = $request->web;
        $empresas->slogan       = $request->slogan;
        $empresas->save();

        $message = $empresas?'Se ha actualizado el registro '. $request->nombre .' de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageEmpresa-A')->with('message', $message);


    }

    public function status(Request $request, $id){

        $empresas = User::where('id','=', $id)->first();
        if ($empresas->active == '0'){
            $empresas= Empresa::find($id);
            $empresas = User::where('id','=', $id)->first();
            $empresas->active   = "1";
            $empresas->save();
            $message = $empresas?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageEmpresa-A')->with('message', $message);
        }else {
            if ($empresas->active == '1')
                $empresas = User::find($id);
            $empresas = User::where('id', '=', $id)->first();
            $empresas->active = "0";
            $empresas->save();
            $message = $empresas ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageEmpresa-A')->with('message', $message);
        }
    }



    public function show($id){
        $empresas = Empresa::where('id',$id)->first();
        $sucursales = Sucursal::where('empresas_id',$id)->get();

        return view('empresas.show', compact('empresas'))->with('sucursales',$sucursales);

    }


    public function destroy($id){

        $empresas = Empresa::find($id);
        $empresas->delete($id);
        $message = $empresas?'Registro eliminado correctamente' : 'Error al Eliminar';

            return redirect()->route('manageEmpresa-A')->with('message', $message);

    }
}
