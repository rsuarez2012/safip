<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Userweb extends Authenticatable
{
    use Notifiable;

    protected $guard = 'userweb';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'usersweb';
    protected $fillable = [
        'id', 'role_id',
        'role', 'apellidos',
        'nombres', 'email',
        'password','pais','ciudad',
        'direccion','telefono','imagen',
        'active','type_user'
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



   private function checkIfUserHasRole($need_role){
    return (strtolower($need_role) == strtolower($this->roles->role_id)) ? true : null;
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
