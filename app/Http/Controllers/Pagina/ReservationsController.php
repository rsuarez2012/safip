<?php

namespace App\Http\Controllers\Pagina;

use App\Pagina\Tiket;
use App\Pagina\Reservation;
use Illuminate\Http\Request;
use App\Pagina\ContactReservation;
use App\Http\Controllers\Controller;

class ReservationsController extends Controller
{
    public function solicitudes()
    {
    	$solicitudes = Reservation::orderBy('id', 'DESC')->get();
    	$solicitudes->load('paquete.listados.destino', 'user', 'tikets.people', 'contactos.contact.people');
    	return $solicitudes;
    }

    public function aprobar(Request $request)
    {
    	$reservation = Reservation::findOrFail($request->id);
        $reservation->status = 'approved';
        $reservation->codigo_referencia = $request->refer_code;
        $reservation->status_pago = 'pagada';
    	$reservation->update();
    	return;
    }

    public function rechazar(Request $request)
    {
    	$reservation = Reservation::findOrFail($request->id);
    	$reservation->status = 'rejected';
        $reservation->observacion = $request->observacion;
    	$reservation->update();
    	return;
    }

    public function eliminar(Reservation $reservation)
    {
        //$reservation = Reservation::findOrFail($reservation);
        $reservation->load('tikets', 'contactos');
        if($reservation->tikets->count() > 0){
            foreach($reservation->tikets as $ticket){
                $ticket = Tiket::findOrFail($ticket->id);
                $ticket->delete();
            }
        }
        if($reservation->contactos->count() > 0){
            foreach($reservation->contactos as $contacto){
                $contacto = ContactReservation::findOrFail($contacto->id);
                $contacto->delete();
            }
        }
        $reservation->delete();
        return;
    }
}
