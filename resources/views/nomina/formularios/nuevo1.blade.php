@extends('layouts.master')

@section('titulo', 'Empleados')

@section('css')
<!--  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->

@endsection
@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.3/moment.min.js"></script>

<script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">

<script type="text/javascript">
    function printDiv(nombreDiv) {
        var contenido= document.getElementById(nombreDiv).innerHTML;
        var contenidoOriginal= document.body.innerHTML;

         document.body.innerHTML = contenido;

        window.print();
        document.body.innerHTML = contenidoOriginal;
        location.reload();
    }

    $("#calcular").click(function(){
        var sueldo=$("input[name='sueldo']").val();
        $("#salario_base").text(sueldo);
        $("#valor_dia").text((sueldo/26));
        $("#valor_hora").text(((sueldo/26)/10));
        var f=new Date();
        $("#fecha_reg").text( f.getDate() + "-" + f.getMonth() + "-" + f.getFullYear() );
    });
	$('#boton').click(function(){
		//alert("boton de enviar");
	});
    $('.bancoN').click(function(){
        //alert("banco");        
        $('.modalBancoN').modal();
    });
    $(".abrirDatos").click(function(){
        $(".modalDatos").fadeIn();
    });
    $('.cerrarFaltas').click(function() {
       $(".modalDatos").fadeOut(); 
    });
</script>


@endsection

@section('content')
<div class="tab-content">
    <div class="box padding_box1">
        <div class="row">
            <div class="col-md-8">
                
                <h1><i class="fa fa-user-plus"></i> Nuevo Empleado</h1>
            </div>

            <div class="col-md-3 pull-right">
                <a class="abrirDatos btn btn-success" style="color: #fff;" data-toggle="tooltip" data-placement="top" title="Agregar Dato Laboral"> <i class="fa fa-plus"></i></a>
            </div>
        </div>
        <ul class="nav nav-tabs">
            <li><a data-toggle="tab" href="#mp">Datos Personales</a></li>
            <li class="active"><a data-toggle="tab" href="#mr">Datos Laborables</a></li>
            <li><a data-toggle="tab" href="#mc">Datos de Contrato</a></li>
            
        </ul>
        <div class="tab-content">
            <div class="tab-pane row" id="mp">
                <form action="#" method="POST" class="form-horizontal" id="form-grande" accept-charset="UTF-8" enctype="multipart/form-data">
                {{ csrf_field() }}
                    <div class="row"  style="margin-top: 15px;">
                        <div class="pull-left col-sm-5 image image-user ">
                            <img src="{{asset('uploads/usuarios/user_default.png')}}" alt="Imagen del empleado" class="img-circle" style="width: 70%;  margin-left: 13%; margin-top: 5%;">
                            <div class="custom-file-input2">
                                <input type="file" name="image" class="custom-file-input">
                            </div>
                            <h3 style="text-align: center;margin-top: 8%;" class="form-section2"></h3>
                        </div>




                        <div class="col-sm-6">


                            <div class="form-group has-feedback">
                                <label class="control-label col-sm-5">Nombres del Empleado</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="nombres" placeholder="Nombres del Empleado" required="">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="col-sm-5 control-label">Apellidos del Empleado</label>
                                <div class="col-sm-7">
                                   <input type="text" class="form-control" name="apellidos" placeholder="Apellidos del Empleado" required="">
                                   </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="col-sm-5 control-label">Documento del Empleado</label>
                                <div class="col-sm-7">
                                   <input type="text" class="form-control" name="documento" placeholder="Documento del Empleado" required="">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="col-sm-5 control-label">Correo Electronico</label>
                                <div class="col-sm-7">
                                   <input type="email" class="form-control" name="email" placeholder="Correo Electronico" required="">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label  class="col-sm-5 control-label">Sleccione el Pais</label>
                                <div class="col-sm-7">
                                    <select name="pais" required class="form-control select2">
                                        <option value="">Seleccione un Pais</option>    
                                            @foreach($paises as $pais)
                                                <option value="{{$pais->paisnombre}}">{{$pais->paisnombre}}</option>
                                            @endforeach 
                                    </select>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="col-sm-5 control-label">Direccion Completa</label>
                                <div class="col-sm-7">
                                   <input type="text" class="form-control" name="direccion" value=""
                                    placeholder="Dirección completa" maxlength="255" required="">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="col-sm-5 control-label">Telefono Local</label>
                                <div class="col-sm-7">
                                   <input type="text" class="form-control" name="telefono_local" value=""
                                    placeholder="Telefono de Casa" maxlength="255" required="">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="col-sm-5 control-label">Telefono Celular</label>
                                <div class="col-sm-7">
                                   <input type="text" class="form-control" name="telefono_celular" value=""
                                placeholder="Telefono Personal" maxlength="255" required="">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="col-sm-5 control-label">fecha de nacimiento</label>
                                <div class="col-sm-7">
                                    <input type="date" class=" form-control" name="fecha_nacimiento" value=""
                                placeholder="fecha Nacimiento" maxlength="255" required="">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="col-sm-5 control-label">Asignacion Familiar</label>
                                <div class="col-sm-7">
                                    <select name="hijos" required class="form-control select2">
                                        <option value="">Asignacion Familiar</option>    
                                        <option value="si">si</option>
                                        <option value="no">no</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label  class="col-sm-5 control-label">Estado Civil</label>
                                <div class="col-sm-7">
                                    <select name="estado_civil" required class="form-control select2">
                                        <option value="">Estado Civil</option>
                                        <option value="soltero" >Soltero</option>
                                        <option value="casado">Casado</option>
                                        <option value="viudo">Viudo</option>
                                        <option value="Divorciado">Divorciado</option>
                                    </select>
                                </div>
                           </div>
                            


                        </div>



                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <button type="submit" href="#mr" class="btn btn-danger" id="boton">Registrar Empleado<i class="fa fa-user-plus"></i></button>
                               
                            </div>
                        </div>
                    </div>        
        
                </form>                                
            </div>


            <div class="tab-pane fade in active" id="mr" style="margin-top: 15px;">
                <form action="#" method="POST" class="form-horizontal" id="form-grande" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row" style="margin-top: 15px">
                        <div class="pull-left col-sm-6">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Seleccione la Empresa</label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group col-sm-12">
                                    <select name="empresa" required class="form-control ">
                                        <option value="">Empresa</option>
                                        @foreach($empresas as $empresa)
                                            <option value="{{$empresa->nombre}}">{{$empresa->nombre}}</option>
                                        @endforeach
                                   </select>
                                </div>
                            </div>
                            
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Cargo</label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group col-sm-12">
                                    <select name="cargo" required class="form-control">
                                        <option value="">Cargo</option>
                                        @foreach($opciones as $opcion)
                                            @if($opcion->tipo_dato=="cargo")
                                                <option value="{{$opcion->nombre_dato}}">{{$opcion->nombre_dato}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Periodo de Pago</label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group col-sm-12">
                                    <select name="periodo_pago" required class="form-control">
                                        <option value="">Periodo de Pago</option>
                                        <option value="quincenal">Quincenal</option>
                                        <option value="mensual">Mensual</option>                                         
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Turno</label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group col-sm-12">
                                    <select name="turno" required class="form-control">
                                        <option value="">Turno</option>
                                        @foreach($opciones as $opcion)
                                            @if($opcion->tipo_dato=="turno")
                                                <option value="{{$opcion->nombre_dato}}">{{$opcion->nombre_dato}}</option>
                                            @endif
                                        @endforeach                                    
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Banco</label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group col-sm-12">
                                    <select name="tipo_empleado" required class="form-control">
                                        <option value="">Seleccione el Banco</option>
                                        @foreach($opciones as $opcion)
                                            @if($opcion->tipo_dato=="banco")
                                                <option value="{{$opcion->nombre_dato}}">{{$opcion->nombre_dato}}</option>
                                            @endif
                                        @endforeach     
                                    </select>   
                                </div>            
                            </div> 

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Categoria Ocupacional</label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group col-sm-12">
                                    <select name="categoria_ocupacional" required class="form-control">
                                        <option value="">Categoria Ocupacional</option>
                                        @foreach($opciones as $opcion)
                                            @if($opcion->tipo_dato=="categoria_ocupacional")
                                                <option value="{{$opcion->nombre_dato}}">{{$opcion->nombre_dato}}</option>
                                            @endif
                                        @endforeach                                         
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">AFP</label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group col-sm-12">
                                    <select name="AFP" required class="form-control">
                                        <option value="">APF</option>
                                        <option value="no">No</option>
                                        @foreach($aportes as $aporte)
                                        <option value="{{$aporte->nombre}}">{{$aporte->nombre}}</option>
                                        @endforeach                                         
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="pull-right col-sm-6">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Tipo de Empleado</label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group col-sm-12">
                                    <select name="tipo_empleado" required class="form-control">
                                        <option value="">Tipo de Empleado</option>
                                        @foreach($opciones as $opcion)
                                            @if($opcion->tipo_dato=="tipo_empleado")
                                                <option value="{{$opcion->nombre_dato}}">{{$opcion->nombre_dato}}</option>
                                            @endif
                                        @endforeach     
                                    </select>   
                                </div>                           
                            </div> 

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Ocupacion</label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group col-sm-12">
                                    <select name="ocupacion" required class="form-control">
                                        <option value="">Ocupacion</option>
                                        @foreach($opciones as $opcion)
                                            @if($opcion->tipo_dato=="ocupacion")
                                                <option value="{{$opcion->nombre_dato}}">{{$opcion->nombre_dato}}</option>
                                            @endif
                                        @endforeach                                         
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Forma de Pago</label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group col-sm-12">
                                    <select name="forma_pago" required class="form-control">
                                        <option value="">Forma de Pago</option>
                                        @foreach($opciones as $opcion)
                                            @if($opcion->tipo_dato=="forma_pago")
                                                <option value="{{$opcion->nombre_dato}}">{{$opcion->nombre_dato}}</option>
                                            @endif
                                        @endforeach                                         
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Tipo de Moneda</label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group col-sm-12">
                                    <select name="tipo_moneda" required class="form-control">
                                        <option value="">Tipo de Moneda</option>
                                        @foreach($opciones as $opcion)
                                            @if($opcion->tipo_dato=="tipo_moneda")
                                                <option value="{{$opcion->nombre_dato}}">{{$opcion->nombre_dato}}</option>
                                            @endif
                                        @endforeach                                         
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Numero de Cuenta</label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group col-sm-12">
                                    <input type="text" placeholder="Numero de Cuenta" name="numero_cuenta" required="" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Seguro</label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group col-sm-12">
                                    <select name="seguro" required class="form-control">
                                        <option value="">SNP/AFP</option>
                                        <option value="SNP">SNP</option>
                                        <option value="AFP">AFP</option>                                         
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Salud</label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group col-sm-12">
                                    <select name="salud" required class="form-control">
                                        <option value="">ESSALUD</option>
                                        <option value="no">No</option>
                                        <option value="si">Si</option>                                         
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-right">
                                    <button type="submit" class="btn btn-danger" id="boton">Datos de Laborables <i class="fa fa-user-plus"></i></button>
                                   
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <hr>




            <!--inicio del #mc-->
            <div class="tab-pane row" id="mc" style="margin-top: 15px;">
                <form action="#" method="POST" class="form-horizontal" id="form-grande" accept-charset="UTF-8" enctype="multipart/form-data">
                {{ csrf_field() }}
                        <div class="col-sm-4">
                            <label for="">Fecha de inicio</label>
                            <input required="" type="date" class="form-control" name="fecha_inicio" value="" placeholder="">   
                        </div>
                         <div class="col-sm-4">
                            <label for="">Fecha de Finalizacion</label>
                            <input required="" type="date" class="form-control" name="fecha_fin" value="" placeholder="">   
                        </div>
                        <div class="col-sm-3">
                            <label for="">Sueldo</label>
                            <input required="" type="number" step="0.01" class="form-control" name="sueldo" value="" placeholder="Sueldo">
                        </div>
                        <div class="col-sm-1" style="margin-top: 25px;">
                            <a class="btn btn-danger" id="calcular">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>

                        <div class="col-sm-12 table-responsive"   style="margin-top: 25px;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class=" text-bold" style="background-color: #dd4b39; color: white;">
                                        <td>SALARIO BASE</td>
                                        <td>VALOR POR HORA</td>
                                        <td>VALOR POR DIA</td>
                                        <td>FECHA REGISTRO</td>
                                    </tr>
                                </thead>
                                <tr>
                                    <td class="col-sm-3" id="salario_base">0</td>
                                    <td class="col-sm-3" id="valor_hora">0</td>
                                    <td class="col-sm-3" id="valor_dia">0</td>
                                    <td class="col-sm-3" id="fecha_reg">00-00-0000</td>
                                </tr>
                            </table>  
                        </div>
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-danger" id="boton">Datos Contrato<i class="fa fa-user-plus"></i></button>
                            
                        </div>
                    </div>
                </form>  
            </div>


            

                        
        </div><!--end tab-content-->           

        
    </div><!--fin div box padding_box1-->
</div>  
<!--________________________MODAL NUEVO BANCO__________________________-->
<div class="modal-md modal modalBancoN" style="overflow-y: auto;">
    <div class="modal-content">
        <div class="modal-body">
            <h3>Registrar Banco</h3>
            <br>
            <form action="{{Route('bancoN')}}" class="row" method="POST">


                <div class="row">
                    {!! csrf_field() !!}
                    <div class="col-sm-3">
                        <label for="">Nombre del Banco </label>
                    </div>
                    <div class="col-sm-8">
                        <input required="" name="bancoN" type="text" class="form-control" placeholder="Banco">
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn cerrarFaltas btn-warning btn-sm" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-success btn-sm pull-right" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>  
<!--________________________MODAL DATO LABORAL__________________________-->
<div class="modal-md modal modalDatos" style="overflow-y: auto;">
    <div class="modal-content">
        <div class="modal-body">
            <h3>Seleccionar Dato Laboral</h3>
            <form action="{{Route('manageNomina-datoLaboral-A')}}" class="" method="POST">
                {!! csrf_field() !!}
                <select name="dato_nuevo" required class="form-control">
                    <option value="">Selecciona El Tipo de Dato Laboral</option>
                    <option value="empresa">Nueva Empresa</option>
                    <option value="tipo_empleado">Tipo De Empleado</option>
                    <option value="turno">Turno</option>
                    <option value="ocupacion">Ocupacion</option>
                    <option value="forma_pago">Forma de Pago</option>
                    <option value="tipo_moneda">Tipo de Moneda</option>
                    <option value="categoria_ocupacional">Categoria Ocupacional</option>
                    <option value="cargo">Cargo</option>
                    <option value="banco">Banco</option>
                </select>
                <br>
                <input type="text" name="nombre_dato" class="form-control" required="" placeholder="Nombre">
                <div class="modal-footer">
                    <button type="button" class="btn cerrarFaltas btn-warning btn-sm" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-success btn-sm pull-right" type="submit">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div> 
@endsection
