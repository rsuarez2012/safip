<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Agente;
use App\Aviaje;
use App\Empresa;
use App\Sucursal;
use App\Role;
use App\Consolidador;
use App\Tpago;
use App\Banco;
use App\Bancog;
use App\Cobro;
use App\DCobro;
use Auth;
class CobroController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function getManageCobro(){

        $agentes = Agente::all();
        $empresas = Agente::with('empresas')->get();
        $sucursales = Agente::with('sucursales')->get();
        $consolidadores = Consolidador::all();
        $tpagos= TPago::all();
        $bancos = Banco::all();
        $bancosg = Bancog::all();
        $aviajes = Aviaje::all();


        return view('cobros.create')
            ->with('aviajes',$aviajes)
            ->with('agentes',$agentes)
            ->with('sucursales',$sucursales)
            ->with('empresas',$empresas)
            ->with('consolidadores',$consolidadores)
            ->with('tpagos',$tpagos)
            ->with('bancos',$bancos)->with('bancosg',$bancosg);

    }

    public function principal(){
        $cobros = Cobro::orderBy('status', 'asc')->paginate(5);
        $agentes = Agente::all();
        $empresas = Agente::with('empresas')->get();
        $sucursales = Agente::with('sucursales')->get();
        $consolidadores = Consolidador::all();
        $tpagos= TPago::all();
        $bancos = Banco::all();
        $bancosg = Bancog::all();
        $cobrosc = Cobro::count();
        $cobrost = Cobro::where('status', '=', 0)->count();


        return view('cobros.index',  compact('cobrost','cobrosc','cobros','agentes','empresas','sucursales','consolidadores','tpagos','bancos','bancosg'));
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        $cobros= new Cobro();
        $cobros->dni_ruc = $request->userid;
        $cobros->cliente_id = $request->nombre;
        $cobros->fecha = $request->fecha;
        $cobros->monto = $request->monto;
        $cobros->dias = $request->dias;
        $cobros->users_id = Auth::User()->id;
        if($request->resta != 0){
            $cobros->status = 0;
        }else{
            $cobros->status = 1;
        }
        $cobros->save();

        for($i=0; $i<sizeof($request->abono); $i++) {
            $dcobros = new DCobro();
            $dcobros->dni_ruc = $request->userid;
            $dcobros->abono = $request->abono[$i];
            $dcobros->tipo_pago = $request->tipo_pago[$i];
            $dcobros->banco_emisor = $request->banco_emisor[$i];
            $dcobros->banco_receptor = $request->banco_receptor[$i];
            $dcobros->nro_operacion = $request->nro_operacion[$i];
            $dcobros->save();
        }

        //return view('welcome');
        $message = $cobros && $dcobros ? 'Se ha registrado ' . $request->nombre .  'de forma exitosa.' : 'Error al Registrar';

        //Session::flash('message', 'Te has registrado exitosamente ');
        return redirect()->route('manageCobro-principal-A')->with('message', $message);

       /* dd($request->all());*/

    }

    public function storeb(Request $request){

       $cobros = Cobro::where('dni_ruc','=', $request->userid)->first();

        if($request->restaenv == 0){
            $cobros->status = 1;
        }else{
            $cobros->status = 0;
        }
        $cobros->save();

        $ecobros = DCobro::where('dni_ruc','=', $request->userid);
        $ecobros->delete($request->dni_ruc);

        for($i=0; $i<sizeof($request->abono); $i++) {
            $dcobros = new DCobro();
            $dcobros->dni_ruc = $request->userid;
            $dcobros->abono = $request->abono[$i];
            $dcobros->tipo_pago = $request->tipop[$i];
            $dcobros->banco_emisor = $request->bancoe[$i];
            $dcobros->banco_receptor = $request->bancor[$i];
            $dcobros->nro_operacion = $request->dosnroperacion[$i];
            $dcobros->save();
        }

        $message = $cobros && $dcobros ? 'Se ha registrado el Cobro ' . $request->userid.  'de forma exitosa.' : 'Error al Registrar';

        //Session::flash('message', 'Te has registrado exitosamente ');
        return redirect()->route('manageCobro-principal-A')->with('message', $message);


        /*dd($request->all());*/

    }

    public function edit($id){

        $agentes = Agente::where('id','=', $id)->first();
        $empresas = Empresa::all();
        return view('agentes.edit')->with('agentes', $agentes)->with('empresas', $empresas);
    }

    public function update(Request $request, $id){

        $agentes= Agente::find($id);
        $agentes = Agente::where('id','=', $id)->first();
        $agentes->empresas_id  = $request->empresa;
        $agentes->sucursales_id  = $request->sucursal;
        $agentes->nombre       = $request->nombre;
        $agentes->apellido     = $request->apellido;
        $agentes->cedula_rif   = $request->cedula_rif;
        $agentes->direccion    = $request->direccion;
        $agentes->telefono     = $request->telefono;
        $agentes->email        = $request->email;
        $agentes->cargo        = $request->cargo;
        $agentes->users_id   = Auth::User()->id;
        $agentes->save();

        $message = $agentes?'Se ha actualizado el registro '. $request->nombre .' de forma exitosa.' : 'Error al actualizar';

        return redirect()->route('manageAgente-A')->with('message', $message);


    }

    public function status(Request $request, $id){

        $agentes = User::where('id','=', $id)->first();
        if ($agentes->active == '0'){
            $agentes= Agente::find($id);
            $agentes = User::where('id','=', $id)->first();
            $agentes->active   = "1";
            $agentes->save();
            $message = $agentes?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageAgente-A')->with('message', $message);
        }else {
            if ($agentes->active == '1')
                $agentes = User::find($id);
            $agentes = User::where('id', '=', $id)->first();
            $agentes->active = "0";
            $agentes->save();
            $message = $agentes ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageAgente-A')->with('message', $message);
        }
    }



    public function show($id){
        $agentes = Agente::all()->lists('name', 'id');

        return view('agentes.show');

    }


    public function destroy($id){

        $agentes = Agente::find($id);
        $agentes->delete($id);
        $message = $agentes?'Registro eliminado correctamente' : 'Error al Eliminar';

        return redirect()->route('manageAgente-A')->with('message', $message);

    }
}
