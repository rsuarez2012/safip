<?php

namespace App\Http\Controllers\Pagina;


use App\Pagina\User;
use App\Pagina\Agency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
class AgencyController extends Controller
{
    public function index()
    {
        $solicitudes = Agency::orderBy('updated_at','DESC')->get();
        return view('adminweb/solicitudes/index',compact('solicitudes'));
    }

    public function update(Request $data)
    {
        $agencia=Agency::find($data->input_agencia);
        $agencia->status  = $data->input_status;
        $agencia->message = $data->message;
        $agencia->save();
        $fromEmail = 'qantutra@gmail.com';
        $fromName = 'Qantu Travel';
        $subject = 'Solicitud De Registro Qantutarvel.com';
        $data = ['agency' => $agencia];
        $toEmail = $agencia->user->email;
        $toName = $agencia->user->name;
        /* dd($agencia,$toEmail,$toName,$fromEmail,$fromName); */
            Mail::send('adminweb.solicitudes.email', $data, function($message) use ($toEmail, $toName, $fromEmail, $fromName, $subject){
                $message->to($toEmail, $toName);
                $message->from($fromEmail, $fromName);
                $message->subject($subject);
            });
            return redirect('/solicitudes/agencias');
    }

    public function destroy(Agency $agencia)
    {
        /* $agencia->delete();
        return; */
    }
}
