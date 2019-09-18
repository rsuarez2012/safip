<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class WebLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $email = 'email';
    protected $redirectTo = '/tablero';
    protected $guard='userweb';


    public function getLogin(){
        if (Auth::guard('userweb')->check()){
            return redirect()->route('indexweb');
        }
        $message2 = "No ha Iniciado session en el sistema!";
        return redirect()->back()->with('message2', $message2);
    }


    public function postLogin(Request $request){

        $auth = Auth::guard('userweb')->attempt(['email'=>$request->email, 'password'=>$request->password, 'active'=>1]);

        if ($auth){
            if(Auth::User()->type_user == 1 ){
                return redirect()->route('tablero');
            }
            if(Auth::User()->type_user == 2 ){
                return redirect()->route('indexweb');
            }
            if(Auth::User()->type_user == 3 ){
                return redirect()->route('indexweb');
            }

        }
        $message2 = "Usurio o Clave de Cliente Incorrecto!";
        return redirect()->back()->with('message2', $message2);
    }


    public function getLogout(){
        Auth::guard('userweb')->logout();
        $message = "Vuelve Pronto!";
        return redirect()->route('indexweb')->with('message', $message);
    }
}
