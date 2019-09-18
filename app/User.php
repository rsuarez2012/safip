<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
class User extends Authenticatable 
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $fillable = [
        'id', 'role_id',
        'role', 'apellidos',
        'nombres', 'email',
        'password','pais_id','ciudad_id',
        'direccion','telefono','imagen',
        'active','code','boletos','ncppagar',
        'ancppagar','ncpcobrar',',ancpcobrar',
        'vboletos','cclave','pconso','deuaviajes','opb','empresa','consolidadores','usuarios',
        'gastos','deudas','banco','caja_chica','igv','agentes','agencias_viajes','lineas_aereas','incentivos',
        'paises','ciudades','pasajeros','comision','operadores','type_user','razon_social','representante_legal','distrito',
        'aniversario','sitio_web','telefono_corporativo','nomina'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function deudas(){

        return $this->hasMany('App\Deuda');
    }

    public function gastos(){

        return $this->hasMany('App\Gasto');
    }

    public function roles(){
        return $this->hasOne('App\User','id','role_id');
    }

    public function clientes(){
        return $this->hasOne('App\User','id','role_id');
    }
    public function pais(){
        return $this->belongsto('App\Pais');
    }
    public function ciudad(){
        return $this->belongsto('App\Ciudad');
    }
     public function VboletoP()
    {
        return $this->hasOne('App\VboletoP');
    }


    private function checkIfUserHasRole($need_role){
        return (strtolower($need_role) == strtolower(Auth::User()->role_id)) ? true : null;
        //return (strtolower($need_role) == strtolower($this->roles->role_id)) ? true : null;
    }

    public function hasRole($roles){
        if (is_array($roles)) {
            foreach ($roles as $need_role){
                if ($this->checkIfUserHasRole($need_role)){
                    return true;
                }
            }
        }else {
            return $this->checkIfUserHasRole($roles);
        }
        return false;
    }
}
