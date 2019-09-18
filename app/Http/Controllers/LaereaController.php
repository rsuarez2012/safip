<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Laerea;
use App\Empresa;
use App\Role;
use Auth;
class LaereaController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function getManageLaerea(){

        $aereas = Laerea::all();
        $aerea = Laerea::with('empresas')->get();


        return view('laereas.index')->with('aereas',$aereas)->with('aerea',$aerea);

    }

    public function create(){
        $empresas = Empresa::all();

        return view('laereas.create',  compact('empresas'));
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $existe_rif = Laerea::where('rif', '=', $request->rif)->get();

        if (count($existe_rif) == 0) {

                $aereas = new Laerea();
                $aereas->empresas_id  = $request->empresa;
                $aereas->nombre       = $request->nombre;
                $aereas->rif          = $request->rif;
                $aereas->direccion    = $request->direccion;
                $aereas->telefono     = $request->telefono;
                $aereas->email        = $request->email;
                $aereas->web          = $request->web;
                $aereas->descripcion  = $request->descripcion;
                $aereas->users_id   = Auth::User()->id;
                $aereas->save();

                //return view('welcome');
                $message = $aereas ? 'Se ha registrado ' . $request->nombre .  'de forma exitosa.' : 'Error al Registrar';

                //Session::flash('message', 'Te has registrado exitosamente ');
                return redirect()->route('manageLaerea-A')->with('message', $message);


        } else {

            $message2 = 'Esta Linea Aerea ya se encuentra registrada';
            return redirect()->route('manageLaerea-A')->with('message2', $message2);

        }
    }

    public function edit($id){

        $aereas = Laerea::where('id','=', $id)->first();
        $empresas = Empresa::all();
        return view('laereas.edit')->with('aereas', $aereas)->with('empresas', $empresas);
    }

    public function update(Request $request, $id){

        $aereas= Laerea::find($id);
        $aereas = Laerea::where('id','=', $id)->first();
        $aereas->empresas_id  = $request->empresa;
        $aereas->nombre       = $request->nombre;
        $aereas->rif          = $request->rif;
        $aereas->direccion    = $request->direccion;
        $aereas->telefono     = $request->telefono;
        $aereas->email        = $request->email;
        $aereas->web          = $request->web;
        $aereas->descripcion  = $request->descripcion;
        $aereas->updated_by   = Auth::User()->id;
        $aereas->save();

        $message = $aereas?'Se ha actualizado el registro '. $request->nombre .' de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageLaerea-A')->with('message', $message);


    }

    public function status(Request $request, $id){

        $aereas = User::where('id','=', $id)->first();
        if ($aereas->active == '0'){
            $aereas= Laerea::find($id);
            $aereas = User::where('id','=', $id)->first();
            $aereas->active   = "1";
            $aereas->save();
            $message = $aereas?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageLaerea-A')->with('message', $message);
        }else {
            if ($aereas->active == '1')
                $aereas = User::find($id);
            $aereas = User::where('id', '=', $id)->first();
            $aereas->active = "0";
            $aereas->save();
            $message = $aereas ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageLaerea-A')->with('message', $message);
        }
    }



    public function show($id){
        $aereas = Laerea::all()->lists('name', 'id');

        return view('aereas.show');

    }


    public function destroy($id){

        $aereas = Laerea::find($id);
        $aereas->delete($id);
        $message = $aereas?'Registro eliminado correctamente' : 'Error al Eliminar';

            return redirect()->route('manageLaerea-A')->with('message', $message);

    }
}
