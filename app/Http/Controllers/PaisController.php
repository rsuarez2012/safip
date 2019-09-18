<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Pais;
use App\Role;
use Auth;
class PaisController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function getManagePais(){

        $paises = Pais::all();

        return view('paises.index')->with('paises',$paises);

    }

    public function create(){


        return view('paises.create');
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $existe_pais = Pais::where('paisnombre', '=', $request->paisnombre)->get();

        if (count($existe_pais) == 0) {

                $paises = new Pais();
                 $paises->PaisCodigo  = $request->PaisCodigo;
                $paises->paisnombre  = $request->paisnombre;
                $paises->users_id   = Auth::User()->id;
                $paises->save();

                //return view('welcome');
                $message = $paises ? 'Se ha registrado ' . $request->nombre .  'de forma exitosa.' : 'Error al Registrar';

                //Session::flash('message', 'Te has registrado exitosamente ');
                return redirect()->route('managePais-A')->with('message', $message);
        } else {

            $message2 = 'Esta Pais ya se encuentra registrada';
            return redirect()->route('managePais-A')->with('message2', $message2);

        }
    }

    public function edit($id){

        $paises = Pais::where('id','=', $id)->first();

        return view('paises.edit')->with('paises', $paises);
    }

    public function update(Request $request, $id){

        $paises= Pais::find($id);
        $paises = Pais::where('id','=', $id)->first();
        $paises->PaisCodigo  = $request->PaisCodigo;
        $paises->paisnombre  = $request->paisnombre;
        $paises->users_id   = Auth::User()->id;
        $paises->save();

        $message = $paises?'Se ha actualizado el registro '. $request->nombre .' de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('managePais-A')->with('message', $message);


    }

    public function status(Request $request, $id){

        $paises = User::where('id','=', $id)->first();
        if ($paises->active == '0'){
            $paises= Pais::find($id);
            $paises = User::where('id','=', $id)->first();
            $paises->active   = "1";
            $paises->save();
            $message = $paises?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('managePais-A')->with('message', $message);
        }else {
            if ($paises->active == '1')
                $paises = User::find($id);
            $paises = User::where('id', '=', $id)->first();
            $paises->active = "0";
            $paises->save();
            $message = $paises ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('managePais-A')->with('message', $message);
        }
    }



    public function show($id){
        $paises = Pais::all()->lists('name', 'id');

        return view('paises.show');

    }


    public function destroy($id){

        $paises = Pais::find($id);
        $paises->delete($id);
        $message = $paises?'Registro eliminado correctamente' : 'Error al Eliminar';

            return redirect()->route('managePais-A')->with('message', $message);

    }
}
