<?php 

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Role;
use App\Email;
use App\Empresa;
use App\Operador;
use App\Cotizacion;
use Illuminate\Http\Request;
use App\Pagina\PaginaDestino;
use App\Pagina\PaginaPeruano;
use App\Pagina\PaginaServicio;
use App\Pagina\PaginaComunidad;
use App\Pagina\PaginaActividad;
use App\Pagina\PaginaExtranjero;
use App\Pagina\PaginaActividadServicio;
use App\Pagina\PaginaCategoriaOperador;
use Yajra\Datatables\Facades\Datatables;
class OperadorController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function getManageOperador(){
        $operadores = Operador::all();
        $operadores->load('servicios');
        //dd(count($operadores[1]->servicios));
        $tipos = PaginaCategoriaOperador::all();
        $empresas = Empresa::all();
        $destinos = PaginaDestino::all();
        $emails = Email::all();
        /*$emails = "" ;
        foreach ($operador->emails as $key => $email) {
            if ($key == 0) {
                $emails = $email->nombre;
            } else {
                $emails = $emails.",".$email->nombre;
            }
            
        }*/
        return view('operadores.index', compact('operadores', 'tipos', 'empresas', 'destinos',"emails"));
    }

    public function create(){
        $empresas = Empresa::all();
        $tipos = PaginaCategoriaOperador::all();
        $destinos = PaginaDestino::all();
        //dd($destinos);
        return view('operadores.create',  compact('empresas','tipos', 'destinos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $data){
        $emails = explode(",",$data->email);
        /* dd($emails); */
        $nuevo = new Operador();
        $nuevo->empresas_id=$data->empresa;
        $nuevo->nombre=$data->nombre;
        $nuevo->rif=$data->rif;
        $nuevo->direccion=$data->direccion;
        $nuevo->telefono=$data->telefono;
        /* $nuevo->email=$data->email; */
        $nuevo->web=$data->web;
        $nuevo->categoria_id=$data->tipo;
        $nuevo->destino_id=$data->destino;
        $nuevo->save();

        foreach ($emails as $index => $email) {
            $new_email              = new Email();
            $new_email->nombre       = $email;
            $new_email->operador_id = $nuevo->id;
            $new_email->save();
        }
        $info = $nuevo ? 'Se ha registrado el operador "'. $data->nombre .'" de forma exitosa.!.' : 'Error al Editar';
        return redirect()->route('manageOperador-A')->with('info', $info);
    }

    public function edit($id){

        $operador = Operador::findOrFail($id);
        $empresas = Empresa::all();
        $tipos = PaginaCategoriaOperador::all();
        $destinos = PaginaDestino::all();
        //$emails = Email::where('operador_id', $operador->id);
        //$emails = Email::all();
        //dd($emails);
        $emails = "" ;
        foreach ($operador->emails as $key => $email) {
            if ($key == 0) {
                $emails = $email->nombre;
            } else {
                $emails = $emails.",".$email->nombre;
            }
            
        }
        /*foreach ($operador->emails as $key => $email) {
            //dd($key, $email);
            if ($key == 0) {
                $emails = $email->nombre;
                //dd($emails);
            } else {
                $emails = $emails.",".$email->nombre;
                //dd($emails);
            }
        }*/
        
        //return view('operadores.edit', compact('operador', 'empresas', 'tipos', 'destinos',"emails"));
        return ['operador' => $operador, 'empresas' => $empresas, 'tipos'=>$tipos, 'destinos'=>$destinos, 'emails' => $emails];
    }

    public function update(Request $data, $id){ 
        //dd($data->all());
        $emails = explode(",",$data->email);
        $operador = Operador::find($id);
       
        $operador->empresas_id=$data->empresa;
        $operador->nombre=$data->nombre;
        $operador->rif=$data->rif;
        $operador->direccion=$data->direccion;
        $operador->telefono=$data->telefono;
        /* $operador->email=$data->email; */
        $operador->web=$data->web;
        if($data->tipo != '' or $data->tipo != null):
            $operador->categoria_id=$data->tipo;
        endif;
        if($data->destino != '' or $data->destino != null):
            $operador->destino_id=$data->destino;
        endif;
        $operador->save();
        //verifico los dos array
        foreach ($emails as $email) {
            $emails_removed = $operador->emails; 
            
            if (!$operador->emails->contains("nombre",$email)) {
                $new_email              = new Email();
                $new_email->nombre       = $email;
                $new_email->operador_id = $id;
                $new_email->save();
            } 
        }
        //elimino lode que no esten 
        foreach($operador->emails->whereNotIn("nombre",$emails) as $email_not){
            $aux_email = Email::find($email_not->id);
            $aux_email->delete();
        }
         $info = $nuevo ? 'Se ha actualizado el operador "'. $data->nombre .'" de forma exitosa.!.' : 'Error al Editar';
        return redirect()->route('manageOperador-A')->with('info', $info);
    }

    public function status(Request $request, $id){

        $operadores = User::where('id','=', $id)->first();
        if ($operadores->active == '0'){
            $operadores= Operador::find($id);
            $operadores = User::where('id','=', $id)->first();
            $operadores->active   = "1";
            $operadores->save();
            $message = $operadores?'Se ha actualizado el registro'. $request->nombres .' '. $request->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageOperador-A')->with('message', $message);
        }else {
            if ($operadores->active == '1')
                $operadores = User::find($id);
            $operadores = User::where('id', '=', $id)->first();
            $operadores->active = "0";
            $operadores->save();
            $message = $operadores ? 'Se ha actualizado el registro' . $request->nombres . ' ' . $request->apellidos . ', se Desabilito de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageOperador-A')->with('message', $message);
        }
    }

    public function show($id){
        $operadores = Operador::all()->lists('name', 'id');
        return view('operadores.show');

    }

    public function tool($servicio) {
        //dd('llego a tool');
        if (count($servicio->actividades) > 0) { // verificamos si el servicio posee actividades asociadas
            $actividadSevicios = PaginaActividadServicio::where('servicio_id', $servicio->id)->get();
            foreach($actividadSevicios as $actividadSevicio) { // cargamos cada actividad asociada
                $actividad = PaginaActividad::where('id', $actividadSevicio->actividad_id)->first();
                    $actividad->delete();
                    $actividadSevicio->delete();
            }
        }
        if ($servicio->peruano != null) {
            $peruano = PaginaPeruano::find($servicio->peruano_id);
            $peruano->delete();
        }
        if ($servicio->comunidad != null) {
            $comunidad = PaginaComunidad::find($servicio->comunidad_id);
            $comunidad->delete();
        }
        if ($servicio->extranjero != null) {
            $extranjero = PaginaExtranjero::find($servicio->extranjero_id);
            $extranjero->delete();
        }
        $servicio->delete();
    }

    public function deleteOperador(Operador $operador) {
       //$operador = Operador::find($operador->id);
       //$operador->load('servicios');
        $servicios = PaginaServicio::where('operador_id', $operador->id)->get();
        $servicios->load('actividades', 'peruano', 'comunidad', 'extranjero');
        if (count($operador->servicios) > 0) {
            foreach ($servicios as $servicio) {
                //dd($servicio);
                $this->tool($servicio);
            }
        }
        $operador->delete();
        $message = $operador ?'Registro eliminado correctamente' : 'Error al Eliminar';
        return redirect()->route('manageOperador-A')->with('message', $message);
   }

    public function servicios($id){
        $operador= Operador::find($id);
        $operador->servicios->load('peruano', 'comunidad', 'extranjero');
        return view('operadores.servicios.index')->with('operador', $operador);
    }

public function serviciosStore(Request $data){
    $peruano=new PaginaPeruano();
    $peruano->adulto=$data->p_adulto;
    $peruano->estudiante=$data->p_estudiante;
    $peruano->ninio=$data->p_ninio;
    $peruano->save();
 
    $comunidad=new PaginaComunidad();
    $comunidad->adulto=$data->c_adulto;
    $comunidad->estudiante=$data->c_estudiante;
    $comunidad->save();

    $extranjero=new PaginaExtranjero();
    $extranjero->adulto=$data->e_adulto;
    $extranjero->estudiante=$data->e_estudiante;
    $extranjero->ninio=$data->e_ninio;
    $extranjero->save();

    $servicio=new PaginaServicio();
    $servicio->nombre=$data->nombre;
    $servicio->operador_id=$data->operador;
    $servicio->peruano_id=$peruano->id;
    $servicio->comunidad_id=$comunidad->id;
    $servicio->extranjero_id=$extranjero->id;
    $servicio->save();

    return redirect()->action('OperadorController@servicios', [$data->operador]);        

}

    public function serviciosDestroy($id,$operador){
        $servicio = PaginaServicio::find($id);
        $this->tool($servicio);
        return redirect()->route('manageOperador-servicios-A', $operador);        
    }

public function serviciosUpdated(Request $data){

    $servicio=PaginaServicio::find($data->servicio);
    
    $servicio->nombre=$data->nombre;
    $servicio->save();

    $servicio->peruano->adulto=$data->p_adulto;
    $servicio->peruano->estudiante=$data->p_estudiante;
    $servicio->peruano->ninio=$data->p_ninio;
    $servicio->peruano->save();

    $servicio->extranjero->adulto=$data->e_adulto;
    $servicio->extranjero->estudiante=$data->e_estudiante;
    $servicio->extranjero->ninio=$data->e_ninio;
    $servicio->extranjero->save();

    $servicio->comunidad->adulto=$data->c_adulto;
    $servicio->comunidad->estudiante=$data->c_estudiante;
    $servicio->comunidad->save();

    return redirect()->action('OperadorController@servicios', [$servicio->operador->id]);        
}

    public function destroyCategoria(PaginaCategoriaOperador $categoria) {
        foreach ($categoria->operadores as $operador) {
            $operador = Operador::find($operador->id);
            //$operador->load('servicios');
            $servicios = PaginaServicio::where('operador_id', $operador->id)->get();
            $servicios->load('actividades', 'peruano', 'comunidad', 'extranjero');
            if (count($operador->servicios) > 0) {
                foreach ($servicios as $servicio) {
                    //dd($servicio);
                    $this->tool($servicio);
                }
            }
            $operador->delete();
        }
        $categoria->delete();
        $message = $categoria ?'Registro eliminado correctamente' : 'Error al Eliminar';
        return redirect()->route('manageOperador-A')->with('message', $message);
        //dd($categoria);
    }

}
