<?php

namespace App\Http\Controllers;

use App\Aviaje;
use App\Cliente;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use App\User;
use App\Agente;
use App\Empresa;
use App\Sucursal;
use App\Role;
use Auth;
use Mail;

class CorreoController extends Controller
{
    public function __construct() {
        $this->middleware('web');
    }

    public function correo(Request $request){
        $fromEmail = 'qantutra@gmail.com';
        $fromName = 'Qantu Travel';
        $subject = $request->asunto;
        $data['datos'] = $request->editor;
        $clientesc = Cliente::where('nombre','like','%'.'@'.'%')
            ->orWhere('apellido','like', '%'.'@'.'%')
            ->orWhere('email','like', '%'.'@'.'%')->get();
        $clientes = $clientes = Cliente::orderBy('created_at', 'desc')->paginate(10);
        if($request->tipoenv == 1){
            for($i=0; $i <sizeof($clientesc);$i++){
                $toEmail = $clientesc[$i]->email;
                $toName = $clientesc[$i]->nombre." ".$clientesc[$i]->apellido;
                Mail::send('correos.correos', $data, function($message) use ($toEmail, $toName, $fromEmail, $fromName, $subject){
                    $message->to($toEmail, $toName);
                    $message->from($fromEmail, $fromName);
                    $message->subject($subject);
                });
            }
            $message = 'Correo Enviado!';
            return view('clientes.index', compact('clientes'))->with('message', $message);
        }else{
            for($i=0; $i<sizeof($request->correo);$i++){
                $separador = explode("@", $request->correo[$i]);
                if(sizeof($separador) > 1){
                    $toEmail = $request->correo[$i];
                    $toName = $request->nombre[$i]." ".$request->apellido[$i];
                    Mail::send('correos.correos', $data, function($message) use ($toEmail, $toName, $fromEmail, $fromName, $subject){
                        $message->to($toEmail, $toName);
                        $message->from($fromEmail, $fromName);
                        $message->subject($subject);
                    });
                }
            }
            $message = 'Correo Enviado!';
            return view('clientes.index',compact('clientes'))->with('message', $message);
        }
    }

    public function correoAv(Request $request){
        $fromEmail = 'qantutra@gmail.com';
        $fromName = 'Qantu Travel';
        $subject = $request->asunto;
        $data['datos'] = $request->editor;
        $clientes = Aviaje::where('nombre','like','%'.'@'.'%')
            ->orWhere('email','like', '%'.'@'.'%')->get();

        if($request->tipoenv == 1){
            for($i=0; $i <sizeof($clientes);$i++){
                $toEmail = $clientes[$i]->email;
                $toName = $clientes[$i]->nombre;
                Mail::send('correos.correos', $data, function($message) use ($toEmail, $toName, $fromEmail, $fromName, $subject){
                    $message->to($toEmail, $toName);
                    $message->from($fromEmail, $fromName);
                    $message->subject($subject);
                });
            }
            $message = 'Correo Enviado!';
            return view('aviajes.index')->with('message', $message);
        }else{
            for($i=0; $i<sizeof($request->correo);$i++){
                $separador = explode("@", $request->correo[$i]);
                if(sizeof($separador) > 1){
                    $toEmail = $request->correo[$i];
                    $toName = $request->nombre[$i];
                    Mail::send('correos.correos', $data, function($message) use ($toEmail, $toName, $fromEmail, $fromName, $subject){
                        $message->to($toEmail, $toName);
                        $message->from($fromEmail, $fromName);
                        $message->subject($subject);
                    });
                }
            }
            $message = 'Correo Enviado!';
            return view('aviajes.index')->with('message', $message);
        }
    }
    public function correoOp(Request $request){
        $fromEmail = 'qantutra@gmail.com';
        $fromName = 'Qantu Travel';
        $subject = $request->asunto;
        $data['datos'] = $request->editor;
        $clientes = Aviaje::where('nombre','like','%'.'@'.'%')
            ->orWhere('email','like', '%'.'@'.'%')->get();

        if($request->tipoenv == 1){
            for($i=0; $i <sizeof($clientes);$i++){
                $toEmail = $clientes[$i]->email;
                $toName = $clientes[$i]->nombre;
                Mail::send('correos.correos', $data, function($message) use ($toEmail, $toName, $fromEmail, $fromName, $subject){
                    $message->to($toEmail, $toName);
                    $message->from($fromEmail, $fromName);
                    $message->subject($subject);
                });
            }
            $message = 'Correo Enviado!';
            return view('operadores.index')->with('message', $message);
        }else{
            for($i=0; $i<sizeof($request->correo);$i++){
                $separador = explode("@", $request->correo[$i]);
                if(sizeof($separador) > 1) {
                    $toEmail = $request->correo[$i];
                    $toName = $request->nombre[$i];
                    Mail::send('correos.correos', $data, function ($message) use ($toEmail, $toName, $fromEmail, $fromName, $subject) {
                        $message->to($toEmail, $toName);
                        $message->from($fromEmail, $fromName);
                        $message->subject($subject);
                    });
                }
            }
            $message = 'Correo Enviado!';
            return view('operadores.index')->with('message', $message);
        }
    }
}
