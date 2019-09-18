<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Vboleto;
use App\Empresa;
use App\Sucursal;
use App\Role;
use App\DeupagoConsolidadores;
use App\DpagoConsolidadores;
use App\Agente;
use App\Consolidador;
use App\Tpago;
use App\Banco;
use App\Bancog;
use App\Pago;
use App\DPago;
use App\Aviaje;
use App\Laerea;

use Auth;
class PconsolidadorController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function getManagePconsolidador(Request $request){
        if (($request->fechai != "") and ($request->fechaf != "")){
            $fechai = $request->fechai;
            $fechaf = $request->fechaf;
        }else{
            $fechai = date('Y-m-d');
            $fechaf = date('Y-m-d');
        }

        $deupagosC = DeupagoConsolidadores::whereBetween('fecha', [$fechai, $fechaf])->where('anulado','!=','1')->orderBy('venta_boleto_id','desc')->get();
        $contadorr= DeupagoConsolidadores::count();
        $tpagos= Tpago::all();
        $bancos = Banco::all();
        $bancosg = Bancog::all();

        $consolidadores = Consolidador::orderBy('nombre','asc')->get();
        $aviajes = Aviaje::orderBy('nombre','asc')->get();
        $laereas = Laerea::orderBy('nombre','asc')->get();
        $vendedor = User::orderBy('nombres','asc')->get();

        return view('pconsolidadores.index',compact('consolidadores','aviajes','laereas','vendedor','deupagosC','contadorr','tpagos','bancos','bancosg','fechai','fechaf'));

    }
    public function getManagePconsolidadorfecha(Request $request){
        if (($request->fechai != "") and ($request->fechaf != "")){
            $fechai = $request->fechai;
            $fechaf = $request->fechaf;
        }else{
            $fechai = date('Y-m-d');
            $fechaf = date('Y-m-d');
        }
        $consolidadores = Consolidador::orderBy('nombre','asc')->get();
        $aviajes = Aviaje::orderBy('nombre','asc')->get();
        $laereas = Laerea::orderBy('nombre','asc')->get();
        $vendedor = User::orderBy('nombres','asc')->get();
        $deupagosC = DeupagoConsolidadores::whereBetween('fecha', [$fechai, $fechaf])->where('anulado','!=','1')->orderBy('venta_boleto_id','desc')->get();
        $contadorr= DeupagoConsolidadores::count();
        $tpagos= Tpago::all();
        $bancos = Banco::all();
        $bancosg = Bancog::all();
        return view('pconsolidadores.index',compact('consolidadores','aviajes','laereas','vendedor','deupagosC','contadorr','tpagos','bancos','bancosg','fechai','fechaf'));

    }
    public function getManagePconsolidadorbusqueda(Request $request)

    {

        if (($request->fechai != "") and ($request->fechaf != "")){
            $fechai = $request->fechai;
            $fechaf = $request->fechaf;
        }else{
            $fechai = date('Y-m-d');
            $fechaf = date('Y-m-d');
        }

        $consulta= DeupagoConsolidadores::select('id','fecha','venta_boleto_id','codigo','nro_ticket','dni_ruc','nombre_cliente', 'laereas_id' ,
            'ruta','consolidadores_id','aviajes_id',
            'pago_consolidador','porpagar','comision_agencia','igv','total','diasc',
            'status','created_at','updated_at','users_id');

        /*---------------------------------------consolidador lleno------------------*/
        if (sizeof($request->consolidador) >= 0){
            for ($i = 0; $i < sizeof($request->consolidador); $i++) {
                $consulta->where('consolidadores_id', $request->consolidador[$i])->where('anulado','!=','1');

            }
            if(sizeof($request->aviajes) >= 0){
                for ($i = 0; $i < sizeof($request->aviajes); $i++) {
                    $consulta->where('aviajes_id', $request->aviajes[$i])->where('anulado','!=','1');
                }
            }
            if(sizeof($request->laereas) >= 0){
                for ($i = 0; $i < sizeof($request->laereas); $i++) {
                    $consulta->where('laereas_id', $request->laereas[$i])->where('anulado','!=','1');
                }
            }
            if($request->has('status')){
                $consulta->Where('status',$request->status)->where('anulado','!=','1');
            }

            $consulta->whereBetween('created_at', [$fechai, $fechaf])->where('anulado','!=','1');


        }
        /*---------------------------------------Fin consolidador lleno------------------*/
        /*---------------------------------------Agencia de viajes lleno------------------*/
        if (sizeof($request->aviajes) >= 0){
            for ($i = 0; $i < sizeof($request->aviajes); $i++) {
                $consulta->where('aviajes_id', $request->aviajes[$i])->where('anulado','!=','1');
            }
            if(sizeof($request->consolidador) >= 0){
                for ($i = 0; $i < sizeof($request->consolidador); $i++) {
                    $consulta->where('consolidadores_id', $request->consolidador[$i])->where('anulado','!=','1');
                }
            }
            if(sizeof($request->laereas) >= 0){
                for ($i = 0; $i < sizeof($request->laereas); $i++) {
                    $consulta->where('laereas_id', $request->laereas[$i])->where('anulado','!=','1');
                }
            }
            if($request->has('status')){
                $consulta->Where('status',$request->status)->where('anulado','!=','1');
            }

            $consulta->whereBetween('created_at', [$fechai, $fechaf])->where('anulado','!=','1');

        }
        /*---------------------------------------Fin Agencia de Viajes lleno------------------*/
        /*---------------------------------------Lienas Aereas lleno------------------*/
        if (sizeof($request->laereas) >= 0){
            for ($i = 0; $i < sizeof($request->laereas); $i++) {
                $consulta->where('laereas_id', $request->laereas[$i])->where('anulado','!=','1');
            }

            if(sizeof($request->aviajes) >= 0){
                for ($i = 0; $i < sizeof($request->aviajes); $i++) {
                    $consulta->where('aviajes_id', $request->aviajes[$i])->where('anulado','!=','1');
                }
            }
            if(sizeof($request->consolidador) >= 0){
                for ($i = 0; $i < sizeof($request->consolidador); $i++) {
                    $consulta->where('consolidadores_id', $request->consolidador[$i])->where('anulado','!=','1');
                }
            }
            if($request->has('status')){
                $consulta->Where('status',$request->status)->where('anulado','!=','1');
            }

            $consulta->whereBetween('created_at', [$fechai, $fechaf])->where('anulado','!=','1');

        }
        /*---------------------------------------Fin Lienas Aeres lleno------------------*/

       $consulta= $consulta->get();
        $deupagosC= $consulta;
        // dd($request->all(),$consulta);
        $consolidadores = Consolidador::orderBy('nombre','asc')->get();
        $aviajes = Aviaje::orderBy('nombre','asc')->get();
        $laereas = Laerea::orderBy('nombre','asc')->get();
        $vendedor = User::orderBy('nombres','asc')->get();
        $tpagos = Tpago::orderBy('pago','asc')->get();
        $contadorr= DeupagoConsolidadores::count();
        $bancos = Banco::all();
        $bancosg = Bancog::all();

        return view('pconsolidadores.index',compact('bancos','bancosg','tpagos','contadorr','consolidadores','aviajes','laereas','vendedor','tipop'))->with('deupagosC',$deupagosC)->with('fechai', $fechai)->with('fechaf', $fechaf);

      /*  dd($request->all());*/
    }

    public function getManagePconsolidadorbusquedasm(Request $request)

    {

        if (($request->fechai != "") and ($request->fechaf != "")){
            $fechai = $request->fechai;
            $fechaf = $request->fechaf;
        }else{
            $fechai = date('Y-m-d');
            $fechaf = date('Y-m-d');
        }

        $consulta= DeupagoConsolidadores::select('id','fecha','venta_boleto_id','codigo','nro_ticket','dni_ruc','nombre_cliente', 'laereas_id' ,
            'ruta','consolidadores_id','aviajes_id',
            'pago_consolidador','porpagar','comision_agencia','igv','total','diasc',
            'status','created_at','updated_at','users_id');

        /*---------------------------------------consolidador lleno------------------*/
        if (sizeof($request->consolidador) >= 0){
            for ($i = 0; $i < sizeof($request->consolidador); $i++) {
                $consulta->where('consolidadores_id', $request->consolidador[$i])->where('anulado','!=','1');

            }
            if(sizeof($request->aviajes) >= 0){
                for ($i = 0; $i < sizeof($request->aviajes); $i++) {
                    $consulta->where('aviajes_id', $request->aviajes[$i])->where('anulado','!=','1');
                }
            }
            if(sizeof($request->laereas) >= 0){
                for ($i = 0; $i < sizeof($request->laereas); $i++) {
                    $consulta->where('laereas_id', $request->laereas[$i])->where('anulado','!=','1');
                }
            }
            if($request->has('status')){
                $consulta->Where('status',$request->status)->where('anulado','!=','1');
            }

            $consulta->whereBetween('created_at', [$fechai, $fechaf])->where('anulado','!=','1');


        }
        /*---------------------------------------Fin consolidador lleno------------------*/
        /*---------------------------------------Agencia de viajes lleno------------------*/
        if (sizeof($request->aviajes) >= 0){
            for ($i = 0; $i < sizeof($request->aviajes); $i++) {
                $consulta->where('aviajes_id', $request->aviajes[$i])->where('anulado','!=','1');
            }
            if(sizeof($request->consolidador) >= 0){
                for ($i = 0; $i < sizeof($request->consolidador); $i++) {
                    $consulta->where('consolidadores_id', $request->consolidador[$i])->where('anulado','!=','1');
                }
            }
            if(sizeof($request->laereas) >= 0){
                for ($i = 0; $i < sizeof($request->laereas); $i++) {
                    $consulta->where('laereas_id', $request->laereas[$i])->where('anulado','!=','1');
                }
            }
            if($request->has('status')){
                $consulta->Where('status',$request->status)->where('anulado','!=','1');
            }

            $consulta->whereBetween('created_at', [$fechai, $fechaf])->where('anulado','!=','1');

        }
        /*---------------------------------------Fin Agencia de Viajes lleno------------------*/
        /*---------------------------------------Lienas Aereas lleno------------------*/
        if (sizeof($request->laereas) >= 0){
            for ($i = 0; $i < sizeof($request->laereas); $i++) {
                $consulta->where('laereas_id', $request->laereas[$i])->where('anulado','!=','1');
            }

            if(sizeof($request->aviajes) >= 0){
                for ($i = 0; $i < sizeof($request->aviajes); $i++) {
                    $consulta->where('aviajes_id', $request->aviajes[$i])->where('anulado','!=','1');
                }
            }
            if(sizeof($request->consolidador) >= 0){
                for ($i = 0; $i < sizeof($request->consolidador); $i++) {
                    $consulta->where('consolidadores_id', $request->consolidador[$i])->where('anulado','!=','1');
                }
            }
            if($request->has('status')){
                $consulta->Where('status',$request->status->where('anulado','!=','1'));
            }

            $consulta->whereBetween('created_at', [$fechai, $fechaf])->where('anulado','!=','1');

        }
        /*---------------------------------------Fin Lienas Aeres lleno------------------*/

        $consulta= $consulta->get();
        $deupagosC= $consulta;
        // dd($request->all(),$consulta);
        $consolidadores = Consolidador::orderBy('nombre','asc')->get();
        $aviajes = Aviaje::orderBy('nombre','asc')->get();
        $laereas = Laerea::orderBy('nombre','asc')->get();
        $vendedor = User::orderBy('nombres','asc')->get();
        $tpagos = Tpago::orderBy('pago','asc')->get();
        $contadorr= DeupagoConsolidadores::count();
        $bancos = Banco::all();
        $bancosg = Bancog::all();

        return view('pconsolidadores.indexsm',compact('bancos','bancosg','tpagos','contadorr','consolidadores','aviajes','laereas','vendedor','tipop'))->with('deupagosC',$deupagosC)->with('fechai', $fechai)->with('fechaf', $fechaf);

        /*  dd($request->all());*/
    }
    public function getManagePconsolidadorbusquedaif(Request $request)

    {

        if (($request->fechai != "") and ($request->fechaf != "")){
            $fechai = $request->fechai;
            $fechaf = $request->fechaf;
        }else{
            $fechai = date('Y-m-d');
            $fechaf = date('Y-m-d');
        }

        $consulta= DeupagoConsolidadores::select('id','fecha','venta_boleto_id','codigo','nro_ticket','dni_ruc','nombre_cliente', 'laereas_id' ,
            'ruta','consolidadores_id','aviajes_id',
            'pago_consolidador','porpagar','comision_agencia','igv','total','diasc',
            'status','created_at','updated_at','users_id');

        /*---------------------------------------consolidador lleno------------------*/
        if (sizeof($request->consolidador) >= 0){
            for ($i = 0; $i < sizeof($request->consolidador); $i++) {
                $consulta->where('consolidadores_id', $request->consolidador[$i])->where('anulado','!=','1');

            }
            if(sizeof($request->aviajes) >= 0){
                for ($i = 0; $i < sizeof($request->aviajes); $i++) {
                    $consulta->where('aviajes_id', $request->aviajes[$i])->where('anulado','!=','1');
                }
            }
            if(sizeof($request->laereas) >= 0){
                for ($i = 0; $i < sizeof($request->laereas); $i++) {
                    $consulta->where('laereas_id', $request->laereas[$i])->where('anulado','!=','1');
                }
            }
            if($request->has('status')){
                $consulta->Where('status',$request->status)->where('anulado','!=','1');
            }

            $consulta->whereBetween('created_at', [$fechai, $fechaf])->where('anulado','!=','1');


        }
        /*---------------------------------------Fin consolidador lleno------------------*/
        /*---------------------------------------Agencia de viajes lleno------------------*/
        if (sizeof($request->aviajes) >= 0){
            for ($i = 0; $i < sizeof($request->aviajes); $i++) {
                $consulta->where('aviajes_id', $request->aviajes[$i])->where('anulado','!=','1');
            }
            if(sizeof($request->consolidador) >= 0){
                for ($i = 0; $i < sizeof($request->consolidador); $i++) {
                    $consulta->where('consolidadores_id', $request->consolidador[$i])->where('anulado','!=','1');
                }
            }
            if(sizeof($request->laereas) >= 0){
                for ($i = 0; $i < sizeof($request->laereas); $i++) {
                    $consulta->where('laereas_id', $request->laereas[$i])->where('anulado','!=','1');
                }
            }
            if($request->has('status')){
                $consulta->Where('status',$request->status)->where('anulado','!=','1');
            }

            $consulta->whereBetween('created_at', [$fechai, $fechaf])->where('anulado','!=','1');

        }
        /*---------------------------------------Fin Agencia de Viajes lleno------------------*/
        /*---------------------------------------Lienas Aereas lleno------------------*/
        if (sizeof($request->laereas) >= 0){
            for ($i = 0; $i < sizeof($request->laereas); $i++) {
                $consulta->where('laereas_id', $request->laereas[$i])->where('anulado','!=','1');
            }

            if(sizeof($request->aviajes) >= 0){
                for ($i = 0; $i < sizeof($request->aviajes); $i++) {
                    $consulta->where('aviajes_id', $request->aviajes[$i])->where('anulado','!=','1');
                }
            }
            if(sizeof($request->consolidador) >= 0){
                for ($i = 0; $i < sizeof($request->consolidador); $i++) {
                    $consulta->where('consolidadores_id', $request->consolidador[$i])->where('anulado','!=','1');
                }
            }
            if($request->has('status')){
                $consulta->Where('status',$request->status->where('anulado','!=','1'));
            }

            $consulta->whereBetween('created_at', [$fechai, $fechaf])->where('anulado','!=','1');

        }
        /*---------------------------------------Fin Lienas Aeres lleno------------------*/

        $consulta= $consulta->get();
        $deupagosC= $consulta;
        // dd($request->all(),$consulta);
        $consolidadores = Consolidador::orderBy('nombre','asc')->get();
        $aviajes = Aviaje::orderBy('nombre','asc')->get();
        $laereas = Laerea::orderBy('nombre','asc')->get();
        $vendedor = User::orderBy('nombres','asc')->get();
        $tpagos = Tpago::orderBy('pago','asc')->get();
        $contadorr= DeupagoConsolidadores::count();
        $bancos = Banco::all();
        $bancosg = Bancog::all();

        return view('pconsolidadores.indexif',compact('bancos','bancosg','tpagos','contadorr','consolidadores','aviajes','laereas','vendedor','tipop'))->with('deupagosC',$deupagosC)->with('fechai', $fechai)->with('fechaf', $fechaf);

        /*  dd($request->all());*/
    }

    public function getManagePconsolidadorsm(Request $request){
        if (($request->fechai != "") and ($request->fechaf != "")){
            $fechai = $request->fechai;
            $fechaf = $request->fechaf;
        }else{
            $fechai = date('Y-m-d');
            $fechaf = date('Y-m-d');
        }
        $consolidadores = Consolidador::orderBy('nombre','asc')->get();
        $aviajes = Aviaje::orderBy('nombre','asc')->get();
        $laereas = Laerea::orderBy('nombre','asc')->get();
        $vendedor = User::orderBy('nombres','asc')->get();
        $deupagosC = DeupagoConsolidadores::whereBetween('fecha', [$fechai, $fechaf])->where('anulado','!=','1')->orderBy('venta_boleto_id','desc')->get();
        $contadorr= DeupagoConsolidadores::count();
        $tpagos= Tpago::all();
        $bancos = Banco::all();
        $bancosg = Bancog::all();
        return view('pconsolidadores.indexsm',compact('consolidadores','aviajes','laereas','vendedor','deupagosC','contadorr','tpagos','bancos','bancosg','fechai','fechaf'));

    }
    public function getManagePconsolidadorif(Request $request){
        if (($request->fechai != "") and ($request->fechaf != "")){
            $fechai = $request->fechai;
            $fechaf = $request->fechaf;
        }else{
            $fechai = date('Y-m-d');
            $fechaf = date('Y-m-d');
        }
        $consolidadores = Consolidador::orderBy('nombre','asc')->get();
        $aviajes = Aviaje::orderBy('nombre','asc')->get();
        $laereas = Laerea::orderBy('nombre','asc')->get();
        $vendedor = User::orderBy('nombres','asc')->get();
        $deupagosC = DeupagoConsolidadores::whereBetween('fecha', [$fechai, $fechaf])->where('anulado','!=','1')->orderBy('venta_boleto_id','desc')->get();
        $contadorr= DeupagoConsolidadores::count();
        $tpagos= Tpago::all();
        $bancos = Banco::all();
        $bancosg = Bancog::all();
        return view('pconsolidadores.indexif',compact('consolidadores','aviajes','laereas','vendedor','deupagosC','contadorr','tpagos','bancos','bancosg','fechai','fechaf'));

    }
    public function getManagePconsolidadorsmfecha(Request $request){
        if (($request->fechai != "") and ($request->fechaf != "")){
            $fechai = $request->fechai;
            $fechaf = $request->fechaf;
        }else{
            $fechai = date('Y-m-d');
            $fechaf = date('Y-m-d');
        }
        $consolidadores = Consolidador::orderBy('nombre','asc')->get();
        $aviajes = Aviaje::orderBy('nombre','asc')->get();
        $laereas = Laerea::orderBy('nombre','asc')->get();
        $vendedor = User::orderBy('nombres','asc')->get();
        $deupagosC = DeupagoConsolidadores::whereBetween('fecha', [$fechai, $fechaf])->where('anulado','!=','1')->orderBy('venta_boleto_id','desc')->get();
        $contadorr= DeupagoConsolidadores::count();
        $tpagos= Tpago::all();
        $bancos = Banco::all();
        $bancosg = Bancog::all();
        return view('pconsolidadores.indexsm',compact('consolidadores','aviajes','laereas','vendedor','deupagosC','contadorr','tpagos','bancos','bancosg','fechai','fechaf'));

    }
    public function getManagePconsolidadoriffecha(Request $request){
        if (($request->fechai != "") and ($request->fechaf != "")){
            $fechai = $request->fechai;
            $fechaf = $request->fechaf;
        }else{
            $fechai = date('Y-m-d');
            $fechaf = date('Y-m-d');
        }
        $consolidadores = Consolidador::orderBy('nombre','asc')->get();
        $aviajes = Aviaje::orderBy('nombre','asc')->get();
        $laereas = Laerea::orderBy('nombre','asc')->get();
        $vendedor = User::orderBy('nombres','asc')->get();
        $deupagosC = DeupagoConsolidadores::whereBetween('fecha', [$fechai, $fechaf])->where('anulado','!=','1')->orderBy('venta_boleto_id','desc')->get();
        $contadorr= DeupagoConsolidadores::count();
        $tpagos= Tpago::all();
        $bancos = Banco::all();
        $bancosg = Bancog::all();
        return view('pconsolidadores.indexif',compact('consolidadores','aviajes','laereas','vendedor','deupagosC','contadorr','tpagos','bancos','bancosg','fechai','fechaf'));

    }

    public function create(){
        $empresas = Empresa::all();
        $sucursales = Sucursal::all();

        return view('Vboletos.create',  compact('empresas'), compact('sucursales'));
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $existe_rif = Vboleto::where('cedula_rif', '=', $request->rif)->get();

        if (count($existe_rif) == 0) {

                $Vboletos = new Vboleto();
                $Vboletos->fecha = date('Y-m-d');
                $Vboletos->empresas_id  = $request->empresa;
                $Vboletos->sucursales_id  = $request->sucursal;
                $Vboletos->nombre       = $request->nombre;
                $Vboletos->apellido     = $request->apellido;
                $Vboletos->cedula_rif   = $request->cedula_rif;
                $Vboletos->direccion    = $request->direccion;
                $Vboletos->telefono     = $request->telefono;
                $Vboletos->email        = $request->email;
                $Vboletos->cargo        = $request->cargo;
                $Vboletos->users_id   = Auth::User()->id;
                $Vboletos->save();

                //return view('welcome');
                $message = $Vboletos ? 'Se ha registrado ' . $request->nombre .  'de forma exitosa.' : 'Error al Registrar';

                //Session::flash('message', 'Te has registrado exitosamente ');
                return redirect()->route('manageVboleto-A')->with('message', $message);


        } else {

            $message2 = 'Esta Vboleto ya se encuentra registrada';
            return redirect()->route('manageVboleto-A')->with('message2', $message2);

        }
    }

    public function storeb(Request $request){
        $pagos = DeupagoConsolidadores::where('codigo','=', $request->codigo)->where('nro_ticket','=',$request->ticket)->first();
        if($request->restaenv == 0){
            $pagos->status = 1;
            $pagos->porpagar = $request->restaenv;
        }else{
            $pagos->status = 0;
            $pagos->porpagar = $request->restaenv;
        }
        $pagos->save();
        $epagos = DpagoConsolidadores::where('codigo','=', $request->codigo)->where('nro_ticket','=',$request->ticket);
        $epagos->delete($request->codigo);
        
        for($i=0; $i<sizeof($request->abono); $i++) {
            $apagos = new DpagoConsolidadores();

            $apagos->codigo = $request->codigo;
            $apagos->nro_ticket = $request->ticket;
            $apagos->abono = $request->abono[$i];
            $apagos->tipo_pago = $request->tipop[$i];
            $apagos->banco_emisor = $request->bancoe[$i];
            $apagos->banco_receptor = $request->bancor[$i];
            $apagos->nro_operacion = $request->dosnroperacion[$i];
            $apagos->save();
        }
        $message = $pagos && $epagos ? 'Se ha registrado el pago ' . $request->codigo.  'de forma exitosa.' : 'Error al Registrar';
        //Session::flash('message', 'Te has registrado exitosamente ');
        return redirect()->route('managePconsolidador-A')->with('message', $message);

       /* dd($request->all());*/
    }
    public function storebsm(Request $request){
        $pagos = DeupagoConsolidadores::where('codigo','=', $request->codigo)->where('nro_ticket','=',$request->ticket)->first();
        if($request->restaenv == 0){
            $pagos->status = 1;
            $pagos->porpagar = $request->restaenv;
        }else{
            $pagos->status = 0;
            $pagos->porpagar = $request->restaenv;
        }
        $pagos->save();
        $epagos = DpagoConsolidadores::where('codigo','=', $request->codigo)->where('nro_ticket','=',$request->ticket);
        $epagos->delete($request->codigo);
        /*
            Se eliminaron los campos: pm, codigo, consolidadores_id, user_id
        */
        for($i=0; $i<sizeof($request->abono); $i++) {
            $apagos = new DpagoConsolidadores();

            $apagos->codigo = $request->codigo;
            $apagos->nro_ticket = $request->ticket;
            $apagos->abono = $request->abono[$i];
            $apagos->tipo_pago = $request->tipop[$i];
            $apagos->banco_emisor = $request->bancoe[$i];
            $apagos->banco_receptor = $request->bancor[$i];
            $apagos->nro_operacion = $request->dosnroperacion[$i];
            $apagos->save();
        }
        $message = $pagos && $epagos ? 'Se ha registrado el pago ' . $request->codigo.  'de forma exitosa.' : 'Error al Registrar';
        //Session::flash('message', 'Te has registrado exitosamente ');
        return redirect()->route('managePconsolidadorsm-A')->with('message', $message);

        /* dd($request->all());*/
    }
    public function storepm(Request $request){

        for( $i=0; $i<sizeof($request->codigo); $i++){

        $pagos = DeupagoConsolidadores::where('codigo','=', $request->codigo[$i])->where('nro_ticket','=',$request->ticket[$i])->first();
            $pagos->status = 1;
            $pagos->porpagar = 0;
        $pagos->save();

        $epagos = DpagoConsolidadores::where('codigo','=', $request->codigo[$i])->where('nro_ticket','=',$request->ticket[$i]);
        $epagos->delete($request->codigo[$i]);

            $apagos = new DpagoConsolidadores();

            $apagos->codigo = $request->codigo[$i];
            $apagos->nro_ticket = $request->ticket[$i];
            $apagos->abono = $request->abono;
            $apagos->pm = "1";
            $apagos->tipo_pago = $request->tipop;
            $apagos->banco_emisor = $request->bancoe;
            $apagos->banco_receptor = $request->bancor;
            $apagos->nro_operacion = $request->noperacion;
            $apagos->save();


        //Session::flash('message', 'Te has registrado exitosamente ');
        }
        $message ='Se ha registrado el pago multiple de forma exitosa.';
        return redirect()->route('managePconsolidador-A')->with('message', $message);

        /* dd($request->all());*/
    }

    public function edit($id){

        $Vboletos = Vboleto::where('id','=', $id)->first();
        $empresas = Empresa::all();
        return view('Vboletos.edit')->with('Vboletos', $Vboletos)->with('empresas', $empresas);
    }

    public function update(Request $request, $id){

        $Vboletos= Vboleto::find($id);
        $Vboletos = Vboleto::where('id','=', $id)->first();
        $Vboletos->empresas_id  = $request->empresa;
        $Vboletos->sucursales_id  = $request->sucursal;
        $Vboletos->nombre       = $request->nombre;
        $Vboletos->apellido     = $request->apellido;
        $Vboletos->cedula_rif   = $request->cedula_rif;
        $Vboletos->direccion    = $request->direccion;
        $Vboletos->telefono     = $request->telefono;
        $Vboletos->email        = $request->email;
        $Vboletos->cargo        = $request->cargo;
        $Vboletos->users_id   = Auth::User()->id;
        $Vboletos->save();

        $message = $Vboletos?'Se ha actualizado el registro '. $request->nombre .' de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageVboleto-A')->with('message', $message);


    }

    public function status(Request $request, $id){

        $Vboletos = User::where('id','=', $id)->first();
        if ($Vboletos->active == '0'){
            $Vboletos= Vboleto::find($id);
            $Vboletos = User::where('id','=', $id)->first();
            $Vboletos->active   = "1";
            $Vboletos->save();
            $message = $Vboletos?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageVboleto-A')->with('message', $message);
        }else {
            if ($Vboletos->active == '1')
                $Vboletos = User::find($id);
            $Vboletos = User::where('id', '=', $id)->first();
            $Vboletos->active = "0";
            $Vboletos->save();
            $message = $Vboletos ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';

                return redirect()->route('manageVboleto-A')->with('message', $message);
        }
    }



    public function show($id){
        $Vboletos = Vboleto::all()->lists('name', 'id');

        return view('Vboletos.show');

    }


    public function destroy($id){

        $Vboletos = Vboleto::find($id);
        $Vboletos->delete($id);
        $message = $Vboletos?'Registro eliminado correctamente' : 'Error al Eliminar';

            return redirect()->route('manageVboleto-A')->with('message', $message);

    }
}
