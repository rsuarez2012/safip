<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Client;
use App\Choferes;
class RegistrarController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }


    public function create(){
        //$clientes = Clientes::orderBy('nombre_cliente', 'ASC')->get();
        return view('registrar');
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $existe_email = User::where('email', '=', $request->email)->get();

        if (count($existe_email) == 0) {

            /* $clientes = new Clientes();
             $clientes->nombre_cliente        = $request->nombre_cliente;
             $clientes->cedula_cliente        = $request->cedula_cliente;
             $clientes->email_cliente         = $request->email_cliente;
             $clientes->pais             	 = $request->pais;
             $clientes->ciudad           	 = $request->ciudad;
             $clientes->tlf_cliente           = $request->tlf_cliente;
             $clientes->save();*/


            $user = new User();
            $user->role_id = $request->usuario;
            $user->apellidos = $request->apellidos;
            $user->nombres   = $request->nombres;
            $user->email     = $request->email;
            $user->active    = "0";
            $user->password  = bcrypt($request->password);
            $user->save();

            $user2 = User::where('email','=', $request->email)->first();

            if ($request->usuario == 3){
                $clientes= new Client();
                $clientes->user_id = $user2->id;
                $clientes->save();
            }

            if ($request->usuario == 4){
                $choferes= new Choferes();
                $choferes->user_id = $user2->id;
                $choferes->save();
            }


            //return view('welcome');
            $message = $user?'Se ha registrado el usuario:'. $request->nombres .' '. $request->apellidos .'de forma exitosa.' : 'Error al Registrar';

            //Session::flash('message', 'Te has registrado exitosamente ');
            return redirect()->route('/')->with('message', $message);


        } else {

            $message2 = 'Este email ya se encuentra registrado';
            return redirect()->route('/')->with('message2', $message2);

        }
    }




}
