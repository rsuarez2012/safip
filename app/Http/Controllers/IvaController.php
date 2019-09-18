<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Iva;
use App\Role;
use Auth;
class IvaController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function getManageIva(){

        $ivas = Iva::all();

        return view('ivas.index')->with('ivas',$ivas);

    }

    public function create(){

        return view('ivas.create');
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

                $ivas = new Iva();
                $ivas->iva         = $request->iva;
                $ivas->users_id    = Auth::User()->nombres.' '.Auth::User()->apellidos;

                $ivas->save();

                //return view('welcome');
                $message = $ivas ? 'Se ha registrado ' . $request->tipo .  'de forma exitosa.' : 'Error al Registrar';

                //Session::flash('message', 'Te has registrado exitosamente ');
                return redirect()->route('manageIva-A')->with('message', $message);

    }

    public function edit($id){

        $ivas = Iva::where('id','=', $id)->first();
        return view('ivas.edit')->with('ivas', $ivas);
    }

    public function update(Request $request, $id){

        $ivas= Iva::find($id);
        $ivas = Iva::where('id','=', $id)->first();
        $ivas->iva         = $request->iva;
        $ivas->users_id    = Auth::User()->id;
        $ivas->save();

        $message = $ivas?'Se ha actualizado el registro '. $request->tipo .' de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageIva-A')->with('message', $message);


    }

    public function status(Request $request, $id){

        $ivas = Iva::where('id','=', $id)->first();
        if ($ivas->status == '0'){
            $ivas= Iva::find($id);
            $ivas = Iva::where('id','=', $id)->first();
            $ivas->status   = "1";
            $ivas->save();
            $message = $ivas?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageIva-A')->with('message', $message);
        }else {
            if ($ivas->status == '1')
                $ivas = Iva::find($id);
            $ivas = Iva::where('id', '=', $id)->first();
            $ivas->status = "0";
            $ivas->save();
            $message = $ivas ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageIva-A')->with('message', $message);
        }
    }


    public function show($id){
        $ivas = Iva::all()->lists('name', 'id');

        return view('ivas.show');

    }


    public function destroy($id){

        $ivas = Iva::find($id);
        $ivas->delete($id);
        $message = $ivas?'Registro eliminado correctamente' : 'Error al Eliminar';

            return redirect()->route('manageIva-A')->with('message', $message);

    }
}
