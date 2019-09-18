<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Role;
use App\Pais;
use App\Ciudad;
use App\Empresa;
use App\Sucursal;
use App\Datoslaborales;
use App\Datoscargados;
use App\Empleado;
use App\Contrato;
use App\Inasistencia;
use App\Adelanto;
use App\OtrosAportes;
use App\Aporte;
use App\Bancog;
use Auth;

class NominaController extends Controller
{

    public function __construct() {
        $this->middleware('web');
    }

    public function getManageNomina(Request $request){
        $request->session()->forget('empleado');
        $empleados = Empleado::all();
        //$listado = Datoslaborales::all();
        $listado = Contrato::get();
        //dd($listado);
        //$listado = Empleado::get();
        //dd($listado[0]->datoslaborales->empleado->nombres);
        $contratos = Contrato::all();
        //dd($contratos);
        $paises = Pais::orderBy('paisnombre','asc')->get();
        $empresas = Empresa::orderBy('id','desc')->get();
        $opciones = Datoscargados::orderBy('id','desc')->get();
        $apf = Aporte::all();
        $aportes = OtrosAportes::all();
        return view('nomina.index', compact('empleados', 'contratos', 'paises', 'empresas', 'opciones', 'apf', 'aportes','listado'));
        //return view('nomina.index',compact('listado'),compact('paises'))->with('empresas',$empresas)->with('opciones',$opciones)->with('apf',$apf)->with('aportes',$aportes);
    }
    public function nuevo(Request $request){
        $empleado = $request->session()->get('empleado');
        $paises = Pais::orderBy('paisnombre','asc')->get();
        $empresas = Empresa::orderBy('id','desc')->get();
        $opciones = Datoscargados::orderBy('id','desc')->get();
        $aportes = Aporte::all();
        $bancos = Bancog::all();
        //return view('nomina.formularios.nuevo',compact('paises'),compact('empresas'))->with('opciones',$opciones)->with('aportes',$aportes);
        return view('nomina.formularios.nuevo', compact('empleado', 'paises', 'empresas', 'opciones', 'aportes', 'bancos'));
    }

    //Nuevo empleado
    public function postEmpleado1(Request $request)
    {
         $empleado = $request->session()->get('empleado');
        $paises = Pais::orderBy('paisnombre','asc')->get();
        $empresas = Empresa::orderBy('id','desc')->get();
        $opciones = Datoscargados::orderBy('id','desc')->get();
        $aportes = Aporte::all();
        $bancos = Bancog::all();
        # code...
        //dd($request->all());
        /*if(empty($request->session()->get('empleado'))){
            $empleado = New Empleado();
            $request->session()->put('empleado', $empleado);
        }else{
            $empleado = $request->session()->get('empleado');
            $request->session()->put('empleado', $empleado);
        }*/
        $destino = 'uploads/empleados';
        $imagen = $request->file('image');
        $random = str_random(6);
        if (!empty($imagen)) {
            $nombreImagen = $request->cedula.$random.$imagen->getClientOriginalName();
            $imagen->move($destino,$nombreImagen);
        }else{
            $nombreImagen = 'user_default.png';
        }
        //dd($request->all());
        $empleado                       =    new Empleado();
        $empleado->foto                 =    $nombreImagen;
        $empleado->nombres              =    $request->nombres;
        $empleado->apellidos            =    $request->apellidos;
        $empleado->documento            =    $request->documento;
        $empleado->email                =    $request->email;
        $empleado->telefono_local       =    $request->telefono_local;
        $empleado->telefono_celular     =    $request->telefono_celular;
        $empleado->direccion            =    $request->direccion;
        $empleado->fecha_nacimiento     =    $request->fecha_nacimiento;
        $empleado->estado_civil         =    $request->estado_civil;
        $empleado->pais                 =    $request->pais;
        $empleado->hijos                =    $request->hijos;
        $empleado->save();
        return view('nomina.formularios.nuevo1', compact('empleado', 'paises', 'empresas', 'opciones', 'aportes'));
    }
    
    public function nuevo1(Request $request){
        $empleado = $request->session()->get('empleado');
        $paises = Pais::orderBy('paisnombre','asc')->get();
        $empresas = Empresa::orderBy('id','desc')->get();
        $opciones = Datoscargados::orderBy('id','desc')->get();
        $aportes = Aporte::all();
        $bancos = Bancog::all();
        //return view('nomina.formularios.nuevo',compact('paises'),compact('empresas'))->with('opciones',$opciones)->with('aportes',$aportes);
        return view('nomina.formularios.nuevo2', compact('empleado', 'paises', 'empresas', 'opciones', 'aportes', 'bancos'));
    }
    
    public function postEmpleado2(Request $request)
    {
        $empleado = $request->session()->get('empleado');
        $paises = Pais::orderBy('paisnombre','asc')->get();
        $empresas = Empresa::orderBy('id','desc')->get();
        $opciones = Datoscargados::orderBy('id','desc')->get();
        $aportes = Aporte::all();
        # code...
        //dd($request->all());
        /*if(empty($request->session()->get('empleado'))){
            $empleado = New Empleado();
            $request->session()->put('empleado', $empleado);
        }else{
            $empleado = $request->session()->get('empleado');
            $request->session()->put('empleado', $empleado);
        }*/
        //dd($request->all());
        $datoslaborales = new Datoslaborales();
        $id                                     =   Empleado::orderBy('id','desc')->first();
        //$id_c                                   =   Contrato::orderBy('id','desc')->first();
        $datoslaborales->empleado_id            =   $id->id;
        //$datoslaborales->contrato_id            =   $id_c->id;
        //$datoslaborales->fecha_ingreso          =   $request->fecha_ingreso;
        $datoslaborales->empresa                =   $request->empresa;
        $datoslaborales->tipo_empleado          =   $request->tipo_empleado;
        $datoslaborales->turno                  =   $request->turno;
        $datoslaborales->ocupacion              =   $request->ocupacion;
        $datoslaborales->forma_pago             =   $request->forma_pago;
        $datoslaborales->tipo_moneda            =   $request->tipo_moneda;
        $datoslaborales->categoria_ocupacional  =   $request->categoria_ocupacional;
        $datoslaborales->cargo                  =   $request->cargo;
        $datoslaborales->banco                  =   $request->banco;
        $datoslaborales->seguro                 =   $request->seguro;
        $datoslaborales->estado                 =   1;
        $datoslaborales->numero_cuenta          =   $request->numero_cuenta;
        //$datoslaborales->vencimiento            =   $id_c->fecha_fin;
        $datoslaborales->apf                    =   $request->apf;
        $datoslaborales->salud                  =   $request->salud;
        $datoslaborales->save();
        
        //return view('nomina.formularios.nuevo2');
        return view('nomina.formularios.nuevo2', compact('empleado', 'paises', 'empresas', 'opciones', 'aportes'));
        
    }
    public function nuevo2(Request $request){
        $empleado = $request->session()->get('empleado');
        $paises = Pais::orderBy('paisnombre','asc')->get();
        $empresas = Empresa::orderBy('id','desc')->get();
        $opciones = Datoscargados::orderBy('id','desc')->get();
        $aportes = Aporte::all();
        $bancos = Bancog::all();
        //return view('nomina.formularios.nuevo',compact('paises'),compact('empresas'))->with('opciones',$opciones)->with('aportes',$aportes);
        return view('nomina.formularios.nuevo1', compact('empleado', 'paises', 'empresas', 'opciones', 'aportes', 'bancos'));
    }
    
    public function postEmpleado3(Request $request)
    {
        $empleado = $request->session()->get('empleado');
        $paises = Pais::orderBy('paisnombre','asc')->get();
        $empresas = Empresa::orderBy('id','desc')->get();
        $opciones = Datoscargados::orderBy('id','desc')->get();
        $aportes = Aporte::all();
        # code...
        //dd($request->all());
        /*if(empty($request->session()->get('empleado'))){
            $empleado = New Empleado();
            $request->session()->put('empleado', $empleado);
        }else{
            $empleado = $request->session()->get('empleado');
            $request->session()->put('empleado', $empleado);
        }*/
        //dd($request->all());
        $contrato                   =   new Contrato();
        $id                         =   Empleado::orderBy('id','desc')->first();
        $id_DL                      =   Contrato::orderBy('id','desc')->first();
        $contrato->fecha_inicio     =   $request->fecha_inicio;
        $contrato->fecha_fin        =   $request->fecha_fin;
        $contrato->sueldo           =   $request->sueldo;
        $contrato->periodo_pago     =   $request->periodo_pago;
        $contrato->empleado_id      =   $id->id;
        $contrato->estado           =   1;
        $contrato->datoslaborales_id = $id_DL->id;
        $contrato->save();
        return redirect()->route('manageNomina-A')->with('message', 'Empleado registrado con exito!.');
        
        
    }

    public function storeBanco(Request $request)
    {
        # code...
        //dd($request->all());
        $banco = new Bancog();
        $banco->banco = $request->bancoN;
        $banco->save();
        return back()->with('message', 'Banco registrado con exito');
    }
























    public function editar($id){
        /*$aportes = Aporte::all();
        $empleado=Datoslaborales::find($id);
        $paises = Pais::orderBy('paisnombre','asc')->get();
        $empresas = Empresa::orderBy('id','desc')->get();
        $opciones = Datoscargados::orderBy('id','desc')->get();
        $contratos = Contrato::where('empleado_id',$empleado->empleado_id)->where('estado',0)->get();
        return view('nomina.formularios.editar')->with('empresas',$empresas)->with('opciones',$opciones)->with('paises',$paises)->with('empleado',$empleado)->with('contratos',$contratos)->with('aportes',$aportes);*/
        //$empleado = Contrato::find($id)->first();
        //$empleado = Contrato::find($id);
        //$empleado = Empleado::find($id)->first();
        $empleado = Empleado::with('datoslaborales.contrato')->where('id', $id)->first();
        //dd($empleado);
        $paises = Pais::orderBy('paisnombre','asc')->get();//preguntar por este campo
        $empresas = Empresa::orderBy('id','desc')->get();
        $opciones = Datoscargados::orderBy('id','desc')->get();
        $aportes = Aporte::all();
        $contratos = Contrato::where('empleado_id',$id)->where('estado',0)->get();
        //dd($empleado->datoslaborales->empleado->nombres);
        return view('nomina.formularios.editar', compact('empleado', 'paises', 'empresas', 'opciones', 'aportes', 'contratos'));
    }
    public function contrato($id){
       /* //$contrato=Contrato::find($id)->get();
        $empleado = Empleado::find($id)->first();
        //dd($empleado->id);
        //$empleado = Contrato::find($id); 
        //dd($empleado->empleado_id);
        //$contrato = Contrato::where('empleado_id',$empleado->id)->where('estado',1)->get();
        $contrato = Contrato::where('empleado_id',$id)->where('estado',1)->get();
        //$contrato = Datoslaborales::where('empleado_id',$id)->where('estado',1)->get();
        //dd($contrato[0]->empresa);
        //dd($contrato->empleado->nombres);
        return view('nomina.contrato', compact('empleado'))->with('contrato');*/

        //dd($id);
        $empleado = Empleado::with('datoslaborales.contrato')->where('id', $id)->first();
        //dd($empleado->nombres);
        //dd($empleado->datoslaborales[0]->numero_cuenta);
        return view('nomina.contrato', compact('empleado'));

    }
    public function contratoPdf($id){
        //$contrato=Datoslaborales::find($id);
        $contrato = Empleado::with('datoslaborales.contrato')->where('id', $id)->first();
        //dd($contrato);
        $view =  \View::make('nomina.pdf.contratoPdf')->with('contrato',$contrato)->render();
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($view)->setPaper('legal', 'horizontal');
        return $pdf->stream($contrato->nombres.'.pdf');
    }
    public function reciboPdf($id,$mes,$anio){
        $apf_opciones=Aporte::all();
        $aportes=OtrosAportes::all();
        $empleado=Datoslaborales::find($id);
        $adelantos=Adelanto::whereMonth('fecha', '=', $mes)->whereYear('fecha', '=', $anio)->get();
        $view =  \View::make('nomina.recibo')->with('empleado',$empleado)->with('adelantos',$adelantos)->with('mes',$mes)->with('anio',$anio)->with('apf_opciones',$apf_opciones)->with('aportes',$aportes);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream($empleado->empleado->nombres.'.pdf');
    }
    public function nuevoContrato(Request $data){
        //buscamos los datos del empleado
        $datos=Datoslaborales::find($data->contrato_id);
        //desactivamos el contrato viejo
        $viejo=Contrato::find($datos->contrato_id);
        $viejo->estado=0;
        $viejo->save();
        //creamos su nuevo contrato
        $contrato=new Contrato();
        $contrato->fecha_inicio=$data->fecha_inicio;
        $contrato->fecha_fin=$data->fecha_fin;
        $contrato->sueldo=$data->sueldo;
        $contrato->periodo_pago=$data->periodo_pago;
        $contrato->empleado_id=$datos->empleado_id;
        $contrato->estado=1;
        $contrato->save();
        //asignamos el nuevo contrato a sus datos laborales
        $id=Contrato::orderBy('id','desc')->first();
        $datos->contrato_id=$id->id;
        $datos->save();
        return redirect()->route('manageNomina-A');
    }
    public function GenerarNomina(Request $data){
        //$nomina=Datoslaborales::all();
        $nomina = Empleado::with('datoslaborales.contrato')->get();
        //dd($nomina);
        $apf_opciones=Aporte::all();
        $aportes=OtrosAportes::all();
        $adelantos=Adelanto::whereMonth('fecha','=',$data->mes)->whereYear('fecha','=',$data->anio)->get();
        $faltas=Inasistencia::whereMonth('fecha','=',$data->mes)->whereYear('fecha','=',$data->anio)->get();
        return view ('nomina.generarNomina')->with('nomina',$nomina)->with('aportes',$aportes)->with('apf_opciones',$apf_opciones)->with('adelantos',$adelantos)->with('faltas',$faltas)->with('mes',$data->mes)->with('anio',$data->anio);
    }
    public function store(Request $data){
	    //dd($data);
        $destino = 'uploads/empleados';
        $imagen = $data->file('image');
        $random = str_random(6);
        if (!empty($imagen)) {
            $nombreImagen = $data->cedula.$random.$imagen->getClientOriginalName();
            $imagen->move($destino,$nombreImagen);
        }else{
            $nombreImagen = 'user_default.png';
        }
        $empleado = new Empleado();
        $empleado->foto = $nombreImagen;
        $empleado->nombres=    $data->nombres;
        $empleado->apellidos=    $data->apellidos;
        $empleado->documento=    $data->documento;
        $empleado->email=    $data->email;
        $empleado->telefono_local=    $data->telefono_local;
        $empleado->telefono_celular=    $data->telefono_celular;
        $empleado->direccion=    $data->direccion;
        $empleado->fecha_nacimiento=    $data->fecha_nacimiento;
        $empleado->estado_civil=    $data->estado_civil;
        $empleado->pais=    $data->pais;
        $empleado->hijos=    $data->hijos;
        $empleado->save();

        $contrato=new Contrato();
        $id=Empleado::orderBy('id','desc')->first();
        $contrato->fecha_inicio=$data->fecha_inicio;
        $contrato->fecha_fin=$data->fecha_fin;
        $contrato->sueldo=$data->sueldo;
        $contrato->periodo_pago=$data->periodo_pago;
        $contrato->empleado_id=$id->id;
        $contrato->estado=1;
        $contrato->save();

        $datoslaborales = new Datoslaborales();
        $id=Empleado::orderBy('id','desc')->first();
        $id_c=Contrato::orderBy('id','desc')->first();
        $datoslaborales->empleado_id= $id->id;
        $datoslaborales->contrato_id= $id_c->id;
        $datoslaborales->fecha_ingreso= $data->fecha_ingreso;
        $datoslaborales->empresa= $data->empresa;
        $datoslaborales->tipo_empleado= $data->tipo_empleado;
        $datoslaborales->turno= $data->turno;
        $datoslaborales->ocupacion= $data->ocupacion;
        $datoslaborales->forma_pago= $data->forma_pago;
        $datoslaborales->tipo_moneda= $data->tipo_moneda;
        $datoslaborales->categoria_ocupacional= $data->categoria_ocupacional;
        $datoslaborales->cargo= $data->cargo;
        $datoslaborales->banco= $data->banco;
        $datoslaborales->seguro= $data->seguro;
        $datoslaborales->estado=1;
        $datoslaborales->numero_cuenta= $data->numero_cuenta;
        $datoslaborales->vencimiento= $id_c->fecha_fin;
        $datoslaborales->apf= $data->apf;
        $datoslaborales->salud= $data->salud;
        $datoslaborales->save();

        return redirect()->route('manageNomina-A');
    }
    public function update(Request $data){
        $imagen = $data->file('image');
        if (!empty($imagen)) {
            $destino = 'uploads/empleados';
            $imagen = $data->file('image');
            $random = str_random(6);
            $nombreImagen = $data->cedula.$random.$imagen->getClientOriginalName();
            $imagen->move($destino,$nombreImagen);
            $empleado =Empleado::find($data->empleado_id);
            $empleado->foto = $nombreImagen;
        }else{
            $empleado =Empleado::find($data->empleado_id);
        }

        $empleado->nombres=    $data->nombres;
        $empleado->apellidos=    $data->apellidos;
        $empleado->documento=    $data->documento;
        $empleado->email=    $data->email;
        $empleado->telefono_local=    $data->telefono_local;
        $empleado->telefono_celular=    $data->telefono_celular;
        $empleado->direccion=    $data->direccion;
        $empleado->fecha_nacimiento=    $data->fecha_nacimiento;
        $empleado->estado_civil=    $data->estado_civil;
        $empleado->pais=    $data->pais;
        $empleado->hijos=    $data->hijos;
        $empleado->save();

        $contrato=Contrato::find($data->contrato_id);
        $contrato->fecha_inicio=$data->fecha_inicio;
        $contrato->fecha_fin=$data->fecha_fin;
        $contrato->sueldo=$data->sueldo;
        $contrato->periodo_pago=$data->periodo_pago;
        $contrato->save();

        $datoslaborales = Datoslaborales::find($data->id);
        $datoslaborales->fecha_ingreso= $data->fecha_ingreso;
        $datoslaborales->empresa= $data->empresa;
        $datoslaborales->tipo_empleado= $data->tipo_empleado;
        $datoslaborales->turno= $data->turno;
        $datoslaborales->ocupacion= $data->ocupacion;
        $datoslaborales->forma_pago= $data->forma_pago;
        $datoslaborales->tipo_moneda= $data->tipo_moneda;
        $datoslaborales->categoria_ocupacional= $data->categoria_ocupacional;
        $datoslaborales->cargo= $data->cargo;
        $datoslaborales->banco= $data->banco;
        $datoslaborales->seguro= $data->seguro;
        $datoslaborales->estado=1;
        $datoslaborales->apf= $data->apf;
        $datoslaborales->salud= $data->salud;
        $datoslaborales->numero_cuenta= $data->numero_cuenta;
        $datoslaborales->save();

        return redirect()->route('manageNomina-A');
    }
    public function delete($id){
        $empleado=Empleado::find($id);
        $inasistencias=Inasistencia::where('empleado_id',$id)->get();
        $datoslaborales=Datoslaborales::where('empleado_id',$id)->get();
        $contratos=Contrato::where('empleado_id',$id)->get();
        foreach($inasistencias as $fila){
            $fila->delete();
        }
        foreach($datoslaborales as $fila){
            $fila->delete();
        }
        foreach($contratos as $fila){
            $fila->delete();
        }
        $empleado->delete();
        return redirect()->route('manageNomina-A');
    }

}
