<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaginaCategoriaPaquete extends Model
{
    protected $table = 'paginacategoriapaquetes';
    protected $fillable = ['nombre'];

    public function paquetes(){
        return $this->hasMany(PaginaPaquete::class,'categoria_id');
    }
}
