<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Gasto;
use App\Role;
use Auth;
class GastoController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function getManageGasto(){

        $gastos = Gasto::all();
        $gasto1 = Gasto::with('user')->get();
        return view('gastos.index')->with('gastos',$gastos)->with('gasto1',$gasto1);

    }

    public function create(){

        return view('gastos.create');
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

                $gastos = new Gasto();
                $gastos->tipo_gasto         = $request->tipo;
                $gastos->descripcion         = $request->descripcion;
                $gastos->usuario         = Auth::User()->id;

                $gastos->save();

                //return view('welcome');
                $message = $gastos ? 'Se ha registrado ' . $request->tipo .  'de forma exitosa.' : 'Error al Registrar';

                //Session::flash('message', 'Te has registrado exitosamente ');
                return redirect()->route('manageGasto-A')->with('message', $message);

    }

    public function edit($id){

        $gastos = Gasto::where('id','=', $id)->first();
        return view('gastos.edit')->with('gastos', $gastos);
    }

    public function update(Request $request, $id){

        $gastos= Gasto::find($id);
        $gastos = Gasto::where('id','=', $id)->first();
        $gastos->tipo_gasto         = $request->tipo;
        $gastos->descripcion         = $request->descripcion;
        $gastos->save();

        $message = $gastos?'Se ha actualizado el registro '. $request->tipo .' de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageGasto-A')->with('message', $message);


    }

    public function status(Request $request, $id){

        $gastos = Gasto::where('id','=', $id)->first();
        if ($gastos->status == '0'){
            $gastos= Gasto::find($id);
            $gastos = Gasto::where('id','=', $id)->first();
            $gastos->status   = "1";
            $gastos->save();
            $message = $gastos?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageGasto-A')->with('message', $message);
        }else {
            if ($gastos->status == '1')
                $gastos = Gasto::find($id);
            $gastos = Gasto::where('id', '=', $id)->first();
            $gastos->status = "0";
            $gastos->save();
            $message = $gastos ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageGasto-A')->with('message', $message);
        }
    }


    public function show($id){
        $gastos = Gasto::all()->lists('name', 'id');

        return view('gastos.show');

    }


    public function destroy($id){

        $gastos = Gasto::find($id);
        $gastos->delete($id);
        $message = $gastos?'Registro eliminado correctamente' : 'Error al Eliminar';

            return redirect()->route('manageGasto-A')->with('message', $message);

    }
}
