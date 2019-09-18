<?php

namespace App\Pagina;
use App\Operador;

use Illuminate\Database\Eloquent\Model;

class PaginaCategoriaOperador extends Model
{
    protected $table = 'paginacategoriaoperadores';
    protected $fillable = ['nombre'];

    public function operadores(){
    	return $this->hasMany(Operador::class, 'categoria_id');
    }
}
