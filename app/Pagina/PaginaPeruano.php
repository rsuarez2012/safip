<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaginaPeruano extends Model
{
    protected $table = 'paginaperuanos';
    protected $fillable = ['adulto','estudiante','ninio'];
}
