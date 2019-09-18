<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaginaExtranjero extends Model
{
    protected $table = 'paginaextranjeros';
    protected $fillable = ['adulto','estudiante','ninio'];
}
