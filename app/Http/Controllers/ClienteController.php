<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Cliente;
use App\Empresa;
use App\Role;
use Auth;
class ClienteController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function buscar(Request $request)
    {
        $clientes= Cliente::where('nombre','like','%'.$request->dato.'%')
            ->orWhere('apellido','like', '%'.$request->dato.'%')
            ->orWhere('email','like', '%'.$request->dato.'%')
            ->orWhere('telefono','like', '%'.$request->dato.'%')->orderBy('created_at', 'desc')->paginate(10);
        return view('clientes.index')
            ->with("clientes",  $clientes);
    }

    public function getManageCliente(){

        $clientes = Cliente::orderBy('created_at', 'desc')->paginate(10);
        $cliente = Cliente::with('empresas')->get();

        return view('clientes.index')->with('clientes',$clientes)->with('cliente',$cliente);
    }

    public function create(){
        $empresas = Empresa::all();

        return view('clientes.create',  compact('empresas'), compact('sucursales'));
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $existe_rif = Cliente::where('cedula_rif', '=', $request->rif)->get();

        if (count($existe_rif) == 0) {

                $clientes = new Cliente();
                $clientes->empresas_id  = $request->empresa;
                $clientes->nombre       = $request->nombre;
                $clientes->apellido     = $request->apellido;
                $clientes->cedula_rif   = $request->cedula_rif;
                $clientes->direccion    = $request->direccion;
                $clientes->telefono     = $request->telefono;
                $clientes->email        = $request->email;
                $clientes->direccion    = $request->direccion;
                $clientes->tipo_pasajero = $request->tipopasajero;
                $clientes->users_id   = Auth::User()->id;
                $clientes->save();

                //return view('welcome');
                $message = $clientes ? 'Se ha registrado ' . $request->nombre .  'de forma exitosa.' : 'Error al Registrar';

                //Session::flash('message', 'Te has registrado exitosamente ');
                return redirect()->route('manageCliente-A')->with('message', $message);


        } else {

            $message2 = 'Esta Cliente ya se encuentra registrada';
            return redirect()->route('manageCliente-A')->with('message2', $message2);

        }
    }

    public function edit($id){

        $clientes = Cliente::where('id','=', $id)->first();
        $empresas = Empresa::all();
        return view('clientes.edit')->with('clientes', $clientes)->with('empresas', $empresas);
    }

    public function update(Request $request, Cliente $cliente){
        //dd($request->all());
        $cliente->empresas_id      = $request->empresa;
        $cliente->tipo_documento   = $request->tipo_documento;
        $cliente->cedula_rif       = $request->cedula_rif;
        $cliente->nombre           = $request->nombre;
        $cliente->apellido         = $request->apellido;
        $cliente->direccion        = $request->direccion;
        $cliente->telefono         = $request->telefono;
        $cliente->email            = $request->email;
        $cliente->tipo_pasajero    = $request->tipopasajero;
        $cliente->update();

        $message = $cliente?'Se ha actualizado el cliente: '. $cliente->nombre . ' '.$cliente->apellido.' de forma exitosa.' : 'Error al actualizar';

        return redirect()->route('manageCliente-A')->with('message', $message);
    }

    public function status(Request $request, $id){

        $clientes = User::where('id','=', $id)->first();
        if ($clientes->active == '0'){
            $clientes= Cliente::find($id);
            $clientes = User::where('id','=', $id)->first();
            $clientes->active   = "1";
            $clientes->save();
            $message = $clientes?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageCliente-A')->with('message', $message);
        }else {
            if ($clientes->active == '1')
                $clientes = User::find($id);
            $clientes = User::where('id', '=', $id)->first();
            $clientes->active = "0";
            $clientes->save();
            $message = $clientes ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageCliente-A')->with('message', $message);
        }
    }



    public function show($id){
        $clientes = Cliente::all()->lists('name', 'id');

        return view('clientes.show');

    }


    public function destroy($id){

        $clientes = Cliente::find($id);
        $clientes->delete($id);
        $message = $clientes?'Registro eliminado correctamente' : 'Error al Eliminar';

            return redirect()->route('manageCliente-A')->with('message', $message);

    }
}
