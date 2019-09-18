<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Agente;
use App\Empresa;
use App\Sucursal;
use App\Role;
use App\Consolidador;
use App\Tpago;
use App\Banco;
use App\Bancog;
use App\Pago;
use App\DPago;
use Auth;
class PagoController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function getManagePago(){

        $agentes = Agente::all();
        $empresas = Agente::with('empresas')->get();
        $sucursales = Agente::with('sucursales')->get();
        $consolidadores = Consolidador::all();
        $tpagos= Tpago::all();
        $bancos = Banco::all();
        $bancosg = Bancog::all();


        return view('pagos.create')
            ->with('agentes',$agentes)
            ->with('sucursales',$sucursales)
            ->with('empresas',$empresas)
            ->with('consolidadores',$consolidadores)
            ->with('tpagos',$tpagos)
            ->with('bancos',$bancos)->with('bancosg',$bancosg);

    }

    public function principal(){
        $pagos = Pago::orderBy('status', 'asc')->paginate(5);
        $agentes = Agente::all();
        $empresas = Agente::with('empresas')->get();
        $sucursales = Agente::with('sucursales')->get();
        $consolidadores = Consolidador::all();
        $tpagos= Tpago::all();
        $bancos = Banco::all();
        $bancosg = Bancog::all();
        $pagosc = Pago::count();
        $pagost = Pago::where('status', '=', 0)->count();


        return view('pagos.index',  compact('pagost','pagosc','pagos','agentes','empresas','sucursales','consolidadores','tpagos','bancos','bancosg'));
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

            $pagos= new Pago();
            $pagos->codigo = $request->codigo;
            $pagos->concepto = $request->concepto;
            $pagos->proveedor_id= $request->proveedor;
            $pagos->fecha = $request->fecha;
            $pagos->monto = $request->monto;
            $pagos->dias = $request->dias;
            $pagos->users_id = Auth::User()->id;
        if($request->resta != 0){
            $pagos->status = 0;
        }else{
            $pagos->status = 1;
        }
            $pagos->save();

             for($i=0; $i<sizeof($request->abono); $i++) {
                 $dpagos = new DPago();
                 $dpagos->codigo = $request->codigo;
                 $dpagos->abono = $request->abono[$i];
                 $dpagos->tipo_pago = $request->tipo_pago[$i];
                 $dpagos->banco_emisor = $request->banco_emisor[$i];
                 $dpagos->banco_receptor = $request->banco_receptor[$i];
                 $dpagos->nro_operacion = $request->nro_operacion[$i];
                 $dpagos->save();
             }

                //return view('welcome');
                $message = $pagos && $dpagos ? 'Se ha registrado ' . $request->nombre .  'de forma exitosa.' : 'Error al Registrar';

                //Session::flash('message', 'Te has registrado exitosamente ');
                return redirect()->route('managePago-principal-A')->with('message', $message);




    }

    public function storeb(Request $request){

      $pagos = Pago::where('codigo','=', $request->codigo)->first();

        if($request->restaenv == 0){
            $pagos->status = 1;
        }else{
            $pagos->status = 0;
        }
        $pagos->save();

        $epagos = DPago::where('codigo','=', $request->codigo);
        $epagos->delete($request->codigo);

        for($i=0; $i<sizeof($request->abono); $i++) {
            $dpagos = new DPago();
            $dpagos->codigo = $request->codigo;
            $dpagos->abono = $request->abono[$i];
            $dpagos->tipo_pago = $request->tipop[$i];
            $dpagos->banco_emisor = $request->bancoe[$i];
            $dpagos->banco_receptor = $request->bancor[$i];
            $dpagos->nro_operacion = $request->dosnroperacion[$i];
            $dpagos->save();
        }

        $message = $dpagos && $dpagos ? 'Se ha registrado el pago ' . $request->codigo.  'de forma exitosa.' : 'Error al Registrar';

        //Session::flash('message', 'Te has registrado exitosamente ');
        return redirect()->route('managePago-principal-A')->with('message', $message);


dd($request->all());

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
