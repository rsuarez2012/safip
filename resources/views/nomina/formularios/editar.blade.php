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

    $(document).ready(function(){
        //setear datos personales
       /* $("select[name=pais] option[value={{--$empleado->empleado->pais--}}]").attr("selected",true);
        $("select[name=hijos] option[value={{--$empleado->empleado->hijos--}}]").attr("selected",true);
        $("select[name=estado_civil] option[value={{--$empleado->empleado->estado_civil--}}]").attr("selected",true);
        
       //setear datos laborales
       $("select[name=cargo] option[value='{{--$empleado->cargo--}}']").attr("selected",true);
       $("select[name=tipo_empleado] option[value='{{--$empleado->tipo_empleado--}}']").attr("selected",true);
       $("select[name=banco] option[value='{{--$empleado->banco--}}']").attr("selected",true);
       $("select[name=turno] option[value='{{--$empleado->turno--}}']").attr("selected",true);
       $("select[name=forma_pago] option[value='{{--$empleado->forma_pago--}}']").attr("selected",true);
       $("select[name=categoria_ocupacional] option[value='{{--$empleado->categoria_ocupacional--}}']").attr("selected",true);
       $("select[name=periodo_pago] option[value='{{--$empleado->contrato->periodo_pago--}}']").attr("selected",true);
       $("select[name=ocupacion] option[value='{{--$empleado->ocupacion--}}']").attr("selected",true);
       $("select[name=tipo_moneda] option[value='{{--$empleado->tipo_moneda--}}']").attr("selected",true);
       $("select[name=seguro] option[value='{{--$empleado->seguro--}}']").attr("selected",true);
       $("select[name=apf] option[value='{{--$empleado->apf--}}']").attr("selected",true);
       $("select[name=salud] option[value='{{--$empleado->salud--}}']").attr("selected",true);*/



       //$("select[name=cargo] option[value='{{--$empleado->datoslaborales->cargo}}']").attr("selected",true);
       //$("select[name=banco] option[value='{{$empleado->datoslaborales->banco}}']").attr("selected",true);
       //$("select[name=ocupacion] option[value='{{$empleado->datoslaborales->ocupacion--}}']").attr("selected",true);
   });
</script>

@endsection
@section('content')
<div class="tab-content">
    <div class="box padding_box1">
        <h1><i class="fa fa-user-plus"></i>Datos de: {{ $empleado->nombres.' '.$empleado->apellidos }}</h1>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#mp">Datos Personales</a></li>
            <li><a data-toggle="tab" href="#mr" id="dl">Datos Laborables</a></li>
            <li><a data-toggle="tab" href="#mc">Datos de Contrato</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade in active" id="mp">
                <form action="{{Route('manageNomina-update-A')}}" method="POST" class="form-horizontal" id="form-grande" accept-charset="UTF-8" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="{{$empleado->id}}">
                    <input type="hidden" name="contrato_id" value="{{$empleado->datoslaborales_id}}">
                    <input type="hidden" name="empleado_id" value="{{$empleado->empleado_id}}">
                    <div class="pull-left col-sm-5 image image-user ">
                        @if($empleado->foto=="user_default.png")
                            <img src="{{asset('uploads/usuarios/user_default.png')}}" alt="Imagen del empleado" class="img-circle" style="width: 70%;  margin-left: 13%; margin-top: 5%;">
                            @else
                            <img src="{{asset('uploads/empleados/'.$empleado->foto.'')}}" alt="Imagen del empleado" class="img-circle" style="width: 70%;  margin-left: 13%; margin-top: 5%;">
                        @endif 
                        <div class="custom-file-input2">
                            <input type="file" name="image" class="custom-file-input" value="{{$empleado->foto}}">
                        </div>
                        <h3 style="text-align: center;margin-top: 8%;" class="form-section2"></h3>  
                    </div><!--end div imagen--> 
                    <div class="row"  style="margin-top: 15px;">
                        <div class="col-sm-6">
                            <div class="form-group has-feedback">
                                <label  class="col-sm-5 control-label">Nombres del Empleado</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="nombres" placeholder="Nombres del Empleado" required="" value="{{$empleado->nombres}}">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label  class="col-sm-5 control-label">Apellidos del Empleado</label>
                                <div class="col-sm-7">
                                   <input type="text" class="form-control" name="apellidos" placeholder="Apellidos del Empleado" required="" value="{{$empleado->apellidos}}">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label  class="col-sm-5 control-label">Documento del Empleado</label>
                                <div class="col-sm-7">
                                   <input type="text" class="form-control" name="documento" placeholder="Documento del Empleado" required="" value="{{$empleado->documento}}">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label  class="col-sm-5 control-label">Correo Electronico</label>
                                <div class="col-sm-7">
                                   <input type="email" class="form-control" name="email" placeholder="Correo Electronico" required="" value="{{$empleado->email}}">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label  class="col-sm-5 control-label">Seleccione Pais</label>
                                <div class="col-sm-7">
                                    <select name="pais" required class="form-control select2">
                                        <option value="">Seleccione un Pais</option>    
                                        @foreach($paises as $pais)
                                        <option value="{{$pais->paisnombre}}" id="{{$pais->paisnombre}}" @if($empleado->pais == $pais->paisnombre) selected @endif>{{$pais->paisnombre}}</option>
                                        @endforeach 
                                    </select>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label  class="col-sm-5 control-label">Direccion</label>
                                <div class="col-sm-7">
                                   <input type="text" class="form-control" name="direccion" value="{{$empleado->direccion}}"
                                   placeholder="Dirección completa" maxlength="255" required="">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label  class="col-sm-5 control-label">Telefono Local</label>
                                <div class="col-sm-7">
                                   <input type="text" class="form-control" name="telefono_local" value="{{$empleado->telefono_local}}"
                                   placeholder="Telefono de Casa" maxlength="255" required="">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label  class="col-sm-5 control-label">Telefono Celular</label>
                                    <div class="col-sm-7">
                                   <input type="text" class="form-control" name="telefono_celular" value="{{$empleado->telefono_celular}}"
                                   placeholder="Telefono Personal" maxlength="255" required="">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="col-sm-5 control-label">fecha de nacimiento</label>
                                <div class="col-sm-7">
                                    <input type="date" class=" form-control" name="fecha_nacimiento" value="{{$empleado->fecha_nacimiento}}"
                               placeholder="fecha Nacimiento" maxlength="255" required="">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label  class="col-sm-5 control-label">Asignacion Familiar</label>
                                <div class="col-sm-7">
                                    <select name="hijos" required class="form-control">
                                        <option value="">Asignacion Familiar</option>    
                                        <option value="si" id="si" @if($empleado->hijos=='si') selected @endif>si</option>
                                        <option value="no" id="no" @if($empleado->hijos=='no') selected @endif>no</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label  class="col-sm-5 control-label">Estado Civil</label>
                                <div class="col-sm-7">
                                    <select name="estado_civil" required class="form-control">
                                        <option value="">Estado Civil</option>
                                        <option value="soltero"  id="soltero" @if($empleado->estado_civil=='soltero') selected @endif>Soltero</option>
                                        <option value="casado" id="casado" @if($empleado->estado_civil=='casado') selected @endif>Casado</option>
                                        <option value="viudo" id="viudo" @if($empleado->estado_civil=='viudo') selected @endif>Viudo</option>
                                        <option value="divorciado" id="divorciado" @if($empleado->estado_civil=='divorciado') selected @endif>Divorciado</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
            </div><!--tab-pane fade in active-->


            <div class="tab-pane row" id="mr" style="margin-top: 15px;">
                <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Seleccione Empresa</label>
                        </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="empresa" required class="form-control">
                            <option value="">Empresa</option>
                            @foreach($empresas as $empresa)
                            <option value="{{$empresa->nombre}}" selected="">{{$empresa->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Tipo de Empleado</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="tipo_empleado" required class="form-control">
                            <option value="">Tipo de Empleado</option>
                            @foreach($opciones as $opcion)
                            @if($opcion->tipo_dato=="tipo_empleado")
                            <option value="{{$opcion->nombre_dato}}"  id="{{$opcion->nombre_dato}}" selected="">{{$opcion->nombre_dato}}</option>
                            @endif
                            @endforeach     
                        </select>   
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Cargo</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="cargo" required class="form-control">
                            <option value="">Cargo</option>
                            @foreach($opciones as $opcion)
                            @if($opcion->tipo_dato=="cargo")
                            <option value="{{$opcion->nombre_dato}}" id="{{$opcion->nombre_dato}}" @if($empleado->datoslaborales[0]->cargo == $opcion->nombre_dato) selected @endif>{{$opcion->nombre_dato}}</option>
                            @endif
                            @endforeach                                         
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Numero de Cuenta</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" placeholder="Numero de Cuenta" name="numero_cuenta" required="" class="form-control" value="{{$empleado->datoslaborales[0]->numero_cuenta}}">
                    </div>
                </div>
                <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Banco</label>
                        </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="banco" required class="form-control">
                            <option value="">Banco</option>
                            @foreach($opciones as $opcion)
                            @if($opcion->tipo_dato=="banco")
                            <option value="{{$opcion->nombre_dato}}">{{$opcion->nombre_dato}}</option>
                            @endif
                            @endforeach                                         
                        </select>
                    </div>
                </div>                
                <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Turno</label>
                        </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
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
                <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Ocupacion</label>
                        </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
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
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Forma de Pago</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
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
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Tipo de Moneda</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
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
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Seguro</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="seguro" required class="form-control">
                            <option value="">SNP/AFP</option>
                            <option value="SNP" @if($empleado->datoslaborales[0]->seguro == 'SNP') selected @endif>SNP</option>
                            <option value="AFP" @if($empleado->datoslaborales[0]->seguro == 'AFP') selected @endif>AFP</option>                                         
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Periodo de Pago</label>
                        </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="periodo_pago" required class="form-control">
                            <option value="">Periodo de Pago</option>
                            <option value="quincenal" @if($empleado->datoslaborales[0]->seguro == 'quincenal') selected="" @endif>Quincenal</option>
                            <option value="mensual" @if($empleado->datoslaborales[0]->seguro == 'mensual') selected="" @endif>Mensual</option>                                         
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">AFP &nbsp;</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="apf" required class="form-control">
                            <option value="">AFP</option>
                            <option value="no">No</option>
                            @foreach($aportes as $aporte)
                            <option value="{{$aporte->nombre}}">{{$aporte->nombre}}</option>
                            @endforeach                                         
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Categoria Ocupacional</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="categoria_ocupacional" required class="form-control">
                            <option value="">Categoria Ocupacional</option>
                            @foreach($opciones as $opcion)
                            
                            <option value="{{$opcion->nombre_dato}}" @if($empleado->datoslaborales == $opcion->nombre_dato) selected="" @endif>{{$opcion->nombre_dato}}</option>
                            
                            @endforeach                                         
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Salud</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="salud" required class="form-control">
                            <option value="">ESSALUD</option>
                            <option value="no" @if($empleado->datoslaborales[0]->salud == 'no') selected="" @endif>No</option>
                            <option value="si" @if($empleado->datoslaborales[0]->salud == 'si') selected="" @endif>Si</option>                                         
                        </select>
                    </div>
                </div>
            </div><!--end #mr--->

            <div class="tab-pane row" id="mc" style="margin-top: 15px;">
                <div class="col-sm-4">
                    <label for="">Fecha de inicio</label>
                    <input required="" type="date" class="form-control" name="fecha_inicio" value="{{$empleado->datoslaborales[0]->contrato[0]->fecha_inicio}}" placeholder="">   
                </div>
                <div class="col-sm-4">
                    <label for="">Fecha de Finalizacion</label>
                    <input required="" type="date" class="form-control" name="fecha_fin" value="{{$empleado->datoslaborales[0]->contrato[0]->fecha_fin}}" placeholder="">   
                </div>
                <div class="col-sm-3">
                    <label for="">Sueldo</label>
                    <input required="" type="number" step="0.01" class="form-control" name="sueldo" value="{{$empleado->datoslaborales[0]->contrato[0]->sueldo}}" placeholder="Sueldo">
                </div>
                <div class="col-sm-1" style="margin-top: 25px;">
                    <a class="btn btn-danger" id="calcular"><i class="fa fa-plus"></i></a>
                </div>
                <div class="col-sm-12 table -responsive"   style="margin-top: 25px;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td colspan="4" class="text-bold text-center">Contratos Anteriores</td>
                            </tr>
                            <tr class=" text-bold" style="background-color: #dd4b39; color: white;">
                                <td>SALARIO BASE</td>
                                <td>VALOR POR HORA</td>
                                <td>VALOR POR DIA</td>
                                <td>FECHA REGISTRO</td>
                            </tr>
                        </thead>
                        @if(isset($contratos))
                            <tr>
                                <td colspan="4" align="center">No tiene Contratos Anteriores</td>
                            </tr>
                        @else
                            @foreach($contratos as $contrato)
                            <tr>
                                <td class="col-sm-3" id="salario_base">{{$contrato->sueldo}}</td>
                                <td class="col-sm-3" id="valor_hora">{{--($contrato->sueldo / 26) / 10--}}</td>
                                <td class="col-sm-3" id="valor_dia">{{--$contrato->sueldo / 26--}}</td>
                                <td class="col-sm-3" id="fecha_reg">{{--$contrato->created_at--}}</td>
                            </tr>
                            @endforeach
                        @endif
                    </table>    
                </div>
                <div class="col-sm-12 table-responsive"   style="margin-top: 25px;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td colspan="4" class="text-bold text-center">Contrato Actual</td>
                            </tr>
                            <tr class=" text-bold" style="background-color: #dd4b39; color: white;">
                                <td>SALARIO BASE</td>
                                <td>VALOR POR HORA</td>
                                <td>VALOR POR DIA</td>
                                <td>FECHA REGISTRO</td>
                            </tr>
                        </thead>
                        <tr>
                            <td class="col-sm-3" id="salario_base">{{$empleado->datoslaborales[0]->contrato[0]->sueldo}}</td>
                            <td class="col-sm-3" id="valor_hora">{{($empleado->sueldo / 26) / 10}}</td>
                            <td class="col-sm-3" id="valor_dia">{{$empleado->datoslaborales[0]->contrato[0]->sueldo / 26}}</td>
                            <td class="col-sm-3" id="fecha_reg">{{$empleado->datoslaborales[0]->contrato[0]->created_at}}</td>
                        </tr>
                    </table>    
                </div>
                
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <button type="submit" class="btn btn-danger">Guardar Cambios <i class="fa fa-user"></i></button>
                    </div>
                </div>
            </form>



        </div><!--end tab-content on body-->        
    </div><!--end box padding_box1-->
</div><!--end tab-content-->
@endsection