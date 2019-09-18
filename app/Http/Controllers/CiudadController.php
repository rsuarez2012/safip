<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Pais;
use App\Ciudad;
use App\Role;
use Auth;
class CiudadController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function getManageCiudad(){

        $ciudades = Ciudad::all();
        $paiscodigo = Pais::all();

        return view('ciudades.index')->with('ciudades',$ciudades);

    }

    public function create(){
        $paiscodigo = Pais::all();


        return view('ciudades.create')->with('paiscodigo',$paiscodigo);
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $existe_ciudad = Ciudad::where('ciudadnombre', '=', $request->ciudadnombre)->get();

        if (count($existe_ciudad) == 0) {

                $ciudades = new Ciudad();
                $ciudades->ciudadnombre  = $request->ciudadnombre;
                $ciudades->paiscodigo  = $request->paiscodigo;

                $ciudades->users_id   = Auth::User()->id;
                $ciudades->save();

                //return view('welcome');
                $message = $ciudades ? 'Se ha registrado ' . $request->nombre .  'de forma exitosa.' : 'Error al Registrar';

                //Session::flash('message', 'Te has registrado exitosamente ');
                return redirect()->route('manageCiudad-A')->with('message', $message);


        } else {

            $message2 = 'Esta Ciudad ya se encuentra registrada';
            return redirect()->route('manageCiudad-A')->with('message2', $message2);

        }
    }

    public function edit($id){

        $ciudades = Ciudad::where('id','=', $id)->first();
        $paiscodigo = Pais::all();

        return view('ciudades.edit')->with('ciudades', $ciudades)->with('paiscodigo', $paiscodigo);
    }

    public function update(Request $request, $id){

        $ciudades= Ciudad::find($id);
        $ciudades = Ciudad::where('id','=', $id)->first();
        $ciudades->ciudadnombre  = $request->ciudadnombre;
        $ciudades->paiscodigo  = $request->paiscodigo;
        $ciudades->users_id   = Auth::User()->id;
        $ciudades->save();

        $message = $ciudades?'Se ha actualizado el registro '. $request->nombre .' de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageCiudad-A')->with('message', $message);


    }

    public function status(Request $request, $id){

        $ciudades = User::where('id','=', $id)->first();
        if ($ciudades->active == '0'){
            $ciudades= Ciudad::find($id);
            $ciudades = User::where('id','=', $id)->first();
            $ciudades->active   = "1";
            $ciudades->save();
            $message = $ciudades?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageCiudad-A')->with('message', $message);
        }else {
            if ($ciudades->active == '1')
                $ciudades = User::find($id);
            $ciudades = User::where('id', '=', $id)->first();
            $ciudades->active = "0";
            $ciudades->save();
            $message = $ciudades ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageCiudad-A')->with('message', $message);
        }
    }



    public function show($id){
        $ciudades = Ciudad::all()->lists('name', 'id');

        return view('ciudades.show');

    }


    public function destroy($id){

        $ciudades = Ciudad::find($id);
        $ciudades->delete($id);
        $message = $ciudades?'Registro eliminado correctamente' : 'Error al Eliminar';

            return redirect()->route('manageCiudad-A')->with('message', $message);

    }
}
