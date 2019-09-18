<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaginaCategoriaHotel extends Model
{
    protected $table = 'paginacategoriahoteles';
    protected $fillable = ['nombre'];

    public function hoteles(){
    	return $this->hasMany(PaginaHotel::class, 'categoria_id');
    }
    public function getInfoAttribute()
    {
    	return $this->nombre;
    }
}
