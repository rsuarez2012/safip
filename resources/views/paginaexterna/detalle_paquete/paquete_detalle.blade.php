@extends('paginaexterna.index')

@section('titulo', 'Detalle del Pquete')

@section('css')
<style type="text/css">
.carousel-inner img {
    width: 100%;
    height: 100%;
}
</style>
@endsection

@section('script')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
@endsection

@section ('content')
<div class="clearfix"></div>
<div class="contenido2 contenidos-custom">
    <div class="col-sm-12"></div>
    <h3 class="seccion-titulos">Detalles del Paquete</h3>
    <div class="row">
        <div class="col-sm-8">
            <div class="captionpaquet">
                <img style="width: 601.78px; height: 225.66px;" src="{{asset('uploads/images/products').'/'.$product->imagen}}" alt="Los Angeles">
                <div class="cap2">
                    <h4>@if((($product->duracion)-(1)) == 0)
                    1 Día
                    @else
                    {{($product->duracion)-(1)}} Noches</h4>
                    @endif</h4>
                    </div>
                    <div class="cap1">
                    <h4>{{$product->destino}} Salida: 20 Mayo</h4>
                    </div>
                    </div>
                    </div>
                    <div class="col-sm-4">
                    <h4>Destino</h4>
                    <p>{{$product->destino}}</p>
                    <h4>Desde</h4>
                    <div class="precio_paquete"> S/.{{$product->precio_sol}} ó
                    US$/.{{$product->precio_dolar}}</div>
                    <ul class="lista-detail-inccom">
                    <li class="text-primary2">
                    <div><em>Servicio:</em></div>
                    <p>{{$product->servicio}}</p>
                    </li>
                    <li class="text-primary2">
                    <div><em>Vigencia:</em></div>
                    <p>Jueves, 10 de Mayo del 2018</p>
                    </li>
                    </ul>
                    @if (Auth::guest())

                    <button type="button" id="btn-reservar" class="btn btn-detail-prod btn-block" data-toggle="modal" data-target="#myModal2" >Reservar</button>
                    @else
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('detalle_paquete_pasajero') }}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <input type="hidden" name="paquete_id" value="{{$product->id}}">
                        <button type="submit"  id="btn-reservar2" class="btn btn-detail-prod btn-block">Reservar</button>
                    </form>
                    @endif
                </div>
            </div>
            <div class="row"><hr></div>
            <div class="row">
                <div class="col-sm-12"><h4>CATEGORIA</h4></div>
                <div class="tags-category"><span>{{$product->categoria}}</span></div>
            </div>
            <div class="row"><hr></div>
            @if(sizeof($Includes) >= 1)
            <div class="row">
                <div class="col-sm-12"><h4>INCLUIDO</h4></div>
                <div class="col-sm-12 mods-inclu">
                    <ul>
                        @foreach($Includes as $inclu)
                        <li>{{$inclu->descripcion}}</li>

                        @endforeach
                    </ul>
                </div>
            </div>
            @else
            @endif
            <div class="row"><hr></div>
            @if(sizeof($Not_include) >= 1)
            <div class="row">
                <div class="col-sm-12"><h4>NO INCLUIDO</h4></div>
                <div class="col-sm-12 mods-inclu">
                    <ul>
                        @foreach($Not_include as $Not_inclu)
                        <li>{{$Not_inclu->descripcion}}</li>

                        @endforeach
                    </ul>
                </div>
            </div>
            @else
            @endif

            <div class="row"><hr></div>
            @if(sizeof($Itinerary) >= 1)
            <div class="row">
                <div class="col-sm-12"><h4>ITINERARIO:</h4></div>
                <div class="col-sm-12 mods-inclu">
                    <ul>
                        @foreach($Itinerary as $Iti)
                        <li>
                            <h4>{{$Iti->descripcion}}</h4>
                            <p>{{$Iti->fecha}}</p>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>@else
            @endif


            <div class="row"><hr></div>
            @if(sizeof($Recommendations_to_carry) >= 1)
            <div class="row">
                <div class="col-sm-12"><h4>RECOMENDACIONES A LLEVAR</h4></div>
                <div class="col-sm-12 mods-inclu">
                    <ul>
                        @foreach($Recommendations_to_carry as $Recommendations)
                        <li>{{$Recommendations->descripcion}}</li>

                        @endforeach
                    </ul>
                </div>
            </div>
            @else
            @endif
            @if(sizeof($Important_note) >= 1)
            <div class="row">
                <div class="col-sm-12"><h4>NOTA IMPORTANTE</h4></div>
                <div class="col-sm-12 mods-inclu">
                    <ul>
                        @foreach($Important_note as $Important)
                        <li>{{$Important->descripcion}}</li>

                        @endforeach
                    </ul>
                </div>
            </div>
            @else
            @endif
            @if(sizeof($Reservation_polices) >= 1)
            <div class="row">
                <div class="col-sm-12"><h4>POLITICAS DE RESERVA</h4></div>
                <div class="col-sm-12 mods-inclu">
                    <ul>
                        @foreach($Reservation_polices as $Reservation)
                        <li>{{$Reservation->descripcion}}</li>

                        @endforeach
                    </ul>
                </div>
            </div>
            @else
            @endif
            @if(sizeof($Polices_of_our_rates) >= 1)
            <div class="row">
                <div class="col-sm-12"><h4>POLITICA DE NUESTRAS TARIFAS:</h4></div>
                <div class="col-sm-12 mods-inclu">
                    <ul>
                        @foreach($Polices_of_our_rates as $Polices)
                        <li>{{$Polices->descripcion}}</li>

                        @endforeach
                    </ul>
                </div>
            </div>
            @else
            @endif

            @if(sizeof($Special_dates) >= 1)
            <div class="row">
                <div class="col-sm-12"><h4>FECHAS ESPECIALES:</h4></div>
                <div class="col-sm-12 mods-inclu">
                    <ul>
                        @foreach($Special_dates as $Special)
                        <li>{{$Special->descripcion}}</li>

                        @endforeach
                    </ul>
                </div>
            </div>
            @else
            @endif
            @if(sizeof($Resposanbilities) >= 1)
            <div class="row">
                <div class="col-sm-12"><h4>RESPONSABILIDADES:</h4></div>
                <div class="col-sm-12 mods-inclu">
                    <ul>
                        @foreach($Resposanbilities as $Respo)
                        <li>{{$Respo->descripcion}}</li>

                        @endforeach
                    </ul>
                </div>
            </div>
            @else
            @endif
            @if(sizeof($Resposanbilities) >= 1)
            <div class="row">
                <div class="col-sm-12"><h4>TARIFAS POR PERSONA EN US$</h4></div>
                <div class="col-sm-12 mods-inclu">
                    <table>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="4">Extranjero</td>
                            <td colspan="4">Peruano</td>
                            <td colspan="2"></td>
                        </tr>
                        <tr class="text-center">
                            <td>&nbsp;</td>
                            <td>Hotel</td>
                            <td>*</td>
                            <td>Categoria</td>
                            <td>SWB</td>
                            <td>DWB</td>
                            <td>TPL</td>
                            <td>CHD</td>
                            <td>SWB</td>
                            <td>DWB</td>
                            <td>TPL</td>
                            <td>CHD</td>
                            <td>Check In</td>
                            <td>Check Out</td>
                        </tr>
                         @foreach($PaquetePersonas as $fila)
                        <tr>
                            <td><input type="radio"></td>
                            <td>{{$fila->hotel}}</td>
                            <td>{{$fila->star}}</td>
                            <td>{{$fila->categoria}}</td>
                            <td>{{$fila->e_swb}}</td>
                            <td>{{$fila->e_dwb}}</td>
                            <td>{{$fila->e_tpl}}</td>
                            <td>{{$fila->e_chd}}</td>
                            <td>{{$fila->p_swb}}</td>
                            <td>{{$fila->p_dwb}}</td>
                            <td>{{$fila->p_tpl}}</td>
                            <td>{{$fila->p_chd}}</td>
                            <td>{{$fila->check_in}}</td>
                            <td>{{$fila->check_out}}</td>
                        </tr>
                    @endforeach
                    </table>
                </div>
            </div>
            @else
            @endif

            <br>
            <br>
        </div>
        @include('paginaexterna.register.modal_register')
        @endsection
