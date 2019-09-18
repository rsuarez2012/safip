<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Userweb;
use App\Agente;
use App\Empresa;
use App\Sucursal;
use App\Role;
use App\Pais;
use App\Ciudad;
use App\Paquete;
use App\Destination;
use Auth;
use Mail;
use App\PaqueteFecha;
use App\PaqueteIncluido;
use App\PaqueteItinerario;
use App\PaqueteNoIncluido;
use App\PaqueteNota;
use App\PaqueteRecomendacion;
use App\PaqueteReserva;
use App\PaqueteResponsabilidad;
use App\PaqueteTarifa;
use App\PaqueteTarifaPersona;
use App\ReservaPaquete;
use App\ReservaPasajero;
class PaginaWebController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }

    public function getManageExternalPage()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        $products= Paquete::where('destacado','=','1')
        ->where('visible','=','1')
        ->where('categoria','=','salidas_confirmadas')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        $products_featured= Paquete::where('destacado','=','1')
        ->where('visible','=','1')
        ->where('categoria','!=','salidas_confirmadas')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('paginaexterna.center.index', compact('paises', 'ciudades'))->with('products_featured',$products_featured)->with('products',$products);
    }
    public function detallepaquete($id)
    { 
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        $product= Paquete::find($id);
        $Itinerary= PaqueteItinerario::where('paquete_id','=', $id)->get();
        $Includes= PaqueteIncluido::where('paquete_id','=', $id)->get();
        $Not_include= PaqueteNoIncluido::where('paquete_id','=', $id)->get();
        $Recommendations_to_carry= PaqueteRecomendacion::where('paquete_id','=', $id)->get();
        $Important_note= PaqueteNota::where('paquete_id','=', $id)->get();
        $Reservation_polices= PaqueteReserva::where('paquete_id','=', $id)->get();
        $Polices_of_our_rates= PaqueteTarifa::where('paquete_id','=', $id)->get();
        $Special_dates= PaqueteFecha::where('paquete_id','=', $id)->get();
        $Resposanbilities= PaqueteResponsabilidad::where('paquete_id','=', $id)->get();
        $PaquetePersonas= PaqueteTarifaPersona::where('paquete_id','=',$id)->get();
        //$RatesPerson= paquete::where('products_id','=', $id)->get();
        return view('paginaexterna.detalle_paquete.paquete_detalle',
            compact('Resposanbilities','Special_dates','Polices_of_our_rates',
                'Reservation_polices','Important_note','Recommendations_to_carry',
                'Not_include','Includes','Itinerary','paises',
                'ciudades', 'usuarios','product','PaquetePersonas'));
        //'RatesPerson',
    }
    public function detallepaquete_reserva(Request $request)
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        $id=$request->paquete_id;
        $paquete=Paquete::find($id);
        $Itinerary= PaqueteItinerario::where('paquete_id','=', $id)->get();
        $Includes= PaqueteIncluido::where('paquete_id','=', $id)->get();
        $Not_include= PaqueteNoIncluido::where('paquete_id','=', $id)->get();
        $Recommendations_to_carry= PaqueteRecomendacion::where('paquete_id','=', $id)->get();
        $Important_note= PaqueteNota::where('paquete_id','=', $id)->get();
        $Reservation_polices= PaqueteReserva::where('paquete_id','=', $id)->get();
        $Polices_of_our_rates= PaqueteTarifa::where('paquete_id','=', $id)->get();
        $Special_dates= PaqueteFecha::where('paquete_id','=', $id)->get();
        $Resposanbilities= PaqueteResponsabilidad::where('paquete_id','=', $id)->get();
        return view('paginaexterna.detalle_paquete.reserva_detalle',compact('Resposanbilities','Special_dates','Polices_of_our_rates',
            'Reservation_polices','Important_note','Recommendations_to_carry',
            'Not_include','Includes','Itinerary','paises',
            'ciudades', 'usuarios','paquete'));
    }

    public function store2 (Request $data){
        //dd($data);
        $nuevo = new ReservaPaquete();
        $nuevo->paquete_id=$data->paquete_id;
        $nuevo->usuario_id=Auth::User()->id;
        $nuevo->nombre=$data->text_cnombre;
        $nuevo->apellido=$data->text_capellido;
        $nuevo->correo=$data->text_ccorreo;
        $nuevo->telefono=$data->text_ctelefono;
        $nuevo->documento=$data->select_ctipodoc;
        $nuevo->documento_num=$data->text_cnumdoc;
        $nuevo->confirma=$data->cb_confirma;
        $nuevo->save();

        $ultimo = ReservaPaquete::orderBy('id','desc')->first();

        for ($i=0; $i < count($data->nombret) ; $i++) { 
            $pasajero = new ReservaPasajero();
            $pasajero->reserva_id=$ultimo->id;
            $pasajero->nombre=$data->nombret[$i];
            $pasajero->apellido=$data->apellidot[$i];
            $pasajero->correo=$data->correot[$i];
            $pasajero->telefono=$data->numero_de_telefonot[$i];
            $pasajero->documento=$data->tipo_documentot[$i];
            $pasajero->documento_num=$data->numerot[$i];
            $pasajero->save();
        }

        $paises = Pais::all();
        $ciudades = Ciudad::all();
        $paquete = Paquete::find($ultimo->paquete_id);
        $informacion = PaqueteIncluido::where('paquete_id','=',$paquete->id)->get();
        return view('paginaexterna.detalle_paquete.reserva_final',compact('paises','ciudades'))->with('paquete',$paquete)->with('informacion',$informacion)->with('nuevo',$nuevo);
    }
//-----------------filtros de paquetes por categorias--------------------
    public function general_packages()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        $paquetes = Paquete::where('categoria','!=','salidas_confirmadas')->get();
        $destinos = Destination::all();
        $tarifas = PaqueteTarifaPersona::orderBy('paquete_id')->get();
        return view('paginaexterna.general_packages.index', compact('tarifas','paises', 'ciudades', 'paquetes','destinos'));
    }
    public function paquetes_nacionales (){
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        $paquetes = Paquete::where('categoria','=','norte')
        ->orWhere('categoria','=','sur')
        ->orWhere('categoria','=','centro')->get();
        $destinos = Destination::all();
        return view('paginaexterna.general_packages.index', compact('paises', 'ciudades', 'paquetes','destinos'));
    }
    public function paquetes_nacionales_norte (){
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        $paquetes = Paquete::where('categoria','=','norte')->get();
        $destinos = Destination::all();
        return view('paginaexterna.general_packages.index', compact('paises', 'ciudades', 'paquetes','destinos'));
    }
    public function paquetes_nacionales_sur (){
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        $paquetes = Paquete::where('categoria','=','sur')->get();
        $destinos = Destination::all();
        return view('paginaexterna.general_packages.index', compact('paises', 'ciudades', 'paquetes','destinos'));
    }
    public function paquetes_nacionales_centro (){
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        $paquetes = Paquete::where('categoria','=','centro')->get();
        $destinos = Destination::all();
        return view('paginaexterna.general_packages.index', compact('paises', 'ciudades', 'paquetes','destinos'));
    }
    public function paquetes_internacionales (){
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        $paquetes = Paquete::where('categoria','=','internacional')->get();
        $destinos = Destination::all();
        return view('paginaexterna.general_packages.index', compact('paises', 'ciudades', 'paquetes','destinos'));
    }
    public function paquetes_luna_miel (){
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        $paquetes = Paquete::where('categoria','=','luna_miel')->get();
        $destinos = Destination::all();
        return view('paginaexterna.general_packages.index', compact('paises', 'ciudades', 'paquetes','destinos'));
    }
//----------------final de filtros---------------------------------------
    public function MyAcount()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        $id = Auth::User()->id;
        $usuarios = User::where('id', '=', $id)->first();
        $reservas = ReservaPaquete::where('usuario_id','=',$id)->get();
        return view('paginaexterna.micuenta.micuenta', compact('paises', 'ciudades', 'usuarios','reservas'));

    }
//----------------login---------------------------------------------------
    public function store(Request $request)
    {
        //dd($request->all());
        $cap=$request["g-recaptcha-response"];
        if (!empty($cap)) {
            if ($request->t_u == 2) {
                $existe_email = User::where('email', '=', $request->email)->get();
                if (count($existe_email) == 0) {
                    if ($request->password == $request->confpassword) {
                        $destination = 'uploads/usuarios/';
                        $image = $request->file('image');
                        $random = str_random(6);
                        if (!empty($image)) {
                            $filename = $request->cedula . $random . $image->getClientOriginalName();
                            $image->move($destination, $filename);
                        } else {
                            $filename = 'user_default.png';
                        }
                        $user = new User();
                        $user->role_id = "2";
                        $user->role = "Cliente";
                        $user->apellidos = $request->apellidos;
                        $user->nombres = $request->nombres;
                        $user->cedula = $request->cedula;
                        $user->email = $request->email;
                        $user->active = '1';
                        $user->password = bcrypt($request->password);
                        $user->pais_id = $request->pais;
                        $user->ciudad_id = $request->ciudad;
                        $user->direccion = $request->direccion;
                        $user->telefono = $request->telefono;
                        $user->imagen = $filename;
                        $user->type_user = '2';
                        $user->save();
                        //return view('welcome');
                        $message = $user ? 'Se ha registrado el usuario' . $request->nombres . ' ' . $request->apellidos . 'de forma exitosa.' : 'Error al Registrar';
                        $email = $request->email;
                        $password = $request->password;
                        //Session::flash('message', 'Te has registrado exitosamente ');
                        return redirect()->route('login2', compact('email', 'password'))->with('message', $message);
                    } else {
                        $message2 = 'El Password no es ingual en los dos campos';
                        return redirect()->back()->with('message2', $message2);
                    }
                } else {

                    $message2 = 'Este email ya se encuentra registrado';
                    return redirect()->route('indexweb')->with('message2', $message2);
                }
            }
            if ($request->t_u == 3) {
                $existe_email = User::where('email', '=', $request->email)->get();
                if (count($existe_email) == 0) {
                    if ($request->password == $request->confpassword) {
                        $destination = 'uploads/usuarios/';
                        $image = $request->file('image');
                        $random = str_random(6);
                        if (!empty($image)) {
                            $filename = $request->cedula . $random . $image->getClientOriginalName();
                            $image->move($destination, $filename);
                        } else {
                            $filename = 'user_default.png';
                        }
                        $user = new User();
                        $user->razon_social= $request->razon_social;
                        $user->representante_legal = $request->representante_legal;
                        $user->distrito= $request->distrito;
                        $user->aniversario=$request->aniversario;
                        $user->sitio_web=$request->sitio_web;
                        $user->telefono_corporativo=$request->telefono_corporativo;
                        $user->role_id = "2";
                        $user->role = "Agencia";
                        $user->nombres = $request->nombres;
                        $user->cedula = $request->cedula;
                        $user->email = $request->email;
                        $user->active = '0';
                        $user->password = bcrypt($request->password);
                        $user->pais_id = $request->pais;
                        $user->ciudad_id = $request->ciudad;
                        $user->direccion = $request->direccion;
                        $user->telefono = $request->telefono;
                        $user->imagen = $filename;
                        $user->type_user = '2';
                        $user->save();
                        //return view('welcome');
                        $message = $user ? 'Se ha registrado la Nueva Agencia de viajes' . $request->nombres . 'de forma exitosa, debe esperar a ser admitido por un administrador!!.' : 'Error al Registrar';
                        //Session::flash('message', 'Te has registrado exitosamente ');
                        return redirect()->route('indexweb')->with('message', $message);
                    } else {
                        $message2 = 'El Password no es ingual en los dos campos';
                        return redirect()->back()->with('message2', $message2);
                    }
                } else {
                    $message2 = 'Este email ya se encuentra registrado';
                    return redirect()->route('indexweb')->with('message2', $message2);
                }
            }

        }else{
            $message2 = 'Debe Validar el ReCaptcha Antes de Continuar';
            return redirect()->back()->with('message2', $message2);
        }
    }    
}