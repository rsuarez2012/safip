<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaginaComunidad extends Model
{
    protected $table = 'paginacomunidades';
    protected $fillable = ['adulto','estudiante'];
}
