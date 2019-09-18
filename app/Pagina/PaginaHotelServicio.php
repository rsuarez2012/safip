<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;

class PaginaHotelServicio extends Model
{
    protected $table = 'hotel_servicio';
    protected $fillable = ['hotel_id','servicio_id'];
    public function servicios()
    {
        return $this->belongsTo('App\Pagina\Servicio', 'servicio_id');
    }
    public function hoteles()
    {
        return $this->belongsTo('App\Pagina\PaginaHotel');
    }
    
}
