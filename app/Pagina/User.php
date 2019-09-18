<?php

namespace App\Pagina;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user_webs';
    protected $fillable = [
        'dni', 'name', 'lastname', 'email', 'password', 'pais_id', 'ciudad_id', 'role', 'address', 'imagen',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function agency(){
        return $this->hasOne(Agency::class,'user_webs_id');
    }
    public function reservations(){
        return $this->hasMany(Reservation::class,'user_web_id');
    }
}
