<?php
namespace App\Http\Controllers\Eshop;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Destination;
use App\Http\Requests\DestinationRequest;

class DestinationController extends Controller
{
    public function store(Request $request)
    {
        $destination = new Destination($request->all());
        $destination->save();
        $message = $destination ? 'Categoría agregada correctamente' : 'La categoría NO pudo agregarse';

        return redirect()->route('manageProduct-A')->with('message', $message);
    }
    public function update(Request $request, $id)
    {
        $destination = Destination::find($id);
        $request = $request->all();
        $destination->fill($request)->save();
        $message = $destination ? 'Categoría actualizada correctamente' : 'La categoría NO pudo actualizarse';
        return redirect()->route('manageProduct-A')->with('message', $message);
    }
    public function destroy($id)
    {
        $destination = Destination::find($id);
        $destination->delete();
        $message = $destination ? 'Categoría eliminada correctamente' : 'La categoría NO pudo eliminarse';
        return redirect()->route('manageProduct-A')->with('message', $message);
    }
}
