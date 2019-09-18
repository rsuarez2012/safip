<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['id','name'];

    public $timestamps = false;

    public function users(){

    return $this->hasMany('App\User','role_id','id');

    }

}
