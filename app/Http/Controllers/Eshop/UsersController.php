<?php

namespace App\Http\Controllers\Eshop;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Requests\UserRequest;
use Mail;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role_id','=','2')->get();
        return view('e-shop.users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('e-shop.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = new User($request->all());
        $user->password = bcrypt($request->password);
        $user->save();
        $message = $user ? 'Usuario agregado correctamente' : 'El usuario NO pudo agregarse';
        return redirect()->route('e-shop.users.index')->with('message', $message);
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
        $user = User::find($id);
        return view('e-shop.users.edit')->with('user', $user);
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
        $user = User::find($id);
        $request = $request->all();
        $user->fill($request)->save();
        $message = $user ? 'Usuario actualizado correctamente' : 'El usuario NO pudo actualizarse';
        return redirect()->route('e-shop.users.index')->with('message', $message);
    }

    public function status($id){

        $usuarios = User::where('id','=', $id)->first();
        if ($usuarios->active == '0'){
            $user= User::find($id);
            $user = User::where('id','=', $id)->first();
            $user->active   = "1";
            $user->save();
            $fromEmail = 'qantutra@gmail.com';
            $fromName = 'Qantu Travel';
            $subject = "No Responder, Autorizacion de QantuTravel";
            $data['datos'] = "Su usuario ya se encuentra autorizado a Ingresar a la pagina. ";
            $toEmail = $user->email;
            $toName =  $user->nombre." ". $user->apellido;
            Mail::send('correos.correos', $data, function($message) use ($toEmail, $toName, $fromEmail, $fromName, $subject){
                $message->to($toEmail, $toName);
                $message->from($fromEmail, $fromName);
                $message->subject($subject);
            });
            $message = $user?'Se ha actualizado el registro'. $user->nombres .' '. $user->apellidos .', se Habilito de forma exitosa.' : 'Error al actualizar';

            return redirect()->route('manageUser-A')->with('message', $message);
        }else {
            if ($usuarios->active == '1')
                $user = User::find($id);
            $user = User::where('id', '=', $id)->first();
            $user->active = "0";
            $user->save();

            $fromEmail = 'qantutra@gmail.com';
            $fromName = 'Qantu Travel';
            $subject = "No Responder, Autorizacion de QantuTravel";
            $data['datos'] = "Su usuario fue desabilido por un administrador por los momentos no puede Ingresar a la pagina. ";
            $toEmail = $user->email;
            $toName =  $user->nombre." ". $user->apellido;
            Mail::send('correos.correos', $data, function($message) use ($toEmail, $toName, $fromEmail, $fromName, $subject){
                $message->to($toEmail, $toName);
                $message->from($fromEmail, $fromName);
                $message->subject($subject);
            });
            $message2 = $user?'Se ha actualizado el registro'. $user->nombres .' '. $user->apellidos .', se Desabilito de forma exitosa.' : 'Error al actualizar';
            return redirect()->route('manageUser-A')->with('message2', $message2);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        $message = $user ? 'Usuario eliminado correctamente' : 'El usuario NO pudo eliminarse';
        return redirect()->route('e-shop.users.index')->with('message', $message);
    }
}
