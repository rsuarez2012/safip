<?php

namespace App\Http\Controllers\Pagina;

use Illuminate\Http\Request;
use App\Pagina\PaginaDestino;
use App\Pagina\PaginaPaquete;
use App\Pagina\PaginaListado;
use App\Pagina\PuntoEncuentro;
use App\Pagina\SalidaConfirmada;
use App\Http\Controllers\Controller;
use App\Pagina\PaginaCategoriaPaquete;
use Illuminate\Support\Facades\Storage;
use App\Pagina\PaginaDatoPaquete;
use Intervention\Image\ImageManagerStatic as Image;

class PaginaPaquetePaso1Controller extends Controller
{
	public function getCategories()
	{
		//$categories=PaginaCategoriaPaquete::where('nombre', '!=', 'FULL DAY')->get();
		$categories=PaginaCategoriaPaquete::get();
		return $categories;
	}
	public function create(PaginaPaquete $paquete)
	{
		//$destinos = PaginaDestino::all();
		$categorias = PaginaCategoriaPaquete::all();

		#Variables del Paquete
		$id = 0;
        $codigo = '';
        $nombre = '';
        $estado = '';
        $descripcion = '';
        $extracto = '';
        $categoria_id = 0;
        $cupos = 0;
        $fecha_salida = '';
        $fecha_llegada = '';
        $datos = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'incluido')->get();
		$llevar = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'llevar')->get();
		$politicas = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'politcareserva')->get();
		$fechas = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'fechas')->get();
		$noincluidos = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'noincluido')->get();
		$tarifas = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'politicatarifa')->get();
		$responsabilidades = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'responsabilidades')->get();
		$importantes = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'importante')->get();
		//dd($datos);
		$paquete_id = $paquete;
		$dat = $paquete->id;

		return view('adminweb.paquetes.nuevo.create', 
			   compact('categorias', 'id', 'codigo', 'nombre', 'estado', 'descripcion', 'extracto', 'categoria_id', 'cupos', 'fecha_salida', 'fecha_llegada','datos', 'paquete_id', 'llevar', 'politicas', 'fechas', 'noincluidos', 'tarifas', 'responsabilidades', 'importantes', 'dat'));
		/*return view('adminweb.paquetes.pasos.paso1', 
			   compact('categorias', 'id', 'codigo', 'nombre', 'estado', 'descripcion', 'extracto', 'categoria_id', 'cupos', 'fecha_salida', 'fecha_llegada','datos', 'paquete_id', 'llevar', 'politicas', 'fechas', 'noincluidos', 'tarifas', 'responsabilidades', 'importantes', 'dat'));*/
	}
	public function store(Request $data)
	{
		//dd($data->all());
		//var_dump($data->all());
		$paquete=new PaginaPaquete();

		$paquete->codigo=strtoupper($data->code);
		$paquete->nombre=$data->name;
		$paquete->descripcion='nada';
		//$paquete->descripcion=$data->description;
		//$paquete->extracto=$data->extrac;
		$paquete->extracto='nada';
		$paquete->zona = $data->zone;
		$paquete->imagen=$this->cargarImagenes($data);
		//$paquete->imagen = 'o.png';
		if ($data->category == 6){
			$paquete->statusCreado = 'terminado';
		}
		if ($data->category == 7) {
			foreach ($data->departures as $salida) {
				$newSalida = new SalidaConfirmada();
				$newSalida->cupos =$salida['quotas'];
				$newSalida->fecha_salida=$salida['departure'];
				$newSalida->paquete_id=$paquete->id;
				$newSalida->save();
				

				$point = new PuntoEncuentro();
				$point->nombre =  $salida['point_name'];
				$point->latitud = $salida['lat'];
				$point->longitud = $salida['lng'];
				$point->salida_id =  $newSalida->id;
				$point->save();
			}
		}else{
			$paquete->categoria_id=$data->category;
		}
		$paquete->save();
		//dd($paquete->id);
		//return $paquete->id;
		$pack = $paquete->id;
		//dd($pack);
		 $categorias = PaginaCategoriaPaquete::all();
		//return redirect()->route('paquete.edit.paso1', $pack);
		return redirect()->route('paquete.editar', $pack);
		//return redirect()->back();
	}
	public function verCodigo($code)
	{
		$x=PaginaPaquete::where("codigo",$code)->count();
		return $x;
	}
	public function getPackage($id)
	{
		$package = PaginaPaquete::find($id)->load("salidas.punto");
		return $package;
	}
	public function saveDeparture(Request $data, $package_id)
	{
		$departures =[];
		foreach ($data->departures as $item) {
			$departure = new SalidaConfirmada();
			$departure->cupos = $item['quotas'];
			$departure->fecha_salida = $item['departure'];
			$departure->paquete_id	= $package_id;
			$departure->save(); 
			
			$point = new PuntoEncuentro();
			$point->nombre =  $item['point_name'];
			$point->latitud = $item['lat'];
			$point->longitud = $item['lng'];
			$point->salida_id =  $departure->id;
			$point->save();

			array_push($departures,$departure->id);
		}

		return $departures;
	}
	public function destroyDeparture($id)
	{
		$salida = SalidaConfirmada::find($id);
		$salida->punto->delete();
		$salida->delete();
		return ;
	}
	/*public function edit(PaginaPaquete $paquete)
	{
		//dd($paquete);
		return view('adminweb.paquetes.pasos.paso1', compact('paquete'))->with('paquete_id',$paquete->id);
	}*/
	public function edit(PaginaPaquete $paquete)
	{

		//$dat = PaginaDatoPaquete::where('paquete_id', $paquete->id)->get();
		$datos = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'incluido')->get();
		$llevar = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'llevar')->get();
		$politicas = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'politcareserva')->get();
		$fechas = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'fechas')->get();
		$noincluidos = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'noincluido')->get();
		$tarifas = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'politicatarifa')->get();
		$responsabilidades = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'responsabilidades')->get();
		$importantes = PaginaDatoPaquete::where('paquete_id', $paquete->id)->where('tipo', 'importante')->get();;
		$paquete_id = $paquete;

		$dat = $paquete->id;
		$categorias = PaginaCategoriaPaquete::all();
		$destinos = PaginaDestino::get();
		/*return view('adminweb.paquetes.pasos.paso1', compact('datos', 'paquete_id', 'llevar', 'politicas', 'fechas', 'noincluidos', 'tarifas', 'responsabilidades', 'importantes', 'dat'));*/
		return view('adminweb.paquetes.nuevo.edit', compact('datos', 'paquete_id', 'llevar', 'politicas', 'fechas', 'noincluidos', 'tarifas', 'responsabilidades', 'importantes', 'dat', 'categorias', 'paquete', 'destinos'));
	
	}
	public function update(Request $request, PaginaPaquete $paquete)
	{
		
		$paquete = PaginaPaquete::find($request->id);
		
		$paquete->nombre       = $request->name;
		$paquete->descripcion  = 'nada';//$request->description;
		$paquete->extracto     = 'nada';//$request->extrac;
		$paquete->categoria_id = $request->category;
		$paquete->zona         = $request->zone;
		
		if(count($request->file()) > 0){
			Storage::disk('public')->delete('big/'.$paquete->imagen);
			Storage::disk('public')->delete('medium/'.$paquete->imagen);
			Storage::disk('public')->delete('miniature/'.$paquete->imagen);
			Storage::disk('public')->delete('original/'.$paquete->imagen);
			$paquete->imagen = $this->cargarImagenes($request);
		}
		$paquete->save();

		return redirect()->route('manageProduct-A')->with('info', 'Paquete editado correctamente!.');
		//return redirect()->back();
	}
	public function cargarImagenes($data){
		$carpetas = [["original",null],["miniature",150],["medium",300],["big",700]];
		
			if ($data->file('img')) 
			{
				$imagenOriginal = $data->file('img');
				
				$temp_name ="img_paquete_" .str_random(15) . '_'. date("ymd") .".". $imagenOriginal->getClientOriginalExtension();
				foreach($carpetas as $index => $carpeta){
				if($index != 0){
					/* $imagen->heighten($carpeta[1], function ($constraint) {
						$constraint->aspectRatio();
					}); */
					$imagen = Image::make($imagenOriginal)->resize($carpeta[1],null,
					function($constraint){
						$constraint->aspectRatio();
					})
					->resizeCanvas($carpeta[1],null);
				}else{
					$imagen = Image::make($imagenOriginal);
				}
				$ruta = public_path().'/storage/'."/".$carpeta[0]."/";
				$imagen->save($ruta . $temp_name, 100);
				}
			}
		return $temp_name;
		
	}
	public function cargar_data_base(PaginaPaquete $paquete){
        return $paquete->load('datos');
        //return $paquete->with('datos')->get();
    }
}
