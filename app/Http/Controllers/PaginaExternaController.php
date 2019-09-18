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
use App\Product;
use App\Itinerary;
use App\Important_note;
use App\Includes;
use App\Not_include;
use App\Polices_of_our_rates;
use App\Recommendations_to_carry;
use App\Reservation_polices;
use App\Resposanbilities;
use App\Special_dates;
use App\RatesPerson;
use Auth; 
use Mail;
class PaginaExternaController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    } 

    public function general_packages()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        return view('paginaexterna.general_packages.index', compact('paises', 'ciudades', 'usuarios'));

    }

    public function detallepaquete($id)
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        $product= Product::where('id','=', $id)->first();
        $Itinerary= Itinerary::where('products_id','=', $id)->get();
        $Includes= Includes::where('products_id','=', $id)->get();
        $Not_include= Not_include::where('products_id','=', $id)->get();
        $Recommendations_to_carry= Recommendations_to_carry::where('products_id','=', $id)->get();
        $Important_note= Important_note::where('products_id','=', $id)->get();
        $Reservation_polices= Reservation_polices::where('products_id','=', $id)->get();
        $Polices_of_our_rates= Polices_of_our_rates::where('products_id','=', $id)->get();
        $Special_dates= Special_dates::where('products_id','=', $id)->get();
        $Resposanbilities= Resposanbilities::where('products_id','=', $id)->get();
        $RatesPerson= RatesPerson::where('products_id','=', $id)->get();
        return view('paginaexterna.detalle_paquete.paquete_detalle',
            compact('RatesPerson','Resposanbilities',
                'Resposanbilities','Special_dates','Polices_of_our_rates',
                'Reservation_polices','Important_note','Recommendations_to_carry',
                'Not_include','Includes','Itinerary','paises',
                'ciudades', 'usuarios','product'));

    }
    public function detallepaquete_reserva(Request $request)
    {

        $product= Product::where('id','=', $request->paquete_id)->first();
        $Itinerary= Itinerary::where('products_id','=',$request->paquete_id)->get();
        $Includes= Includes::where('products_id','=', $request->paquete_id)->get();
        $Not_include= Not_include::where('products_id','=', $request->paquete_id)->get();
        $Recommendations_to_carry= Recommendations_to_carry::where('products_id','=', $request->paquete_id)->get();
        $Important_note= Important_note::where('products_id','=', $request->paquete_id)->get();
        $Reservation_polices= Reservation_polices::where('products_id','=', $request->paquete_id)->get();
        $Polices_of_our_rates= Polices_of_our_rates::where('products_id','=', $request->paquete_id)->get();
        $Special_dates= Special_dates::where('products_id','=', $request->paquete_id)->get();
        $Resposanbilities= Resposanbilities::where('products_id','=', $request->paquete_id)->get();
        $RatesPerson= RatesPerson::where('products_id','=', $request->paquete_id)->get();
        $paises = Pais::all();
        $ciudades = Ciudad::all();

        return view('paginaexterna.detalle_paquete.reserva_detalle',compact('RatesPerson','Resposanbilities',
            'Resposanbilities','Special_dates','Polices_of_our_rates',
            'Reservation_polices','Important_note','Recommendations_to_carry',
            'Not_include','Includes','Itinerary','paises',
            'ciudades', 'usuarios','product'));

    }
    public function norte()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        return view('paginaexterna.paquetes.nacionales.norte', compact('paises', 'ciudades', 'usuarios'));

    }
    public function centro()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();

        return view('paginaexterna.paquetes.nacionales.centro', compact('paises', 'ciudades', 'usuarios'));

    }
    public function sur()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        return view('paginaexterna.paquetes.nacionales.sur', compact('paises', 'ciudades', 'usuarios'));

    }
    public function internacionales()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        return view('paginaexterna.paquetes.internaciones', compact('paises', 'ciudades', 'usuarios'));

    }
    public function lunademiel()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        return view('paginaexterna.paquetes.luna_miel', compact('paises', 'ciudades', 'usuarios'));

    }
    public function fullday()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        return view('paginaexterna.full_day.index', compact('paises', 'ciudades', 'usuarios'));

    }
    public function salidascomerciales()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        return view('paginaexterna.salidas_confirmadas.index', compact('paises', 'ciudades', 'usuarios'));

    }
    public function alojamiento()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        return view('paginaexterna.alojamiento.index', compact('paises', 'ciudades', 'usuarios'));

    }
    public function vehiculos()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        return view('paginaexterna.traslados.vehiculos', compact('paises', 'ciudades', 'usuarios'));

    }
    public function trenes()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        return view('paginaexterna.traslados.trenes', compact('paises', 'ciudades', 'usuarios'));

    }
    public function buses()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        return view('paginaexterna.traslados.buses', compact('paises', 'ciudades', 'usuarios'));

    }
    public function cruceros()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        return view('paginaexterna.traslados.cruceros', compact('paises', 'ciudades', 'usuarios'));

    }
    public function vuelos()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        return view('paginaexterna.vuelos.index', compact('paises', 'ciudades', 'usuarios'));

    }
    public function promociones()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        return view('paginaexterna.promociones.index', compact('paises', 'ciudades', 'usuarios'));

    }
    public function seguros()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        return view('paginaexterna.seguros.index', compact('paises', 'ciudades', 'usuarios'));

    }
    public function autos()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        return view('paginaexterna.autos.index', compact('paises', 'ciudades', 'usuarios'));

    }
    public function promocionesescolares()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        return view('paginaexterna.promociones_escolares.index', compact('paises', 'ciudades', 'usuarios'));

    }

    public function terminos()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        return view('paginaexterna.terminos_condiciones.index', compact('paises', 'ciudades', 'usuarios'));

    }
    public function nosotros()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        return view('paginaexterna.nosotros.index', compact('paises', 'ciudades', 'usuarios'));

    }

    public function contactanos()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        return view('paginaexterna.contactanos.index', compact('paises', 'ciudades', 'usuarios'));

    }

    public function MyAcount()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        $id = Auth::User()->id;
        $usuarios = User::where('id', '=', $id)->first();
        return view('paginaexterna.micuenta.micuenta', compact('paises', 'ciudades', 'usuarios'));

    }

    public function getManageExternalPage()
    {

        $paises = Pais::all();
        $ciudades = Ciudad::all();
        $products= Product::where('outstanding','=','0')
        ->where('visible','=','1')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        $products_featured= Product::where('outstanding','=','1')
        ->where('visible','=','1')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('paginaexterna.center.index', compact('paises', 'ciudades','products_featured','products'));
    }

    public function getManageRegister()
    {
        $paises = Pais::all();
        $ciudades = Ciudad::all();
        return view('paginaexterna.register.register', compact('paises', 'ciudades'));

    }




    public function actualizarstore (Request $request)
    {



        if (empty($request->oldpassword)) {
            $user = User::where('email', '=', $request->email)->first();

            if (count($user) == 1) {
                $user->apellidos = $request->apellidos;
                $user->nombres = $request->nombres;
                $user->cedula = $request->cedula;
                $user->email = $request->email;
                $user->pais_id = $request->pais;
                $user->ciudad_id = $request->ciudad;
                $user->direccion = $request->direccion;
                $user->telefono = $request->telefono;
                if (empty($request->file('image'))) {

                } else {
                    $destination = 'uploads/usuarios/';
                    $image = $request->file('image');
                    $random = str_random(6);
                    if (!empty($image)) {
                        $filename = $request->cedula . $random . $image->getClientOriginalName();
                        $image->move($destination, $filename);
                    } else {
                        $filename = 'user_default.png';
                    }
                    $user->imagen = $filename;

                }
                $user->save();
                //return view('welcome');
                $message = $user ? 'Se ha registrado el usuario' . $request->nombres . ' ' . $request->apellidos . 'de forma exitosa.' : 'Error al Registrar';
                //Session::flash('message', 'Te has registrado exitosamente ');
                return redirect()->route('myacount')->with('message', $message);
            }
        } else {
            if ($request->password == $request->confpassword) {
                $old= bcrypt($request->oldpassword);
                $user = User::where('email', '=', $request->email)->where('password', '=', $old)->first();
                if (count($user) == 1) {
                    $user->apellidos = $request->apellidos;
                    $user->nombres = $request->nombres;
                    $user->cedula = $request->cedula;
                    $user->email = $request->email;
                    $user->password = bcrypt($request->password);
                    $user->pais_id = $request->pais;
                    $user->ciudad_id = $request->ciudad;
                    $user->direccion = $request->direccion;
                    $user->telefono = $request->telefono;
                    if (empty($request->file('image'))) {


                    } else {
                        $destination = 'uploads/usuarios/';
                        $image = $request->file('image');
                        $random = str_random(6);
                        if (!empty($image)) {
                            $filename = $request->cedula . $random . $image->getClientOriginalName();
                            $image->move($destination, $filename);
                        } else {
                            $filename = 'user_default.png';
                        }
                        $user->imagen = $filename;

                    }
                    $user->save();
                        //return view('welcome');
                    $message = $user ? 'Se ha registrado el usuario' . $request->nombres . ' ' . $request->apellidos . 'de forma exitosa.' : 'Error al Registrar';
                        //Session::flash('message', 'Te has registrado exitosamente ');
                    return redirect()->route('myacount')->with('message', $message);
                } else {
                    $message2 = 'La contraseña anteriror no es correcta';
                    return redirect()->back()->with('message2', $message2);

                }
            } else {
                $message2 = 'El Password no es ingual en los dos campos';
                return redirect()->back()->with('message2', $message2);
            }

        }
    }
}


