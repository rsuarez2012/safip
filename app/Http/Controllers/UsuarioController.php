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
use Auth;
class UsuarioController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function getManageUsuario(){

        $usuarios = User::where('type_user','=','1')->get();

        return view('usuarios.index')->with('usuarios',$usuarios);

    }
    public function create(){
        $roles = Role::all();
        $paises = Pais::all();
        $ciudades = Ciudad::orderBy('ciudadnombre')->get();
        $empresas = Empresa::all();
        $sucursales = Sucursal::all();
        return view('usuarios.create',  compact('roles','empresas','sucursales'))->with('paises',$paises)->with('ciudades',$ciudades);
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
        if($request->password == $request->confpassword) {
    /* $clientes = new Clientes();
     $clientes->nombre_cliente        = $request->nombre_cliente;
     $clientes->cedula_cliente        = $request->cedula_cliente;
     $clientes->email_cliente         = $request->email_cliente;
     $clientes->pais             	 = $request->pais;
     $clientes->ciudad           	 = $request->ciudad;
     $clientes->tlf_cliente           = $request->tlf_cliente;
     $clientes->save();*/
     $destination = 'uploads/usuarios/';
     $image = $request->file('image');
     $random = str_random(6);
     if (!empty($image)) {
        $filename = $request->cedula. $random.  $image->getClientOriginalName();
        $image->move($destination, $filename);
    }else{
        $filename = 'user.jpg';
    }
    $user = new User();
    $user->role_id = 1;
    $user->role = $request->role;
    $user->apellidos = $request->apellidos;
    $user->nombres = $request->nombres;
    $user->cedula = $request->cedula;
    $user->email = $request->email;
    $user->active = $request->active;
    $user->password = bcrypt($request->password);
    $user->pais_id = $request->pais;
    $user->ciudad_id = $request->ciudad;
    $user->direccion = $request->direccion;
    $user->telefono = $request->telefono;
    $user->imagen = $filename;
    $user->boletos = $request->boletos;
    $user->ncppagar = $request->ncppagar;
    $user->ancppagar = $request->ancppagar;
    $user->ncpcobrar = $request->ncpcobrar;
    $user->ancpcobrar = $request->ancpcobrar;
    $user->vboletos = $request->vboletos;
    $user->nomina=  $request->mnomina;
    $user->cclave = $request->cclave;
    $user->pconso = $request->pconso;
    $user->deuaviajes = $request->deuaviajes;
    $user->opb = $request->opb;
    $user->empresas_id  = $request->empresa_id;
    $user->sucursales_id  = $request->sucursal;
    $user->empresa=$request->empresa;
    $user->consolidadores=$request->consolidadores;
    $user->usuarios=$request->usuarios;
    $user->gastos=$request->gastos;
    $user->deudas= $request->deudas;
    $user->banco=$request->banco;
    $user->caja_chica=$request->caja_chica;
    $user->igv= $request->igv;
    $user->agentes= $request->agentes;
    $user->agencias_viajes=$request->agencias_viajes;
    $user->lineas_aereas= $request->lineas_aereas;
    $user->incentivos=$request->incentivos;
    $user->paises=$request->paises;
    $user->ciudades=$request->ciudades;
    $user->pasajeros=  $request->pasajeros;
    $user->comision= $request->comision;
    $user->operadores=    $request->operadores;
    $user->poperadores=$request->poperadores;
    $user->pdestinos=$request->pdestinos;
    $user->ppaquetes=$request->ppaquetes;
    $user->photeles=$request->photeles;
    $user->prestaurantes=$request->prestaurantes;
    $user->pcotizacion=$request->pcotizacion;
    $user->solicitudes=$request->solicitudes;
    $user->reservaciones=$request->reservaciones;
    $user->usuarios_web=$request->usuarios_web;
    $user->validar_boletos=$request->validar_boletos;
    $user->type_user = 1;
    $user->save();
    //return view('welcome');
    $message = $user ? 'Se ha registrado el usuario' . $request->nombres . ' ' . $request->apellidos . 'de forma exitosa.' : 'Error al Registrar';

    //Session::flash('message', 'Te has registrado exitosamente ');
    return redirect()->route('manageUsuario-A')->with('message', $message);
}else{
    $message2 = 'El Password no es ingual en los dos campos';
    return redirect()->back()->with('message2', $message2);
}
} else {

    $message2 = 'Este email ya se encuentra registrado';
    return redirect()->route('manageUsuario-A')->with('message2', $message2);
}
}


public function edit($id){
    $roles = Role::all();
    $usuarios = User::where('id','=', $id)->first();
    $paises = Pais::all();
    $ciudades = Ciudad::orderBy('ciudadnombre')->get();
    $empresas = Empresa::all();
    $sucursales = Sucursal::all();
    return view('usuarios.edit',compact('empresas','sucursales','roles'))->with('usuarios', $usuarios)->with('paises',$paises)->with('ciudades',$ciudades);
}
public function update(Request $request, $id){
    //dd($request->all());
    $destination = 'uploads/usuarios/';
    $image = $request->file('image');
    $random = str_random(6);
    if(empty($request->imagen2)) {
        if (!empty($image)) {
            $filename = $request->cedula . $random . $image->getClientOriginalName();
            $image->move($destination, $filename);
        } else {
            $filename = '';
        }
    }else{
        if (!empty($image)) {
            $filename = $request->cedula . $random . $image->getClientOriginalName();
            $image->move($destination, $filename);
        }
    }

    $user= User::find($id);
    $user = User::where('id','=', $id)->first();
    $user->apellidos = $request->apellidos;
    $user->nombres = $request->nombres;
    $user->cedula = $request->cedula;
    $user->email = $request->email;
    $user->pais_id = $request->pais;
    $user->ciudad_id = $request->ciudad;
    $user->direccion = $request->direccion;
    $user->telefono = $request->telefono;
    $user->role = $request->role;
    if ($request->role == "Administrador") {
        $this->tool_full_permisos($user);
    } else {

        $user->boletos = $request->boletos;
        $user->ncppagar = $request->ncppagar;
        $user->ancppagar = $request->ancppagar;
        $user->ncpcobrar = $request->ncpcobrar;
        $user->ancpcobrar = $request->ancpcobrar;
        $user->vboletos = $request->vboletos;
        $user->nomina = $request->mnomina;
        $user->cclave = $request->cclave;
        $user->pconso = $request->pconso;
        $user->deuaviajes = $request->deuaviajes;
        $user->opb = $request->opb;
        $user->empresas_id  = $request->empresa_id;
        $user->sucursales_id  = $request->sucursal;
        $user->empresa=$request->empresa;
        $user->consolidadores=$request->consolidadores;
        $user->usuarios=$request->usuarios;
        $user->gastos=$request->gastos;
        $user->deudas= $request->deudas;
        $user->banco=$request->banco;
        $user->caja_chica=$request->caja_chica;
        $user->igv= $request->igv;
        $user->agentes= $request->agentes;
        $user->agencias_viajes=$request->agencias_viajes;
        $user->lineas_aereas= $request->lineas_aereas;
        $user->incentivos=$request->incentivos;
        $user->paises=$request->paises;
        $user->ciudades=$request->ciudades;
        $user->pasajeros=  $request->pasajeros;
        $user->comision= $request->comision;
        $user->operadores=    $request->operadores;
        $user->poperadores=$request->poperadores;
        $user->pdestinos=$request->pdestinos;
        $user->ppaquetes=$request->ppaquetes;
        $user->photeles=$request->photeles;
        $user->prestaurantes=$request->prestaurantes;
        $user->pcotizacion=$request->pcotizacion;
        $user->solicitudes=$request->solicitudes;
        $user->reservaciones=$request->reservaciones;
        $user->usuarios_web=$request->usuarios_web;    
        $user->validar_boletos=$request->validar_boletos;
    }    
    if ($filename){
        $user->imagen = $filename;
    }
    $user->save();
    $message = $user?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .'de forma exitosa.' : 'Error al actualizar';
    return redirect()->route('manageUsuario-A')->with('message', $message);
}
public function status(Request $request, $id){
    $usuarios = User::where('id','=', $id)->first();
    if ($usuarios->active == '0'){
        $user= User::find($id);
        $user = User::where('id','=', $id)->first();
        $user->active   = "1";
        $user->save();
        $message = $user?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

        return redirect()->route('manageUsuario-A')->with('message', $message);
    }else {
        if ($usuarios->active == '1')
            $user = User::find($id);
        $user = User::where('id', '=', $id)->first();
        $user->active = "0";
        $user->save();
        $message = $user ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';

        return redirect()->route('manageUsuario-A')->with('message', $message);
    }
}
public function show($id){
    $user = User::all()->lists('name', 'id');

    return view('usuarios.show');
}
public function destroy($id){

    $user = User::find($id);
    $user->delete($id);
    $message = $user?'Registro eliminado correctamente' : 'Error al Eliminar';
    return redirect()->route('manageUsuario-A')->with('message', $message);

}
//tool para otorgar todos los permisos
public function tool_full_permisos($user){
    $user->boletos = 1;
    $user->ncppagar = 1;
    $user->ancppagar = 1;
    $user->ncpcobrar = 1;
    $user->ancpcobrar = 1;
    $user->vboletos = 1;
    $user->nomina = 1;
    $user->cclave = 1;
    $user->pconso = 1;
    $user->deuaviajes = 1;
    $user->opb = 1;
    $user->empresas_id  = 1;
    $user->sucursales_id  = 1;
    $user->empresa=1;
    $user->consolidadores=1;
    $user->usuarios=1;
    $user->gastos=1;
    $user->deudas= 1;
    $user->banco=1;
    $user->caja_chica=1;
    $user->igv= 1;
    $user->agentes= 1;
    $user->agencias_viajes=1;
    $user->lineas_aereas= 1;
    $user->incentivos=1;
    $user->paises=1;
    $user->ciudades=1;
    $user->pasajeros=  1;
    $user->comision= 1;
    $user->operadores=    1;
    $user->poperadores=1;
    $user->pdestinos=1;
    $user->ppaquetes=1;
    $user->photeles=1;
    $user->prestaurantes=1;
    $user->pcotizacion=1;
    $user->solicitudes=1;
    $user->reservaciones=1;
    $user->usuarios_web=1;
    $user->validar_boletos=1;
}
}
