<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Client;
class GeneradorController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }


    public function create(){
        //$clientes = Clientes::orderBy('nombre_cliente', 'ASC')->get();
        return view('restar.generate');
        //->with('clientes', $clientes);
    }

    public function restar(){
        //$clientes = Clientes::orderBy('nombre_cliente', 'ASC')->get();
        return view('restar.restarpass');
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function update1(Request $request){

        $clientes = User::find($request->email);
        $clientes = User::where('email','=', $request->email)->first();
        $clientes->code   = rand(1000,9999);
        $clientes->save();
    $message = $clientes?'Se ha generado y asigando al correo: '.$request->email.', el codigo:'. $clientes->code.' de forma exitosa.' : 'Error al Generar';

    return redirect()->route('tablero')->with('message', $message);
            }

    public function update2(Request $request)
    {

        $existe_email = User::where('email', '=', $request->email)->get();
        $existe_codigo = User::where('email', '=', $request->email)->get();

        if (count($existe_email) == 1) {
            $clientes = User::find($request->email);
            $clientes = User::where('code', '=', $request->code)->first();
                if (count($existe_codigo) == 1){
            $clientes->password = bcrypt($request->password);
            $clientes->code='';
            $clientes->save();
            $message = $clientes ? 'se ha cambiado tu clave de forma exitosa.' : 'Error al Generar';
            return redirect()->route('/')->with('message', $message);
        }
            $message2 = 'Error al cambiar de clave, el codigo o correo no son correctos! contacta con el administrador del sistema!';

            return redirect()->route('/')->with('message2', $message2);

    }
        $message2 = 'Error al cambiar de clave, el codigo o correo no son correctos! contacta con el administrador del sistema!';

        return redirect()->route('/')->with('message2', $message2);

    }




}
