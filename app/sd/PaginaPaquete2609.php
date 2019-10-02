<?php

namespace App\Pagina;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class PaginaPaquete extends Model
{
    //use SoftDeletes; 

    //protected $dates = ['deleted_at'];

    protected $table = 'paginapaquetes';
    protected $fillable = ['nombre','estado','utilidad_promocion','percent_full_day','descripcion',
                           'extracto','imagen','categoria_id','codigo','statusCreado',
                           'tipo_tarifa'];
    // CATEGORIA
    public function categoria(){
    	return $this->belongsTo('\App\Pagina\PaginaCategoriaPaquete','categoria_id');
    }
    // LISTADOS
    public function listados(){
    	return $this->hasMany('\App\Pagina\PaginaDestinoPaquete','paquete_id');
    }
    // DIAS 
    public function dias(){
    	return $this->hasMany('\App\Pagina\PaginaDia','paquete_id');
    }
    // ENLAZADOS
    public function enlazados(){
        return $this->hasMany('\App\Pagina\PaginaListado','paquete_id');
    }
    // DATOS 
    public function datos(){
        return $this->hasMany('\App\Pagina\PaginaDatoPaquete','paquete_id');
    }
    public function salidas(){
        return $this->hasMany('\App\Pagina\SalidaConfirmada','paquete_id');
    }
    public function reservations(){
        return $this->hasMany(Reservation::class, 'paquete_id');
    }

    public function getEnlazados($paquete){
        $enlazados = []; 
        $ultimo="";
        
        foreach ($paquete->enlazados as $enlace) {
            if ($ultimo == $enlace->codigo) {
                // VARIABLE CON NOCHES
                $noches = $enlace->noches->cantidad;
                // AGREGAR HOTEL A LA LISTA
                array_push($enlazados[$ultimo]['hoteles'],$enlace->hotel->nombre);
                // SUMAR TARIFAS DEL HOTEL
                $enlazados[$ultimo]['e_swb']+=($enlace->hotel->e_swb * $noches);
                $enlazados[$ultimo]['e_dwb']+=(($enlace->hotel->e_dwb * $noches)/2);
                $enlazados[$ultimo]['e_tpl']+=(($enlace->hotel->e_tpl * $noches)/3);
                $enlazados[$ultimo]['e_chd']+=($enlace->hotel->e_chd * $noches)/4;
                $enlazados[$ultimo]['p_swb']+=($enlace->hotel->p_swb * $noches);
                $enlazados[$ultimo]['p_swb']+=(($enlace->hotel->p_dwb * $noches)/2);
                $enlazados[$ultimo]['p_tpl']+=(($enlace->hotel->p_tpl * $noches)/3);
                $enlazados[$ultimo]['p_chd']+=($enlace->hotel->p_chd * $noches)/4;

                if($enlace->hotel->destino->nombre == 'CUSCO'){
                    if($enlazados[$ultimo]['check_in'] == ''){
                        $enlazados[$ultimo]['check_in'] = $enlace->hotel->check_in;
                        $enlazados[$ultimo]['check_out'] = $enlace->hotel->check_out;
                    }
                }
            }else{
                // VARIABLE CON NOCHES
                $noches = $enlace->noches->cantidad;
                // NUEVO INDICE CON DATOS
                $enlazados[$enlace->codigo] =
                ['hoteles' => [],
                'estado' => $enlace->estado,
                'codigo' => $enlace->codigo,
                'estrella' => $enlace->hotel->estrella,
                'categoria' =>$enlace->hotel->categoria->nombre,
                'e_swb' => ($enlace->hotel->e_swb * $noches),
                'e_dwb' => (($enlace->hotel->e_dwb * $noches)/2),
                'e_tpl' => (($enlace->hotel->e_tpl * $noches)/3),
                'e_chd' => ($enlace->hotel->e_chd * $noches)/4,
                'p_swb' => ($enlace->hotel->p_swb * $noches),
                'p_dwb' => (($enlace->hotel->p_dwb * $noches)/2),
                'p_tpl' => (($enlace->hotel->p_tpl * $noches)/3),
                'p_chd' => ($enlace->hotel->p_chd * $noches)/4,
                'check_in'  => '',
                'check_out' => ''];
                // AGREGO EL HOTEL AL ARRAY HOTEL 
                array_push($enlazados[$enlace->codigo]['hoteles'],$enlace->hotel->nombre);
                
                if($enlace->hotel->destino->nombre == 'CUSCO'){
                    $enlazados[$enlace->codigo]['check_in'] = $enlace->hotel->check_in;
                    $enlazados[$enlace->codigo]['check_out'] = $enlace->hotel->check_out;
                }
            }
            
            $ultimo = $enlace->codigo;
        }
        //dd($enlazados);
        return $enlazados;
    }
    public function calcularActividades($paquete){
        $total_itinerary = [ "p_adulto" => 0, "e_adulto" => 0, "c_adulto" => 0, "p_ninio" => 0, "e_ninio" => 0 ];
        foreach($paquete->dias as $dia){
            foreach($dia->actividades as $actividad){
                if ($actividad->tipo == "servicio") {
                    $total_itinerary["p_adulto"] += $actividad->servicio[0]->servicio->peruano->adulto;
                    $total_itinerary["e_adulto"] += $actividad->servicio[0]->servicio->extranjero->adulto;
                    $total_itinerary["c_adulto"] += $actividad->servicio[0]->servicio->comunidad->adulto;
                    $total_itinerary["p_ninio"] += $actividad->servicio[0]->servicio->peruano->ninio;
                    $total_itinerary["e_ninio"] += $actividad->servicio[0]->servicio->extranjero->ninio;
                } else if ($actividad->tipo == "restaurante") {
                    $total_itinerary["p_adulto"] += $actividad->restaurante[0]->restaurante->peruano->adulto;
                    $total_itinerary["e_adulto"] += $actividad->restaurante[0]->restaurante->extranjero->adulto;
                    $total_itinerary["c_adulto"] += $actividad->restaurante[0]->restaurante->comunidad->adulto;
                    $total_itinerary["p_ninio"] += $actividad->restaurante[0]->restaurante->peruano->ninio;
                    $total_itinerary["e_ninio"] += $actividad->restaurante[0]->restaurante->extranjero->ninio;
                }
            }
        }

        // nuevos calculos para cuando es full day
        if($paquete->enlazados()->where('paquete_id', $paquete->id)->where('estado', 'visible')->count() == 0){
            foreach($total_itinerary as $index => $sub){
                if($paquete->tipo_tarifa == 'promocion'){
                    $total_itinerary[$index] = $total_itinerary[$index] + $paquete->utilidad_promocion;
                }
     
                if($paquete->tipo_tarifa == 'doce'){
                    $total_itinerary[$index] = $total_itinerary[$index] / 0.88;
                }
    
                if($paquete->tipo_tarifa == 'diez'){
                    $var_doce = 12;
                    $total_itinerary[$index] = $total_itinerary[$index] / 0.88;

                    if ($total_itinerary[$index] > 0) {
                        $total_itinerary[$index] = $total_itinerary[$index] + $var_doce;
                    }

                    $total_itinerary[$index] = $total_itinerary[$index]/0.90;
                }

                if($paquete->tipo_tarifa == 'neto'){
                    if($paquete->percent_full_day > 0){
                        //$total_itinerary[$index] = (($paquete->percent_full_day / 100) * $total_itinerary[$index]) + $total_itinerary[$index];
                        $total_itinerary[$index] = $total_itinerary[$index] + $paquete->percent_full_day;
                    }
                }

                if ($total_itinerary[$index] > 0) {
                    $total_itinerary[$index] = round($total_itinerary[$index] * 100) / 100;
                }
            }
        }

        return $total_itinerary;
    }
    public function calculate_itinerary_final($paquete){
        $lista_enlazados = $this->getEnlazados($paquete);
        $costo_actividades = $this->calcularActividades($paquete);
        /* dd($lista_enlazados["$2y$10$5rOb.qClWqFMuL6KWGYA.uVxYbhLGNvjmjPGBJ5MU1YGKBhy8kMBm181218"]["e_swb"]); */
        foreach($lista_enlazados as $index => $enlazados){
            $lista_enlazados[$index]["e_swb"]  = $this->sumDoce($enlazados["e_swb"] + $costo_actividades["e_adulto"]); 
            $lista_enlazados[$index]["e_dwb"]  = $this->sumDoce($enlazados["e_dwb"] + $costo_actividades["e_adulto"]); 
            $lista_enlazados[$index]["e_tpl"]  = $this->sumDoce($enlazados["e_tpl"] + $costo_actividades["e_adulto"]); 
            $lista_enlazados[$index]["e_chd"]  = $this->sumDoce($enlazados["e_chd"] + $costo_actividades["e_ninio"]); 
            $lista_enlazados[$index]["p_swb"]  = $this->sumDoce($enlazados["p_swb"] + $costo_actividades["p_adulto"]); 
            $lista_enlazados[$index]["p_dwb_"]  = $this->sumDoce($enlazados["p_dwb"] + $costo_actividades["p_adulto"]); 
            $lista_enlazados[$index]["p_tpl"]  = $this->sumDoce($enlazados["p_tpl"] + $costo_actividades["p_adulto"]); 
            $lista_enlazados[$index]["p_chd_"]  = $this->sumDoce($enlazados["p_chd"] + $costo_actividades["p_ninio"]); 
        }
        return $lista_enlazados;
    }
    public function sumDoce($numero){
        $numero = $numero / 0.88;
        $numero = $numero + 12;
        $numero = $numero / 0.90;
        $numero = round($numero,2);
        return $numero;
    }
}
