<?php

namespace App\Http\Controllers\Eshop;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use App\Destination;
use App\Typeservice;
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

use App\Http\Requests\ProductRequest;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function find(Request $request)
    {
        // dd($request->all());

        //dd($request->all());
        if (($request->fechai != "") and ($request->fechaf != "")){
            $fechai = $request->fechai;
            $fechaf = $request->fechaf;
        }else{
            $fechai = date('Y-m-d');
            $fechaf = date('Y-m-d');
        }

        $categories = Category::all();
        $destination = Destination::all();
        $type_service = Typeservice::all();
        /*
                $products= Product::where('name','like','%'.$request->dato.'%')
                    ->orWhere('extract','like', '%'.$request->dato.'%')
                    ->orderBy('created_at', 'desc')->paginate(10);

        */
        /*busqueda general*/

        /*---------------------------------------consolidador lleno------------------*/
        if (!empty($request->dato)) {
            $products1= Product::select('id','name','description','destination_id',
                'typeservice_id','duration','slug','price_dolar',
                'extract', 'price_sol','quantity','visible','outstanding', 'category_id', 'visible', 'image','updated_at','created_at');
            $products1->where('name','like','%'.$request->dato.'%');
            $products1->orWhere('extract','like', '%'.$request->dato.'%');

            if (!empty($request->destination_id)) {
                $products1->where('destination_id', '=',$request->destination_id);
            }
            if (!empty($request->typeservice_id)) {
                $products1->where('typeservice_id', '=',$request->type_service_id);
            }
            if (!empty($request->category_id)) {
                $products1->where('category_id', '=',$request->category_id);
            }
            $products1->orderBy('created_at', 'desc')->paginate(10);
            $products=  $products1->get();
        }

        if (empty($request->dato) && !empty($request->destination_id)) {
            $products2= Product::select('id','name','description','destination_id',
                'typeservice_id','duration','slug','price_dolar',
                'extract', 'price_sol','quantity','visible','outstanding', 'category_id', 'visible', 'image','updated_at','created_at');
            $products2->where('destination_id', '=',$request->destination_id);

            if (!empty($request->type_service_id)) {
                $products2->where('typeservice_id', '=',$request->type_service_id);
            }
            if (!empty($request->category_id)) {
                $products2->where('category_id', '=',$request->category_id);
            }
            $products2->orderBy('created_at', 'desc')->paginate(10);
            $products=  $products2->get();
        }

        if (empty($request->dato) && empty($request->destination_id) && !empty($request->type_service_id)) {
            $products3= Product::select('id','name','description','destination_id',
                'typeservice_id','duration','slug','price_dolar',
                'extract', 'price_sol','quantity','visible','outstanding', 'category_id', 'visible', 'image','updated_at','created_at');
            $products3->where('typeservice_id', '=',$request->type_service_id);

            if (!empty($request->category_id)) {
                $products->where('category_id', '=',$request->category_id);
            }
            $products3->orderBy('created_at', 'desc')->paginate(10);
            $products=  $products3->get();
        }
        if (empty($request->dato) && empty($request->destination_id) && empty($request->typeservice_id) && !empty($request->category_id)) {
            $products4 = Product::select('id', 'name', 'description', 'destination_id',
                'typeservice_id', 'duration', 'slug', 'price_dolar',
                'extract', 'price_sol', 'quantity', 'visible', 'outstanding', 'category_id', 'visible', 'image', 'updated_at', 'created_at');
            $products4->where('category_id', '=', $request->category_id);
            $products4->orderBy('created_at', 'desc')->paginate(10);
            $products = $products4->get();
        }

        if (empty($request->dato) && empty($request->destination_id) && empty($request->typeservice_id) && empty($request->category_id)) {
            $products= Product::where('name','like','%'.$request->dato.'%')
                ->orWhere('extract','like', '%'.$request->dato.'%')
                ->orderBy('created_at', 'desc')->paginate(10);
        }
        //  dd($products,$request->all());
        return view('e-shop.products.index', compact('categories','destination','type_service'))
            ->with("products",  $products);
    }

    public function index()
    {
        $products = Product::Paginate();
        $products->each(function($products){
            $products->category;
        });
        $categories = Category::all();
        $destination = Destination::all();
        $type_service = Typeservice::all();
        return view('e-shop.products.index', compact('categories','destination','type_service'))->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $destination = Destination::all();
        $type_service = Typeservice::all();
        return view('e-shop.products.create', compact('destination','type_service'))->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //dd($request->all());
        $products_id = Product::where('name','=',$request->name)->first();
        if(empty($products_id)){

            if ($request->file()) {
                $file = $request->file('image');
                $name = 'tiendus_' . time() . '.' . $file->getClientOriginalExtension();
                $path = public_path() . '/uploads/images/products';
                $file->move($path, $name);
            }
            $product = new Product();
            $product->name = $request->name;
            $product->price_sol = $request->price_sol;
            $product->price_dolar = $request->price_dolar;
            $product->destination_id = $request->destination_id;
            $product->description = $request->descriptionv2;
            $product->duration = $request->duration;
            $product->extract = $request->extract;
            $product->typeservice_id = $request->type_service_id;
            $product->categories_id = $request->category_id;
            $product->visible = $request->visible;
            $product->slug = $request->name;
            $product->outstanding = $request->outstanding;
            $product->image = $name;
            $product->save();

        }else{
            $message2 = 'Ya esxiste un paquete con este nombre por favor debe cambiar el nombre';
            return redirect()->route('manageProduct-A')->with('message2', $message2);
        }

        $products_id = Product::where('name','=',$request->name)
            ->where('extract','=',$request->extract)
            ->first();
        if($products_id){
            for($j =0 ; $j<sizeof($request->dia);$j++){
                $itinerary= new Itinerary();
                $itinerary->products_id = $products_id->id;
                $itinerary->day= $request->dia[$j];
                $itinerary->description= $request->description[$j];
                $itinerary->save();
            }
        }
        if($products_id){
            for($j =0 ; $j<sizeof($request->dincludes);$j++){
                $itinerary= new Includes();
                $itinerary->products_id = $products_id->id;
                $itinerary->description= $request->dincludes[$j];
                $itinerary->save();
            }
        }
        if($products_id){
            for($j =0 ; $j<sizeof($request->dnot_includes);$j++){
                $itinerary= new Not_include();
                $itinerary->products_id = $products_id->id;
                $itinerary->description= $request->dnot_includes[$j];
                $itinerary->save();
            }
        }
        if($products_id){
            for($j =0 ; $j<sizeof($request->drecommendations_to_carry);$j++){
                $itinerary= new Recommendations_to_carry();
                $itinerary->products_id = $products_id->id;
                $itinerary->description= $request->drecommendations_to_carry[$j];
                $itinerary->save();
            }
        }
        if($products_id){
            for($j =0 ; $j<sizeof($request->dimportant_note);$j++){
                $itinerary= new Important_note();
                $itinerary->products_id = $products_id->id;
                $itinerary->description= $request->dimportant_note[$j];
                $itinerary->save();
            }
        }
        if($products_id){
            for($j =0 ; $j<sizeof($request->dreservation_polices);$j++){
                $itinerary= new Reservation_polices();
                $itinerary->products_id = $products_id->id;
                $itinerary->description= $request->dreservation_polices[$j];
                $itinerary->save();
            }
        }
        if($products_id){
            for($j =0 ; $j<sizeof($request->dpolices_od_our_rates);$j++){
                $itinerary= new Polices_of_our_rates();
                $itinerary->products_id = $products_id->id;
                $itinerary->description= $request->dpolices_od_our_rates[$j];
                $itinerary->save();
            }
        }
        if($products_id){
            for($j =0 ; $j<sizeof($request->dspecial_dates);$j++){
                $itinerary= new Special_dates();
                $itinerary->products_id = $products_id->id;
                $itinerary->description= $request->dspecial_dates[$j];
                $itinerary->save();
            }
        }
        if($products_id){
            for($j =0 ; $j<sizeof($request->dresponsabilities);$j++){
                $itinerary= new Resposanbilities();
                $itinerary->products_id = $products_id->id;
                $itinerary->description= $request->dresponsabilities[$j];
                $itinerary->save();
            }
        }
        if($products_id){
            for($j =0 ; $j<sizeof($request->hotel);$j++){
                $itinerary= new RatesPerson();
                $itinerary->radius = $request->radius[$j];
                $itinerary->hotel = $request->hotel[$j];
                $itinerary->stars = $request->stars[$j];
                $itinerary->category = $request->category[$j];
                $itinerary->swbe = $request->swbe[$j];
                $itinerary->dwbe = $request->dwbe[$j];
                $itinerary->tple = $request->tple[$j];
                $itinerary->chde = $request->chde[$j];
                $itinerary->swbp = $request->swbp[$j];
                $itinerary->dwbp = $request->dwbp[$j];
                $itinerary->tplp = $request->tplp[$j];
                $itinerary->chdp = $request->chdp[$j];
                $itinerary->in = $request->in[$j];
                $itinerary->out = $request->out[$j];
                $itinerary->products_id = $products_id->id;
                $itinerary->save();
            }
        }

        $message = $product ? 'Nuevo Paquete '.$request->name.' agregado correctamente' : 'El Paquete'.$request->name.' NO pudo agregase';
        return redirect()->route('manageProduct-A')->with('message', $message);

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        $destination = Destination::all();
        $type_service = Typeservice::all();
        $itinerary = Itinerary::where('products_id','=', $id)->get();
        $Not_include=Not_include::where('products_id','=', $id)->get();
        $Recommendations_to_carry=Recommendations_to_carry::where('products_id','=', $id)->get();
        $Important_note=Important_note::where('products_id','=', $id)->get();
        $Reservation_polices=Reservation_polices::where('products_id','=', $id)->get();
        $Polices_of_our_rates=Polices_of_our_rates::where('products_id','=', $id)->get();
        $Special_dates=Special_dates::where('products_id','=', $id)->get();
        $Resposanbilities=Resposanbilities::where('products_id','=', $id)->get();
        $RatesPerson=RatesPerson::where('products_id','=', $id)->get();
        return view('e-shop.products.edit',compact('Not_include',
            'Recommendations_to_carry',
            'Important_note',
            'Reservation_polices',
            'Polices_of_our_rates',
            'Special_dates',
            'Resposanbilities',
            'RatesPerson',
            'destination',
            'type_service',
            'itinerary'))
            ->with('product', $product)
            ->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::where('id','=',$id)->first();
        if(!empty($product)){
            if(!empty($request->image)){
                if ($request->file()) {
                    $file = $request->file('image');
                    $name = 'tiendus_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = public_path() . '/uploads/images/products';
                    $file->move($path, $name);
                }}

                $product->name = $request->name;
                $product->price_sol = $request->price_sol;
                $product->price_dolar = $request->price_dolar;
                $product->destination_id = $request->destination_id;
                $product->description = $request->descriptionv2;
                $product->duration = $request->duration;
                $product->extract = $request->extract;
                $product->typeservice_id = $request->type_service_id;
                $product->categories_id = $request->category_id;
                $product->visible = $request->visible;
                $product->slug = $request->name;
                $product->outstanding = $request->outstanding;
            if(!empty($request->image)) {
                $product->image = $name;
            }
                $product->save();

            }else{
                $message2 = 'Ya esxiste un paquete con este nombre por favor debe cambiar el nombre';
                return redirect()->route('manageProduct-A')->with('message2', $message2);
            }


            if($id){
                $itinerary = Itinerary::where('products_id','=',$id)
                    ->get();
                for($j =0 ; $j<sizeof($itinerary);$j++){
                    $itinerary->products_id = $products_id->id;
                    $itinerary->day= $request->dia[$j];
                    $itinerary->description= $request->description[$j];
                    $itinerary->save();
                }
            }
            if($products_id){
                for($j =0 ; $j<sizeof($request->dincludes);$j++){
                    $itinerary= new Includes();
                    $itinerary->products_id = $products_id->id;
                    $itinerary->description= $request->dincludes[$j];
                    $itinerary->save();
                }
            }
            if($products_id){
                for($j =0 ; $j<sizeof($request->dnot_includes);$j++){
                    $itinerary= new Not_include();
                    $itinerary->products_id = $products_id->id;
                    $itinerary->description= $request->dnot_includes[$j];
                    $itinerary->save();
                }
            }
            if($products_id){
                for($j =0 ; $j<sizeof($request->drecommendations_to_carry);$j++){
                    $itinerary= new Recommendations_to_carry();
                    $itinerary->products_id = $products_id->id;
                    $itinerary->description= $request->drecommendations_to_carry[$j];
                    $itinerary->save();
                }
            }
            if($products_id){
                for($j =0 ; $j<sizeof($request->dimportant_note);$j++){
                    $itinerary= new Important_note();
                    $itinerary->products_id = $products_id->id;
                    $itinerary->description= $request->dimportant_note[$j];
                    $itinerary->save();
                }
            }
            if($products_id){
                for($j =0 ; $j<sizeof($request->dreservation_polices);$j++){
                    $itinerary= new Reservation_polices();
                    $itinerary->products_id = $products_id->id;
                    $itinerary->description= $request->dreservation_polices[$j];
                    $itinerary->save();
                }
            }
            if($products_id){
                for($j =0 ; $j<sizeof($request->dpolices_od_our_rates);$j++){
                    $itinerary= new Polices_of_our_rates();
                    $itinerary->products_id = $products_id->id;
                    $itinerary->description= $request->dpolices_od_our_rates[$j];
                    $itinerary->save();
                }
            }
            if($products_id){
                for($j =0 ; $j<sizeof($request->dspecial_dates);$j++){
                    $itinerary= new Special_dates();
                    $itinerary->products_id = $products_id->id;
                    $itinerary->description= $request->dspecial_dates[$j];
                    $itinerary->save();
                }
            }
            if($products_id){
                for($j =0 ; $j<sizeof($request->dresponsabilities);$j++){
                    $itinerary= new Resposanbilities();
                    $itinerary->products_id = $products_id->id;
                    $itinerary->description= $request->dresponsabilities[$j];
                    $itinerary->save();
                }
            }
            if($products_id){
                for($j =0 ; $j<sizeof($request->hotel);$j++){
                    $itinerary= new RatesPerson();
                    $itinerary->radius = $request->radius[$j];
                    $itinerary->hotel = $request->hotel[$j];
                    $itinerary->stars = $request->stars[$j];
                    $itinerary->category = $request->category[$j];
                    $itinerary->swbe = $request->swbe[$j];
                    $itinerary->dwbe = $request->dwbe[$j];
                    $itinerary->tple = $request->tple[$j];
                    $itinerary->chde = $request->chde[$j];
                    $itinerary->swbp = $request->swbp[$j];
                    $itinerary->dwbp = $request->dwbp[$j];
                    $itinerary->tplp = $request->tplp[$j];
                    $itinerary->chdp = $request->chdp[$j];
                    $itinerary->in = $request->in[$j];
                    $itinerary->out = $request->out[$j];
                    $itinerary->products_id = $products_id->id;
                    $itinerary->save();
                }
            }

            $message = $product ? 'Nuevo Paquete '.$request->name.' agregado correctamente' : 'El Paquete'.$request->name.' NO pudo agregase';
            return redirect()->route('manageProduct-A')->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        $message = $product ? 'Producto eliminado correctamente' : 'El producto NO pudo eliminarse';
        return redirect()->route('manageProduct-A')->with('message', $message);
    }
}
