<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $email = 'email';
    protected $redirectTo = '/tablero';
    protected $guard='web';

    public function getLogin(){
        if (Auth::guard('web')->check()){
            return redirect()->route('tablero');
        }
        return view('login');
    }
    public function postLogin(Request $request){

        $auth = Auth::guard('web')->attempt(['email'=>$request->email, 'password'=>$request->password, 'active'=>1]);

        if ($auth){
            if(Auth::User()->type_user == 1 ){
                $message = "Bienvenido!";
                return redirect()->route('tablero')->with('message', $message);
            }
            if(Auth::User()->type_user == 2 ){
                $message = "Bienvenido!";
                return redirect()->route('indexweb')->with('message', $message);
            }
            if(Auth::User()->type_user == 3 ){
                $message = "Bienvenido!";
                return redirect()->route('indexweb')->with('message', $message);
            }

        }else{
        $message2 = "Usurio o Clave Incorrecto!";
        return redirect()->back()->with('message2', $message2);
        }
    }

    public function postLogin2(Request $request){

        $auth = Auth::guard('web')->attempt(['email'=>$request->email, 'password'=>$request->password, 'active'=>1]);

        if ($auth){
            if(Auth::User()->type_user == 1 ){
                $message = "Bienvenido!";
                return redirect()->route('tablero')->with('message', $message);
            }
            if(Auth::User()->type_user == 2 ){
                $message = "Bienvenido!";
                return redirect()->route('indexweb')->with('message', $message);
            }
            if(Auth::User()->type_user == 3 ){
                $message = "Bienvenido!";
                return redirect()->route('indexweb')->with('message', $message);
            }

        }else{
            $message2 = "Usurio o Clave Incorrecto!";
            return redirect()->back()->with('message2', $message2);
        }
    }

    public function postLogin3(Request $request){

        $auth = Auth::guard('web')->attempt(['email'=>$request->email, 'password'=>$request->password, 'active'=>1]);

        if ($auth){
            if(Auth::User()->type_user == 1 ){
                $message = "Bienvenido!";
                return redirect()->route('tablero')->with('message', $message);
            }
            if(Auth::User()->type_user == 2 ){
                $message = "Bienvenido!";
                return redirect()->route('myacount')->with('message', $message);
            }
            if(Auth::User()->type_user == 3 ){
                $message = "Bienvenido!";
                return redirect()->route('myacount')->with('message', $message);
            }

        }else{
            $message2 = "Usurio o Clave Incorrecto!";
            return redirect()->back()->with('message2', $message2);
        }
    }

    public function postLoginweb(Request $request){

        $auth = Auth::guard('usersweb')->attempt(['email'=>$request->email, 'password'=>$request->password, 'active'=>1]);

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

        }else{
        $message2 = "Usurio o Clave Incorrecto!";
        return redirect()->back()->with('message2', $message2);
        }
    }

    public function getLogout(){
        Auth::guard('web')->logout();
        $message = "Vuelve Pronto!";
        return redirect()->route('/')->with('message', $message);
    }
    public function getLogout2(){
        Auth::guard('web')->logout();
        $message = "Vuelve Pronto!";
        return redirect()->route('indexweb')->with('message', $message);
    }
}
