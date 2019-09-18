<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Comision;
use App\Agente;
use App\Aviaje;
use App\Pais;
use App\Ciudad;
use App\Cliente;
use App\Cotizacion;
use App\Consolidador;
use App\Laerea;
use App\Iva;
use App\VboletoP;
use App\Empresa;
use App\Sucursal;
use App\Role;
use App\Tpago;
use App\Banco;
use App\Bancog;
use App\Propago;
use App\DPago;
use App\DCobro;
use App\DpagoConsolidadores;
use App\DagenciaViajes;
use App\DeuagenciaViajes;
use App\Operador;

use Auth;
class ListarController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }


    public function listar()
    {
        $clientes = Cliente::orderBy('created_at', 'desc')->paginate(10);
        $empresas = Empresa::all();
        return view('cotizaciones.listar')->with("clientes",$clientes)->with("empresas",$empresas);

    }


    public function buscar($dato="")
    {

        $clientes= Cliente::Busqueda($dato)->orderBy('created_at', 'desc')->paginate(10);
        return view('cotizaciones.listar')
            ->with("clientes", $clientes);
    }

    public function listar2()
    {
        $clientes = Cliente::orderBy('created_at', 'desc')->paginate(3);
        $empresas = Empresa::all();
        return view('cotizaciones.listar2')->with("clientes",$clientes)->with("empresas",$empresas);
    }

    public function buscar2($dato="")
    {

        $clientes= Cliente::Busqueda($dato)->orderBy('created_at', 'desc')->paginate(3);
        return view('cotizaciones.listar2')
            ->with("clientes", $clientes);
    }

    public function listar3()
    {
        $aviajes = Aviaje::orderBy('created_at', 'desc')->paginate(3);
        $empresas = Empresa::all();
        return view('cotizaciones.listar3')->with("aviajes",$aviajes)->with("empresas",$empresas);
    }

    public function buscar3($dato="")
    {
        $aviajes= Aviaje::Busqueda($dato)->orderBy('created_at', 'desc')->paginate(3);
        return view('cotizaciones.listar3')
            ->with("aviajes", $aviajes);
    }
    public function listar4()
    {
        $operadores = Operador::orderBy('created_at', 'desc')->paginate(3);
        $empresas = Empresa::all();
        return view('cotizaciones.listar4')->with("operadores",$operadores)->with("empresas",$empresas);
    }

    public function buscar4($dato="")
    {
        $operadores= Operador::Busqueda($dato)->orderBy('created_at', 'desc')->paginate(3);
        return view('cotizaciones.listar4')
            ->with("operadores", $operadores);
    }

    public function getComision($dato1,$dato2)
    {
        $datosg = Comision::where('consolidadores_id', $dato1)->where('laereas_id', $dato2)->pluck('comision')->first();
        /*dd($datosg);*/
        return $datosg;
    }

    public function storeCliente($dato1,$dato2,$dato3,$dato4,$dato5,$dato6,$dato7,$dato8){
        $existe_rif = Cliente::where('cedula_rif', '=', $dato4)->get();

        if (count($existe_rif) == 0) {

            $clientes = new Cliente();
            $clientes->empresas_id = $dato1;
            $clientes->nombre = $dato2;
            $clientes->apellido = $dato3;
            $clientes->cedula_rif = $dato4;
            $clientes->direccion = $dato5;
            $clientes->telefono = $dato6;
            $clientes->email = $dato7;
            $clientes->tipo_pasajero = $dato8;
            $clientes->users_id = Auth::User()->id;
            $clientes->save();
            $resultado = $clientes ? 'Se ha guardado el registro con cedula: '. $dato4 .' de forma exitosa.' : 'Error al guardar';
            return $resultado;
        }else{
            $resultado = "El pasajero ya existe";
            return $resultado;
        }
    }

    public function getPagos($codigo)
    {
        $pagosg = DPago::all()->where('codigo','=',$codigo);
        /*dd($datosg);*/
        return $pagosg;
    }
    public function getPagosC($codigo, $ticket)
    {
        $pagosgc = DpagoConsolidadores::all()->where('codigo','=',$codigo)->where('nro_ticket','=',$ticket);
        /*dd($datosg);*/
        return $pagosgc;
    }
    public function getCobrosA($codigo, $ticket)
    {
        $cobrosga = DagenciaViajes::all()->where('venta_boleto_id','=',$codigo)->where('nro_ticket','=',$ticket);
        /*dd($datosg);*/
        return $cobrosga;
    }
    public function getDeudasA($codigo, $ticket)
    {
        $cobrosga = DeuagenciaViajes::where('venta_boleto_id','=',$codigo)->where('nro_ticket','=',$ticket)->first();
        /*dd($datosg);*/
        return $cobrosga;
    }
    public function getConsoA($consolidadores_id)
    {
        $conso = Consolidador::where('id','=',$consolidadores_id)->first();
        /*dd($datosg);*/
        return $conso;
    }

    public function getCobros($dni_ruc)
    {
        $cobrosg = DCobro::all()->where('dni_ruc','=',$dni_ruc);
        /*dd($datosg);*/
        return $cobrosg;
    }

    public function getCodigo($dato)
    {
        $boletosg = VboletoP::where('codigo', $dato)->pluck('codigo');
        /*dd($datosg);*/
        return $boletosg;
    }

    public function getTikets($dato)
    {
        $tiketsg = VboletoP::where('nro_ticket', $dato)->pluck('nro_ticket');
        /*dd($datosg);*/
        return $tiketsg;
    }


}
