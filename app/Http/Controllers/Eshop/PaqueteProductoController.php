<?php

namespace App\Http\Controllers\Eshop;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PaqueteFecha;
use App\PaqueteIncluido;
use App\PaqueteItinerario;
use App\PaqueteNoIncluido;
use App\PaqueteNota;
use App\PaqueteRecomendacion;
use App\PaqueteReserva;
use App\PaqueteResponsabilidad;
use App\PaqueteTarifa;
use App\Paquete;
use App\PaqueteTarifaPersona;
use App\Category;
use App\Destination;
use App\Typeservice;

use App\Http\Requests\PaqueteProductoRequest;

class PaqueteProductoController extends Controller
{
    public function index()
    {
        $products = Paquete::Paginate();
        $products->each(function($products){
            $products->category;
        });
         $categories = Category::all();
        $destination = Destination::all();
        $type_service = Typeservice::all();
        return view('e-shop.products.index', compact('categories','destination','type_service'))->with('products', $products);
    }

    public function store (Request $data){
        $paquete=new Paquete();
        if ($data->file()) {
            $file = $data->file('image');
            $name = 'tiendus_' . time() . '.' . $file->getClientOriginalExtension();
            $path = public_path() . '/uploads/images/products';
            $file->move($path, $name);
        }
        $paquete->nombre=$data->name;
        $paquete->precio_sol=$data->price_sol;
        $paquete->precio_dolar=$data->price_dolar;
        $paquete->destino=$data->destination_id;
        $paquete->descripcion=$data->descriptionv2;
        $paquete->extracto=$data->extract;
        $paquete->servicio=$data->type_service_id;
        $paquete->categoria=$data->category_id;
        $paquete->imagen=$name;
        $paquete->duracion=$data->duration;
        $paquete->visible=$data->visible;
        $paquete->destacado=$data->outstanding;
        $paquete->fecha_sale=$data->fecha_sale;
        $paquete->fecha_entra=$data->fecha_llega;
        $paquete->cupos=$data->cupos;
        $paquete->save();

        $ultimo = Paquete::orderBy('id','desc')->first();

        if(count($data->dia)!= 0){
            for ($i=0; $i < count($data->dia) ; $i++) { 
                $itinerario = new PaqueteItinerario();
                $itinerario->paquete_id=$ultimo->id;
                $itinerario->descripcion=$data->dia[$i];
                $itinerario->fecha=$data->description[$i];
                $itinerario->save();
            }
        }
        if(count($data->dincludes)!= 0){
            for ($i=0; $i < count($data->dincludes) ; $i++) { 
                $incluidos = new PaqueteIncluido();
                $incluidos->paquete_id=$ultimo->id;
                $incluidos->descripcion=$data->dincludes[$i];
                $incluidos->save();
            }
        }
        if(count($data->dnot_includes)!= 0){
            for ($i=0; $i < count($data->dnot_includes) ; $i++) { 
                $noincluidos = new PaqueteNoIncluido();
                $noincluidos->paquete_id=$ultimo->id;
                $noincluidos->descripcion=$data->dnot_includes[$i];
                $noincluidos->save();
            }
        }
        if(count($data->drecommendations_to_carry)!= 0){
            for ($i=0; $i < count($data->drecommendations_to_carry) ; $i++) { 
                $recomendacion = new PaqueteRecomendacion();
                $recomendacion->paquete_id=$ultimo->id;
                $recomendacion->descripcion=$data->drecommendations_to_carry[$i];
                $recomendacion->save();
            }
        }
        if(count($data->dimportant_note)!= 0){
            for ($i=0; $i < count($data->dimportant_note) ; $i++) { 
                $nota = new PaqueteNota();
                $nota->paquete_id=$ultimo->id;
                $nota->descripcion=$data->dimportant_note[$i];
                $nota->save();
            }
        }
        if(count($data->dreservation_polices)!= 0){
            for ($i=0; $i < count($data->dreservation_polices) ; $i++) { 
                $reserva = new PaqueteReserva();
                $reserva->paquete_id=$ultimo->id;
                $reserva->descripcion=$data->dreservation_polices[$i];
                $reserva->save();
            }
        }
        if(count($data->dpolices_of_our_rates)!= 0){
            for ($i=0; $i < count($data->dpolices_of_our_rates) ; $i++) { 
                $tarifa = new PaqueteTarifa();
                $tarifa->paquete_id=$ultimo->id;
                $tarifa->descripcion=$data->dpolices_of_our_rates[$i];
                $tarifa->save();
            }
        }
        if(count($data->dspecial_dates)!= 0){
            for ($i=0; $i < count($data->dspecial_dates) ; $i++) { 
                $fecha = new PaqueteFecha();
                $fecha->paquete_id=$ultimo->id;
                $fecha->descripcion=$data->dspecial_dates[$i];
                $fecha->save();
            }
        }
        if(count($data->dresponsabilities)!= 0){
            for ($i=0; $i < count($data->dresponsabilities) ; $i++) { 
                $responsabilidad = new PaqueteResponsabilidad();
                $responsabilidad->paquete_id=$ultimo->id;
                $responsabilidad->descripcion=$data->dresponsabilities[$i];
                $responsabilidad->save();
            }
        }
        if(count($data->hotel)!= 0){
            for ($i=0; $i < count($data->dresponsabilities) ; $i++) { 
                $tp = new PaqueteTarifaPersona();
                $tp->hotel=$data->hotel[$i];
                $tp->paquete_id=$ultimo->id;
                $tp->star=$data->stars[$i];
                $tp->categoria=$data->category[$i];
                $tp->e_swb=$data->swbe[$i];
                $tp->e_dwb=$data->dwbe[$i];
                $tp->e_tpl=$data->tple[$i];
                $tp->e_chd=$data->chde[$i];
                $tp->p_swb=$data->swbp[$i];
                $tp->p_dwb=$data->dwbp[$i];
                $tp->p_tpl=$data->tplp[$i];
                $tp->p_chd=$data->chdp[$i];
                $tp->check_in=$data->in[$i];
                $tp->check_out=$data->out[$i];
                $tp->save();
            }
        }

        return redirect()->route('manageProduct-A');
    }

    
}