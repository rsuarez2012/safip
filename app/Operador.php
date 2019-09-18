<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Operador extends Authenticatable{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */ 
    protected $table = 'operadores';
    protected $fillable = [
        'id','empresas_id','nombre', 'rif', 'direccion',
        'telefono','email','web','descripcion','users_id','updated_by', 'categoria_id', 'destino_id'
    ];
   
    // CATEGORIA
    public function categoria(){
        return $this->belongsTo('\App\Pagina\PaginaCategoriaOperador','categoria_id');
    }

    // DESTINO
    public function destino(){
        return $this->belongsTo('\App\Pagina\PaginaDestino','destino_id');
    }

    // SERVICIOS 
    public function servicios(){
        return $this->hasMany(Pagina\PaginaServicio::class);
    }
    public function emails(){
        return $this->hasMany(Email::class);
    }
    public function empresas(){
        return $this->belongsTo('App\Empresa');
    }

    public function cotizaciones(){
        return $this->belongsTo('App\Cotizacion');
    }

    public function scopeBusqueda($query,$dato=""){
        if($dato==""){
            alert("Debe escribir algo en el campo de busqueda");
        }else{

            $resultado= $query->where('nombre','like','%'.$dato.'%')
                ->orWhere('rif','like', '%'.$dato.'%')
                ->orWhere('email','like', '%'.$dato.'%');
        }
        return  $resultado;
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
