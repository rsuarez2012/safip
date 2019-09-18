<?php
namespace App\Http\Controllers\Eshop;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Typeservice;
use App\Http\Requests\DestinationRequest;

class TypeServiceController extends Controller
{
    public function store(Request $request)
    {
        $type_service = new Typeservice($request->all());
        $type_service->save();
        $message = $type_service ? 'Categoría agregada correctamente' : 'La categoría NO pudo agregarse';

        return redirect()->route('manageProduct-A')->with('message', $message);
    }
    public function update(Request $request, $id)
    {
        $type_service = Typeservice::find($id);
        $request = $request->all();
        $type_service->fill($request)->save();
        $message = $type_service ? 'Categoría actualizada correctamente' : 'La categoría NO pudo actualizarse';
        return redirect()->route('manageProduct-A')->with('message', $message);
    }
    public function destroy($id)
    {
        $type_service = Typeservice::find($id);
        $type_service->delete();
        $message = $type_service ? 'Categoría eliminada correctamente' : 'La categoría NO pudo eliminarse';
        return redirect()->route('manageProduct-A')->with('message', $message);
    }
}
