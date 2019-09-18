@extends('paginaexterna.index')

@section('titulo', 'Reserva de Paquete')

@section('css')

@endsection

@section('script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#passengerbtn').click(function(e) {
                e.preventDefault();
//alert('hola');
                $.each(document.querySelectorAll("#pasajeros tbody"), function (index, val) {
                    $(val).append("<tr>" +
                        "<td style='border: 0px;'>"+
                        "<div class='row'>"+
                        "<div class='col-lg-6 col-md-6 col-sm-6'>"+
                        "<div class='form-group'>"+
                        "<input style='border: 1px solid #cbcbcb; ' class=' form-control input-sm' type='text' name='nombret[]' placeholder='Nombre/s'>"+
                        "</div>"+
                        "</div>"+
                        "<div class='col-lg-6 col-md-6 col-sm-6'>"+
                        "<div class='form-group'>"+
                        "<input style='border: 1px solid #cbcbcb; ' class=' form-control input-sm' type='text'   name='apellidot[]' placeholder='Apellido/s'>"+
                        "</div>"+
                        "</div>"+
                        "<div class='col-lg-6 col-md-6 col-sm-6'>"+
                        "<div class='form-group'>"+
                        "<input style='border: 1px solid #cbcbcb;' class=' form-control input-sm' type='email'   name='correot[]' placeholder='Correo'>"+
                        "</div>"+
                        "</div>"+
                        "<div class='col-lg-6 col-md-6 col-sm-6'>"+
                        "<div class='form-group'>"+
                        "<input style='border: 1px solid #cbcbcb; ' class=' form-control input-sm' type='text'   name='numero_de_telefonot[]' placeholder='Numero de Telefono'>"+
                        "</div>"+
                        "</div>"+
                        "<div class='col-lg-6 col-md-6 col-sm-6'>"+
                        "<div class='form-group'>"+
                        "<select style='border: 1px solid #cbcbcb; '  class=' form-control form-select2-tipodocumento select2-hidden-accessible' type='text'   name='tipo_documentot[]'>"+
                     "<option value=''>Tipo de Documento</option>"+
                    "<option value='dni'>DNI</option>"+
                    "<option value='pasaporte'>Pasaporte</option>"+
                     "<option value='carne_extranjeria'>Carné de Extranjeria</option>"+
                    "</select>"+
                    "</div>"+
                    "</div>"+
                    "<div class='col-lg-6 col-md-6 col-sm-6'>"+
                        "<div class='form-group'>"+
                        "<input style='border: 1px solid #cbcbcb;' class=' form-control form-select2-tipodocumento select2-hidden-accessible' type='text'   name='numerot[]' placeholder='Numero de documento'>"+
                        "</div>"+
                        "</div>"+
                        "</div>"+
                        "</td>"+
                        "<td style='border: 0px;'><button type='button' class='btn btn-danger btn-sm button_eliminar_producto'> Eliminar </button></td></tr>");
                });
            });

            $('#pasajeros').on('click', '.button_eliminar_producto', function(){

                $(this).parents('tr').eq(0).remove();
            });
        });
    </script>
@endsection

@section ('content')

    <div class="clearfix"></div>
    <div class="contenido2 contenidos-custom">
        <div class="col-sm-12"></div>
        <div class="col-sm-12">
            <hr><h4>DETALLES DE PASAJERO</h4></div>
        <!--<h3 class="seccion-titulos">Detalles del Pasajero</h3>-->
        <div class="row">
            <div class="clearfix"></div>

            <br>
            <div class="col-md-5"></div>
            <div class="col-md-2">
                <!-------dias de duracion----->
                <label for="description">Pasajeros:</label>
                <button type="button" id="passengerbtn" name="passengerbtn" class=" passenger btn btn-success btn-danger btn-sm " href="">Agregar Pasajero</button>
            </div>
            <div class="col-md-5"></div>
            <div class="clearfix"></div>
            <div class="col-sm-8">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('detalle_paquete_pasajero2') }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                <table class="table table-responsive table-bordered table-condensed" style="border: 0px;" id="pasajeros">
                    <thead>
                    <tr>
                        <th style="border: 0px;"></th>
                                    <th style="border: 0px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="border: 0px;">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <input required style="border: 1px solid #cbcbcb; " class=" form-control input-sm" type="text" name="nombret[]" placeholder="Nombre/s">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <input required style="border: 1px solid #cbcbcb; " class=" form-control input-sm" type="text"   name="apellidot[]" placeholder="Apellido/s">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <input required style="border: 1px solid #cbcbcb;" class=" form-control input-sm" type="email"   name="correot[]" placeholder="Correo">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <input required style="border: 1px solid #cbcbcb; " class=" form-control input-sm" type="text"   name="numero_de_telefonot[]" placeholder="Numero de Telefono">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <select required style="border: 1px solid #cbcbcb; "  class=" form-control form-select2-tipodocumento select2-hidden-accessible" type="text"   name="tipo_documentot[]">
                                            <option value="">Tipo de Documento</option>
                                            <option value="dni">DNI</option>
                                            <option value="pasaporte">Pasaporte</option>
                                            <option value="carne_extranjeria">Carné de Extranjeria</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <input required style="border: 1px solid #cbcbcb;" class=" form-control form-select2-tipodocumento select2-hidden-accessible" type="text"   name="numerot[]" placeholder="Numero de documento">
                                    </div>
                                </div>
                            </div>
                        </td>
                        <!--<td style="border: 0px;"><button type='button' class='btn btn-danger btn-sm button_eliminar_producto'> Eliminar </button></td>-->
                    </tr>
                    </tbody>
                </table>

                <div class="row">
                    <hr>
                    <div class="col-sm-12"><h4>COMENTARIOS</h4></div>
                    <div class="col-sm-12"><textarea style="border: 1px solid #cbcbcb; border-radius: 1%;" name="" id="" cols="60" rows="10"></textarea></div>
                </div>

                <div class="row">
                    <hr>

                    <div class="portlet-cotiza-title">
                        <div class="caption">
                            <h4 class="caption-subject">
                                Información de contacto
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <input type="hidden" name="paquete_id" value="{{$paquete->id}}">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="form-group">
                            <input required id="text-cnombre" name="text_cnombre" type="text" class="form-control input-sm" autocomplete="off" placeholder="Nombre/s">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="form-group">
                            <input required id="text-capellido" name="text_capellido" type="text" class="form-control input-sm" autocomplete="off" placeholder="Apellido/s">
                        </div>
                    </div>


                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="form-group">
                            <input required id="text-ccorreo" name="text_ccorreo" type="text" class="form-control input-sm" autocomplete="off" placeholder="Correo electronico">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="form-group">
                            <input required id="text-ctelefono" name="text_ctelefono" type="text" class="form-control input-sm" autocomplete="off" placeholder="Numero de teléfono">
                        </div>
                    </div>


                    <div class="col-lg-6 col-md-6 col-sm-6 col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-cotiza">
                        <div class="form-group">
                            <select required id="select-ctipodoc" name="select_ctipodoc" class="form-control form-select2-tipodocumento select2-hidden-accessible" style="width:100%" tabindex="-1" aria-hidden="true">
                                <option>Tipo de documento</option>
                                <option value="1">DNI</option>
                                <option value="2">Pasaporte</option>
                                <option value="3">Carné de extranjeria</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-cotiza">
                        <div class="form-group">
                            <input required id="text-cnumdoc" name="text_cnumdoc" type="text" class="form-control input-sm" autocomplete="off" placeholder="Número">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <hr>

                    <div class="portlet-cotiza-title">
                        <div class="caption">
                            <h4 class="caption-subject">
                                Terminos y Condiciones
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!--<div class="col-sm-12"><h4>INCLUIDO</h4></div>-->
                    <div class="col-sm-12">
                        <div>
                            <hr>
                            <div class="form-group">
                                <div class="alert alert-warning">
                                    <div class="checkbox" style="margin:0px;">
                                        <input type="checkbox" id="cb-confirma" name="cb_confirma" required>
                                        <label for="cb-confirma" style="font-size:13px;">Leí y acepto los
                                        </label>
                                        <a style="font-size: 13px;margin-left:5px;"> Terminos y condiciones</a>
                                    </div>

                                </div>
                            </div>
                            <!--<div class="col-sm-12"><h4>INCLUIDO</h4></div>-->
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-12">
                    <hr>
                    <!-------dias de duracion----->

                    <button id="passenger" class="btn btn-block btn-success btn-danger btn-lg " href="">RESERVAR</button>

                </div>
                </div> </form>
            </div>
            <!----detalle de Reserva-->
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="captionpaquet">
                            <div class="cap1">
                                <h4>{{$paquete->destino}} Salida: 20 Mayo</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <br>
                        <br>
                        <h4>Destino</h4>
                        <p>{{$paquete->destino}}</p>
                        <div class="cap2" style="width: 70%; height: 10%;">
                            <h4>@if(($paquete->duration-(1))== 0))
                                    1 Día
                                    @else
                                {{($paquete->duracion)-(1)}} Noches</h4>
                            @endif
                        </div>
                        <h4>Total del Paquete por Persona</h4>
                        <div class="precio_paquete" style="font-size: 15px;"> S/.{{$paquete->precio_sol}} ó
                            US$/.{{$paquete->precio_dolar}}</div>
                        <ul class="lista-detail-inccom">
                            <li class="text-primary2">
                                <div><em>Servicio:</em></div>
                                <p>{{$paquete->servicio}}</p>
                            </li>
                            <hr>
                            <li class="text-primary2">
                                <div><em>Vigencia:</em></div>
                                <p>Jueves, 10 de Mayo del 2018</p>
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="row"><hr></div>
                <div class="row">
                    <div class="col-sm-12"><h4>CATEGORIA</h4></div>
                    <div class="tags-category"><span>{{$paquete->categoria}}</span></div>
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
                <div class="row"><hr></div>

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

                <div class="row"><hr></div>
            </div>
            <!----detalle de Reserva-->
        </div>


    </div>

    <br>
    <br>
    </div>

@endsection
