<?php

namespace App\Http\Controllers\Pagina;

use App\Pagina\PaginaHotel;
use Illuminate\Http\Request;
use App\Pagina\PaginaListado;
use App\Pagina\PaginaDestino;
use App\Pagina\Servicio;
use App\Pagina\PaginaDetallesHotel;
use App\Pagina\PaginaHotelServicio;
use App\Pagina\PaginaCategoriaHotel;
use App\Http\Controllers\Controller;
class PaginaHotelController extends Controller
{
	public function index(){
		//$hotels = PaginaHotel::with('categoria', 'destino')->orderBy('id', 'Desc')->get();
		$categorias = PaginaCategoriaHotel::all();
		$destinos = PaginaDestino::all();
		$hotels = PaginaHotel::orderBy('id', 'Desc')->get();
		//dd($hotels);
		return view('adminweb/hoteles/index', compact('hotels', 'destinos', 'categorias'));
	}
	public function getHoteles(Request $request){/* 
		$hoteles = PaginaHotel::orderBy('id', 'DESC')->with('categoria','destino')->get(); */
		$hoteles = PaginaHotel::where('nombre','like', '%' . $request->name . '%')->orderBy('id', 'DESC')->with('categoria','destino')->paginate($request->sort);

        return [
            'pagination' => [
                'total'         => $hoteles->total(),
                'current_page'  => $hoteles->currentPage(),
                'per_page'      => $hoteles->perPage(),
                'last_page'     => $hoteles->lastPage(),
                'from'          => $hoteles->firstItem(),
                'to'            => $hoteles->lastItem(),
            ],
            'hoteles' => $hoteles
        ];
	}
	public function edit(Request $request, $id)
	{
		//$hotel = PaginaHotel::with('categoria', 'destino')->where('id', $request->id)->get();
		$hotel = PaginaHotel::where('id', $request->id)->get();
		//$categorias = PaginaCategoriaHotel::orderBy('id')->get()->pluck('info', 'id');
		$categorias = PaginaCategoriaHotel::all();
		$destinos = PaginaDestino::all();
		//dd($categorias);
		return json_encode(array('hotel' => $hotel, 'categorias' => $categorias, 'destinos' => $destinos));
	}
	public function store(Request $data){
		//dd($data->all());
		$hotel =	new PaginaHotel();
		$hotel->nombre 		=	$data->nombre;
		$hotel->estrella 	=	$data->estrella;
		$hotel->categoria_id=	$data->categoria_id;
		$hotel->destino_id	=	$data->destino_id;
		$hotel->p_swb 		=	$data->p_simple;
		$hotel->p_dwb 		=	$data->p_doble;
		$hotel->p_tpl 		=	$data->p_triple;
		$hotel->p_chd 		=	$data->p_ninio;
		$hotel->p_sj 		=	$data->p_sj;
		$hotel->p_s 		=	$data->p_s;
		$hotel->e_swb 		=	$data->e_simple;
		$hotel->e_dwb 		=	$data->e_doble;
		$hotel->e_tpl 		=	$data->e_triple;
		$hotel->e_chd 		=	$data->e_ninio;
		$hotel->e_sj 		=	$data->e_sj;
		$hotel->e_s 		= 	$data->e_s;
		$hotel->enlace 		=	$data->enlace;
		$hotel->check_in 	=	$data->check_in;
		$hotel->check_out 	=	$data->check_out;
		$hotel->save();
		$info = $hotel ? 'Se ha registrado el hotel "'. $data->nombre .'" de forma exitosa.!.' : 'Error al Editar';
		//return redirect()->back()->with('info', $info);
		return redirect()->route('detalles_hotel', $hotel)->with('info', $info);
	}
	public function update(Request $data){
		/*dd($data->all());
		$hotel=PaginaHotel::find($data->hotel['id']);
		$hotel->nombre=$data->hotel['nombre'];
		$hotel->estrella=$data->hotel['estrella'];
		$hotel->categoria_id=$data->hotel['categoria_id'];
		$hotel->destino_id=$data->hotel['destino_id'];
		$hotel->p_swb=$data->hotel['p_simple'];
		$hotel->p_dwb=$data->hotel['p_doble'];
		$hotel->p_tpl=$data->hotel['p_triple'];
		$hotel->p_chd=$data->hotel['p_ninio'];
		$hotel->p_sj=$data->hotel['p_sj'];
		$hotel->p_s=$data->hotel['p_s'];
		$hotel->e_swb=$data->hotel['e_simple'];
		$hotel->e_dwb=$data->hotel['e_doble'];
		$hotel->e_tpl=$data->hotel['e_triple'];
		$hotel->e_chd=$data->hotel['e_ninio'];
		$hotel->e_sj=$data->hotel['e_sj'];
		$hotel->e_s=$data->hotel['e_s'];
		$hotel->enlace=$data->hotel['enlace'];
		$hotel->check_in=$data->hotel['check_in'];
		$hotel->check_out=$data->hotel['check_out'];
		$hotel->save();
		return ;*/
		$hotel=PaginaHotel::find($data->id);
		//dd($data->all());
		$hotel->nombre=$data->nombre;
		$hotel->estrella=$data->estrella;
		$hotel->categoria_id=$data->categoria_id;
		$hotel->destino_id=$data->destino_id;
		$hotel->p_swb=$data->p_swb;
		$hotel->p_dwb=$data->p_dwb;
		$hotel->p_tpl=$data->p_tpl;
		$hotel->p_chd=$data->p_chd;
		$hotel->p_sj=$data->p_sj;
		$hotel->p_s=$data->p_s;
		$hotel->e_swb=$data->e_swb;
		$hotel->e_dwb=$data->e_dwb;
		$hotel->e_tpl=$data->e_tpl;
		$hotel->e_chd=$data->e_chd;
		$hotel->e_sj=$data->e_sj;
		$hotel->e_s=$data->e_s;
		$hotel->enlace=$data->enlace;
		$hotel->check_in=$data->check_in;
		$hotel->check_out=$data->check_out;
		$hotel->save();
		$info = $hotel ? 'Se ha editado el hotel "'. $data->nombre .'" de forma exitosa.!.' : 'Error al Editar';
		return redirect()->back()->with('info', $info);
	}
	public function delete($hotel){
		$hotel_eliminar = PaginaHotel::find($hotel);
		//$hotel=PaginaHotel::where('nombre', 'Hostel Quae aspernatur consequuntur est.')->first();
		$hotel_eliminar->load('listados');
		foreach ($hotel_eliminar->listados as $listado) {
		    $listadoHotelesEnlazados = PaginaListado::where('codigo', $listado->codigo)->get();
		    foreach ($listadoHotelesEnlazados as $hotelenlazado) {
			    $hotelist = PaginaListado::find($hotelenlazado->id);
			    $hotelist->delete();
		    }
		}
		$hotel_eliminar->delete();
		$info = $hotel_eliminar ? 'Se ha eliminado el hotel "'. $hotel_eliminar->nombre .'" de forma exitosa.!.' : 'Error al eliminar';
		//return redirect('/tablero/Hoteles/Admin/Index')->with('info', $info);
		return;
	}

	public function filtro(Request $data){
		$destinos   = PaginaDestino::all();
		$categorias = PaginaCategoriaHotel::all();
		if ($data->tipo == "nombre") {
			$hoteles=PaginaHotel::where('nombre', 'like', '%' . $data->f_nombre . '%')->get();
		} elseif($data->tipo == "destino") {
			$hoteles=PaginaHotel::where('destino_id','=',$data->f_destino)->get();
		} elseif ($data->tipo == "categoria") {
			$hoteles=PaginaHotel::where('categoria_id','=',$data->f_categoria)->get();
		}
		return view('adminweb/hoteles/index', compact('hoteles', 'categorias', 'destinos'));
		
	}
	///detalles del hotel
	public function detailsHotel(PaginaDetallesHotel $pagina_detalles_hotel, $id)
	{
		$hotel = PaginaHotel::where('id', $id)->get();
		//dd($hotel);
		$hot = $hotel[0]->id;
		//$detalle = PaginaDetallesHotel::where('hotel_id', $id)->first();
		$detalle = PaginaDetallesHotel::all()->where('hotel_id', '=>', $id)->first();
		//dd($detalle);
		$services = Servicio::all();
		$servicio = PaginaHotelServicio::all()->where('hotel_id', '=>', $id);
		//dd($servicio);
		return view('adminweb/hoteles/details_hotel', compact('hotel', 'services', 'detalle', 'servicio'));
	}
	public function detailsHotelStore(Request $request)
	{
		//dd($request->all());
		//$post->servicios->attach($request->servicios)//attach es adjuntar los cambios
		$detalles = new PaginaDetallesHotel();
		$detalles->hotel_id = $request->hotel_id;
		$detalles->resumen_hotel = $request->resumen_hotel;
		$detalles->descripcion_habitaciones = $request->descripcion_habitaciones;
		$detalles->save();

		$hotel = $request->hotel_id;
		//$hotel->servicios()->attach($request->get('servicios[]'));
		//$hotel->servicios()->sync($request->servicios, false);
		//
		$servicio_id = $request->servicios;
        $cont= 0;
        while($cont < count($servicio_id)){
            $servicios = new PaginaHotelServicio();
            $servicios->hotel_id= $hotel;
            $servicios->servicio_id= $servicio_id[$cont];
            $servicios->save();
            
            $cont=$cont + 1;
        }
		$info = $detalles ? 'Se han registrados los detalles de forma exitosa.!.' : 'Error al Editar';
		return redirect('tablero/Hoteles/Admin/Index')->with('info', $info);
	}
	public function detailsHotelEdit($id)
	{
		$hotel = PaginaHotel::where('id', $id)->first();
		//dd($hotel);
		$hot = $hotel->id;
		//dd($hot);
		//$detalle = PaginaDetallesHotel::where('hotel_id', $id)->first();
		$detalle = PaginaDetallesHotel::all()->where('hotel_id', '=>', $hot)->first();
		//dd($detalle);
		$services = Servicio::all();
		$servicio = PaginaHotelServicio::all()->where('hotel_id', '=>', $hot);
		//dd($servicio);
		return view('adminweb/hoteles/details_hotel_edit', compact('hotel', 'services', 'detalle', 'servicio'));
	}

	public function detailsHotelUpdate(Request $request, $id)
	{
		
		$detalle = PaginaDetallesHotel::all()->where('hotel_id', '=>', $request->id)->first();
		if($detalle === null){
			$detalles = new PaginaDetallesHotel();
			$detalles->hotel_id = $request->hotel_id;
			$detalles->resumen_hotel = $request->resumen_hotel;
			$detalles->descripcion_habitaciones = $request->descripcion_habitaciones;
			$detalles->save();
		}else{
			//dd($request->all());
			$detalle->hotel_id = $request->hotel_id;
			$detalle->resumen_hotel = $request->resumen_hotel;
			$detalle->descripcion_habitaciones = $request->descripcion_habitaciones;
			$detalle->save();

			$hotel = $id;
			$servicio_id = $request->servicios;
			
			foreach($request->servicios as $serv)
			{

				//dd($serv);
				$serv_exists = PaginaHotelServicio::where('hotel_id','=',$id)->where('servicio_id','=', $serv)->count();
				//dd($serv_exists);
				if($serv_exists < 1)
				{
					$hotel_service = PaginaHotelServicio::create([
                    'hotel_id' => $hotel,
                    'servicio_id' => $serv
                    ]);
				}
			}
	    }
			$info = $detalle ? 'Se han actualizado los detalles de forma exitosa.!.' : 'Error al Editar';
			return redirect()->back()->with('info', $info);
	}
	public function serviceStore(Request $request)
	{
		# code...
		$servicio = new Servicio();
		$servicio->nombre = $request->nombre;
		$servicio->save();
		$info = $servicio ? 'Se ha registrado el servicio "'. $servicio->nombre .'" de forma exitosa.!.' : 'Error al guardar';
		return redirect()->back()->with('info', $info);
	}
	/*public function searchCategory(Request $request)
    {
        $zone = Zone::findOrFail($request->input('zone_id'));
        $zones = Zone::where('province_id', $zone->province_id)->get();
        //getting array of ids
        $zones = collect($zones)->keyBy('id')->keys();
        
        $technicians = Technician::whereIn('zone_id', $zones)->get();
        
        //dd($technicians);
        $cantones = Canton::where('province_id', $zone->province_id)->get();
        return response()->json($technicians);

    }*/
}
