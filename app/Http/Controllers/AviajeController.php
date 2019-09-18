<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Aviaje;
use App\Empresa;
use App\Role;
use App\Cotizacion;
use Auth;
use Mail;

class AviajeController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function getManageAviaje(){

        $viajes = Aviaje::orderBy('id', 'desc')->get();

        return view('aviajes.index')->with('viajes',$viajes);

    }

    public function create(){
        $empresas = Empresa::all();

        return view('aviajes.create',  compact('empresas'));
        //->with('clientes', $clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $existe_rif = Aviaje::where('rif', '=', $request->rif)->get();

        if (count($existe_rif) == 0) {

            $viajes = new Aviaje();
            $viajes->empresas_id  = $request->empresa;
            $viajes->nombre       = $request->nombre;
            $viajes->rif          = $request->rif;
            $viajes->direccion    = $request->direccion;
            $viajes->telefono     = $request->telefono;
            $viajes->email        = $request->email;
            $viajes->web          = $request->web;
            $viajes->descripcion  = $request->descripcion;
            $viajes->counter      = $request->counter;
            $viajes->users_id   = Auth::User()->id;
            $viajes->save();

                //return view('welcome');
            $message = $viajes ? 'Se ha registrado ' . $request->nombre .  'de forma exitosa.' : 'Error al Registrar';

                //Session::flash('message', 'Te has registrado exitosamente ');
            return redirect()->route('manageAviaje-A')->with('message', $message);


        } else {

            $message2 = 'Esta Aviaje ya se encuentra registrada';
            return redirect()->route('manageAviaje-A')->with('message2', $message2);

        }
    }

    public function edit($id){

        $viajes = Aviaje::where('id','=', $id)->first();
        $empresas = Empresa::all();
        return view('aviajes.edit')->with('viajes', $viajes)->with('empresas', $empresas);
    }

    public function update(Request $request, $id){

        $viajes= Aviaje::find($id);
        $viajes = Aviaje::where('id','=', $id)->first();
        $viajes->empresas_id  = $request->empresa;
        $viajes->nombre       = $request->nombre;
        $viajes->rif          = $request->rif;
        $viajes->direccion    = $request->direccion;
        $viajes->telefono     = $request->telefono;
        $viajes->email        = $request->email;
        $viajes->web          = $request->web;
        $viajes->descripcion  = $request->descripcion;
        $viajes->counter      = $request->counter;
        $viajes->updated_by   = Auth::User()->id;
        $viajes->save();

        $message = $viajes?'Se ha actualizado el registro '. $request->nombre .' de forma exitosa.' : 'Error al actualizar';

        return redirect()->route('manageAviaje-A')->with('message', $message);


    }

    public function status(Request $request, $id){

        $viajes = User::where('id','=', $id)->first();
        if ($viajes->active == '0'){
            $viajes= Aviaje::find($id);
            $viajes = User::where('id','=', $id)->first();
            $viajes->active   = "1";
            $viajes->save();
            $message = $viajes?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageAviaje-A')->with('message', $message);
        }else {
            if ($viajes->active == '1')
                $viajes = User::find($id);
            $viajes = User::where('id', '=', $id)->first();
            $viajes->active = "0";
            $viajes->save();
            $message = $viajes ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageAviaje-A')->with('message', $message);
        }
    }



    public function show($id){
        $viajes = Aviaje::all()->lists('name', 'id');

        return view('viajes.show');

    }


    public function destroy($id){

        $viajes = Aviaje::find($id);
        $buscar = Cotizacion::all()->where('aviajes_id','=',$id)->pluck('id');
        if (count($buscar) == 0){
           $viajes->delete($id);
           $message = $viajes?'Registro eliminado correctamente' : 'Error al Eliminar';
           return redirect()->route('manageAviaje-A')->with('message', $message);
       }else{
           $message2 = 'Este registro esta siendo usado y no se puede eliminar';
           return redirect()->route('manageAviaje-A')->with('message2', $message2);
       }
   }
// funciones nuevas 
   public function createdByCounter(Request $request)
   {
    $existe = Aviaje::where('rif',$request->rif)->first();
    if ($existe != null) {
        return "existe";
    } else {
     $agencia = new Aviaje();
     $agencia->empresas_id = $request->empresa;
     $agencia->nombre      = $request->nombre;
     $agencia->rif         = $request->rif;
     $agencia->direccion   = $request->direccion;
     $agencia->telefono    = $request->telefono;
     $agencia->email       = $request->email;
     $agencia->web         = $request->web;
     $agencia->descripcion = $request->descripcion;
     $agencia->counter     = Auth::User()->nombres . " " .Auth::User()->apellidos;
     $agencia->users_id    = Auth::id() ;
     $agencia->updated_by  = Auth::id() ;
     $agencia->status      = "espera";
     $agencia->save();
    // enviar email
     $fromEmail = 'qantutra@gmail.com';
     $fromName = 'Qantu Travel';
     $subject = 'Registro de agencia de viajes';
     $data = ['agencia' => $agencia];
     $toEmail = 'administrativo@qantutravel.com';
     /* $toEmail = 'joseangel26153290@gmail.com'; */
     $toName = 'Administrador Qantu Travel';
     Mail::send('aviajes.email_notificar_agencia', $data, function($message) use ($toEmail, $toName, $fromEmail, $fromName, $subject){
        $message->to($toEmail, $toName);
        $message->from($fromEmail, $fromName);
        $message->subject($subject);
    });
     return $agencia;
 }
}

public function cambiarEstado(Aviaje $agencia,$estado){
    $agencia->status = $estado;
    $agencia->update();
    $message = $agencia?'El estado de la agencia se cambio correctamente' : 'Error al Eliminar';
    return redirect()->route('manageAviaje-A')->with('message', $message);
}

}
