<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Incentivo;
use App\Empresa;
use App\Sucursal;
use App\Role;
use Auth;
class IncentivoController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function getManageIncentivo(){

        $incentivos = Incentivo::all();

        return view('incentivos.index')->with('incentivos',$incentivos);

    }

    public function create(){

        return view('incentivos.create');
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){




                $incentivos = new Incentivo();
                $incentivos->primera_meta  = $request->primera_meta;
                $incentivos->primer_incentivo  = $request->primer_incentivo;
                $incentivos->segunda_meta       = $request->segunda_meta;
                $incentivos->segundo_incentivo     = $request->segundo_incentivo;
                $incentivos->users_id   = Auth::User()->ids;
                $incentivos->save();

                //return view('welcome');
                $message = $incentivos ? 'Se ha registrado ' . $request->nombre .  'de forma exitosa.' : 'Error al Registrar';

                //Session::flash('message', 'Te has registrado exitosamente ');
                return redirect()->route('manageIncentivo-A')->with('message', $message);



    }

    public function edit($id){

        $incentivos = Incentivo::where('id','=', $id)->first();

        return view('incentivos.edit')->with('incentivos', $incentivos);
    }

    public function update(Request $request, $id){

        $incentivos= Incentivo::find($id);
        $incentivos = Incentivo::where('id','=', $id)->first();
        $incentivos->primera_meta  = $request->primera_meta;
        $incentivos->primer_incentivo  = $request->primer_incentivo;
        $incentivos->segunda_meta       = $request->segunda_meta;
        $incentivos->segundo_incentivo     = $request->segundo_incentivo;
        $incentivos->users_id   = Auth::User()->id;
        $incentivos->save();

        $message = $incentivos?'Se ha actualizado el registro '. $request->nombre .' de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageIncentivo-A')->with('message', $message);


    }

    public function status(Request $request, $id){

        $incentivos = User::where('id','=', $id)->first();
        if ($incentivos->active == '0'){
            $incentivos= Incentivo::find($id);
            $incentivos = User::where('id','=', $id)->first();
            $incentivos->active   = "1";
            $incentivos->save();
            $message = $incentivos?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageIncentivo-A')->with('message', $message);
        }else {
            if ($incentivos->active == '1')
                $incentivos = User::find($id);
            $incentivos = User::where('id', '=', $id)->first();
            $incentivos->active = "0";
            $incentivos->save();
            $message = $incentivos ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageIncentivo-A')->with('message', $message);
        }
    }



    public function show($id){
        $incentivos = Incentivo::all()->lists('name', 'id');

        return view('incentivos.show');

    }


    public function destroy($id){

        $incentivos = Incentivo::find($id);
        $incentivos->delete($id);
        $message = $incentivos?'Registro eliminado correctamente' : 'Error al Eliminar';

            return redirect()->route('manageIncentivo-A')->with('message', $message);

    }
}
