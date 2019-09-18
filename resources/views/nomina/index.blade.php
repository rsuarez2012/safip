@extends('layouts.master')

@section('titulo', 'Empleados')

@section('css')
<!--  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
<style type="text/css">
    td{
        text-align: center;
    }
</style>
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
    $(function () {
        $('#listado').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [ 50,100, 200, 500],
            "autoWidth": true
        });
    });
    $(function () {
        $('#apf_lista').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [ 50,100, 200, 500],
            "autoWidth": true
        });
    });

    $(document).ready(function(){

        $(".abrirFaltas").click(function(){
            var x=$(this).attr("id");
            $("input[name=inasistencia_id]").val(x);
            $(".modalFaltas").fadeIn();
        });
        $(".cerrarFaltas").click(function(){

            $(".modalFaltas").fadeOut(300);
        });

        $(".abrirAdelanto").click(function(){
            var x=$(this).attr("id");
            $("input[name=adelanto_id]").val(x);
            $(".modalAdelanto").fadeIn();
        });
        $(".cerrarAdelanto").click(function(){

            $(".modalAdelanto").fadeOut(300);
        });
        $(".abrirNomina").click(function(){
            var x=$(this).attr("id");
            $("input[name=recibo_id]").val(x);
            $(".modalNomina").fadeIn();
        });
        $(".cerrarNomina").click(function(){

            $(".modalNomina").fadeOut(300);
        });
        
        $(".cerrarDatos").click(function(){
            $(".modalDatos").fadeOut(300);
        });
        $(".abrirContrato").click(function(){
         var x=$(this).attr("id");
         $("input[name=contrato_id]").val(x);
         $(".modalContrato").fadeIn();
     });
        $(".cerrarContrato").click(function(){
            $(".modalContrato").fadeOut(300);
        });
        $(".abrirApf").click(function(){
         $(".modalApf").fadeIn();
     });
        $(".cerrarApf").click(function(){
            $(".modalApf").fadeOut(300);
        });
        $(".abrirAportes").click(function(){
         $(".modalAportes").fadeIn();
     });
        $(".cerrarAportes").click(function(){
            $(".modalAportes").fadeOut(300);
        });
    });
</script>


@endsection

@section('content')
<div class="box padding_box1">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">           
            <div class="row">
                <div class="col-md-8">
                    <h2><i class="fa fa-user"></i> Empleados</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-3" >
                    <a class="abrirAportes btn btn-success" style="color: #fff;"  data-toggle="tooltip" data-placement="top" title="Aportes"> <i class="fa fa-money"></i></a>
               
                    <a class="abrirApf btn btn-success" style="color: #fff;" data-toggle="tooltip" data-placement="top" title="AFP"> <i class="fa fa-navicon"></i></a>
               
                    <a class="btn btn-success" href="{{Route('manageNomina-nuevo-A')}}" style="color: #fff;" data-toggle="tooltip" data-placement="top" title="Nuevo Empleado"><i class="fa fa-user-plus"></i></a>
                </div>
                <div class="col-md-1 abrirNomina" style="margin-left: -10%;" ><a class="btn btn-success abrir" data-toggle="tooltip" data-placement="top" title="Generar Nomina">  <i class="fa fa-users"></i></a></div>
            </div>
        </div>
    </div>
    <div class="x_content">
         @if(Session::has('message'))
             <div class='alert alert-success'>
                 <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <p>{!! Session::get('message') !!}</p>
             </div>
              @endif
        </div>
    <div class="x_content">
        @if(Session::has('message2'))
            <div class='alert alert-danger'>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p>{!! Session::get('message2') !!}</p>
            </div>
        @endif
    </div>
    <br>
    <div class="row">
        <div class="col-ms-12">
            <div class="box-body"> 
                <hr>
                @if (count($listado) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" id="listado" style="margin-left: 1% !important;" >
                            <thead  style="background-color: #dd4b39; color: white; ">
                                <tr>
                                    <th class="col-md-2 text-center">NOMBRE</th>
                                    <th class="col-md-2 text-center">APELLIDOS</th>
                                    <th class="col-md-3 text-center">DOCUMENTO</th>
                                    <td class="col-md-2 text-bold text-center">CONTRATO</td>
                                    <th class="col-md-3 text-center">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($empleados as $contrato)
                               <tr>
                                    
                                    <td>{{$contrato->nombres}}</td>
                                    <td>{{$contrato->apellidos}}</td>
                                    <td>{{$contrato->documento}}</td>
                                    <td  class="text-center">
                                        @if($contrato->datoslaborales[0]->contrato[0]->estado == 0 )
                                        <a id="{{$contrato->id}}" class="btn btn-danger btn-xs">Sin Contrato Activo</a>
                                        @else
                                        <a class="btn btn-info btn-xs">Contrato Activo</a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{Route('manageNomina-editar-A',$contrato->id)}}" class="btn btn-danger btn-xs"  data-toggle="tooltip" data-placement="left" title="" data-original-title="Ver planilla"><i class="fa fa-eye" aria-hidden="true"></i></a>


                                        <a id="{{$contrato->id}}" class="abrirFaltas  btn btn-danger btn-xs"  data-toggle="tooltip" data-placement="left" title="" data-original-title="Reportar inasistencia"><i class="fa fa-user-times" aria-hidden="true"></i></a>


                                        <a href="{{Route('manageNomina-contrato-A', $contrato->id)}}" class="btn btn-danger btn-xs"  data-toggle="tooltip" data-placement="left" title="" data-original-title="Ver Contrato"><i class="fa fa-file" aria-hidden="true"></i></a>


                                        <a href="{{--Route('manageNomina-delete-A',$contrato->datoslaborales->empleado->id)--}}" class=" btn btn-danger btn-xs"  data-toggle="tooltip" data-placement="left" title="" data-original-title="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i></a>


                                        @if($contrato->periodo_pago=="quincenal")
                                        <a id="{{$contrato->empleado_id}}" class="abrirAdelanto btn btn-danger btn-xs"  data-toggle="tooltip" data-placement="left" title="" data-original-title="Solicitar Adelanto"><i class="fa fa-money" aria-hidden="true"></i></a>
                                        @endif


                                        @if($contrato < date('Y-m-d'))
                                        <a id="{{$contrato->id}}" class="abrirContrato btn btn-danger btn-xs" data-toggle="tooltip" data-placement="left" title="" data-original-title="Agregar Contrato"><i class="fa fa-copy"></i></a>
                                        @endif
                                    </td>

                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-block alert-info" style="margin-top: 44px; margin-left: 1%;">
                        <i class="fa fa-exclamation-triangle fa-1" style="float:left; margin-right: 16px;"></i>
                        <p class="margin-bottom-10">
                            No existen items registrados en el sistema.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


<!--________________________MODAL INSASITENCIAS__________________________-->
<div class="modal-md modal modalFaltas" style="overflow-y: auto;">
    <div class="modal-content">
        <div class="modal-body">
            <h3>Reportar Inasistencia</h3>
            <form action="{{Route('manageNomina-inasistencia-A')}}" class="row" method="POST">
                {!! csrf_field() !!}
                <input type="hidden" name="inasistencia_id">
                <div class="col-sm-6">
                    <label for="">Fecha <i class="fa fa-calendar"></i></label>
                    <input required="" name="fecha" type="date" class="form-control">
                </div>
                <div class="col-sm-6">
                    <label for="">Motivo </label>
                    <input required="" name="motivo" type="text" class="form-control" placeholder="Motivo">
                </div>
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn cerrarFaltas btn-warning btn-sm" data-dismiss="modal">Cerrar</button>
                <button class="btn btn-success btn-sm pull-right" type="submit">Guardar</button>
            </form>
        </div>
    </div>
</div>
<!--________________________MODAL ADELANTO__________________________-->
<div class="modal-md modal modalAdelanto" style="overflow-y: auto;">
    <div class="modal-content">
        <div class="modal-body">
            <h3>Solicitar Adelanto</h3>
            <form action="{{Route('manageNomina-adelanto-A')}}" class="row" method="POST">
                {!! csrf_field() !!}
                <input type="hidden" name="adelanto_id">
                <input type="hidden" name="tipo" value="efectivo">
                <div class="col-sm-6">
                    <label for="">Fecha <i class="fa fa-calendar"></i></label>
                    <input required="" name="fecha" type="date" class="form-control" placeholder="Motivo de La Inasistencia">
                </div>
                <div class="col-sm-6">
                    <label for="">Motivo </label>
                    <input required="" name="motivo" type="text" class="form-control" placeholder="Motivo">
                </div>
                <div class="col-sm-12">
                    <label for="">Monto </label>
                    <input required="" name="monto" type="number" step="0.01" class="form-control" placeholder="Monto" min="0">
                </div>
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn cerrarAdelanto btn-warning btn-sm" data-dismiss="modal">Cerrar</button>
                <button class="btn btn-success btn-sm pull-right" type="submit">Guardar</button>
            </form>
        </div>
    </div>
</div>
<!--________________________MODAL GENERAR NOMINA__________________________-->
<div class="modal-md modal modalNomina" style="overflow-y: auto;">
    <div class="modal-content">
        <div class="modal-body">
            <h3>Seleccionar Fechas</h3>
            <form action="{{Route('manageNomina-GenerarNomina-A')}}" class="row" method="POST">
                {!! csrf_field() !!}
                <input type="hidden" name="recibo_id">
                <div class="col-sm-6">
                    <label for="">Mes <i class="fa fa-calendar"></i></label>
                    <select name="mes" class="form-control" required="">
                        <option value="01">ENERO</option>
                        <option value="02">FEBRERO</option>
                        <option value="03">MARZO</option>
                        <option value="04">ABRIL</option>
                        <option value="05">MAYO</option>
                        <option value="06">JUNIO</option>
                        <option value="07">JULIO</option>
                        <option value="08">AGOSTO</option>
                        <option value="09">SEPTIEMBRE</option>
                        <option value="10">OCTUBRE</option>
                        <option value="11">NOVIEMBRE</option>
                        <option value="12">DICIEMBRE</option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label for="">Año <i class="fa fa-calendar"></i></label>
                    <select name="anio" class="form-control" required="">
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019" selected="">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                    </select>
                </div>
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn cerrarNomina btn-warning btn-sm" data-dismiss="modal">Cerrar</button>
                <button class="btn btn-success btn-sm pull-right" type="submit">Ver Recibo</button>
            </form>
        </div>
    </div>
</div>

<!--________________________MODAL CONTRATO__________________________-->
<div class="modal-md modal modalContrato" style="overflow-y: auto;">
    <div class="modal-content">
        <div class="modal-body">
            <h3>Datos del Contrato</h3>
            <form action="{{Route('manageNomina-contratoNuevo-A')}}" class="" method="POST">
                {!! csrf_field() !!}
                <input type="hidden" name="contrato_id">
                <label>Fecha Inicio</label>
                <input type="date" class="form-control" required="" name="fecha_inicio">
                <br>
                <label>Fecha Fin</label>
                <input type="date" class="form-control" required="" name="fecha_fin">
                <br>
                <input type="number" step="0.01" class="form-control" required="" name="sueldo" placeholder="Sueldo">
                <br>
                <select class="form-control" required="" name="periodo_pago">
                    <option value="">Periodo de Pago</option>
                    <option value="quincenal">Quincenal</option>
                    <option value="mensual">Mensual</option>
                </select>
                <div class="modal-footer">
                    <button type="button" class="btn cerrarContrato btn-warning btn-sm" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-success btn-sm pull-right" type="submit">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--________________________MODAL APF__________________________-->
<div class="modal-md modal modalApf" style="overflow-y: auto;">
    <div class="modal-content" style="width: 70% !important; margin-left: 15% !important;">
        <div class="modal-body">
            <h3>APF</h3>
            <table>
                <tr>
                    <form method="POST" action="{{Route('manageNomina-Aporte-A')}}">
                      {!! csrf_field() !!}
                      <td><input placeholder="Nombre del Aporte" required="" name="nombre" type="text" class="form-control"></td>
                      <td><input placeholder="Aporte Obligatorio" required="" name="aporte_obligatorio" type="number" step="0.01" class="form-control"></td>
                      <td><input placeholder="Comision R.A" required="" name="comision_ra" type="number" step="0.01" class="form-control"></td>
                      <td><input placeholder="Prima Seguro" required="" name="prima_seguro" type="number" step="0.01" class="form-control"></td>
                      <td><button class="btn btn-danger" type="submit">Agregar</button></td>
                  </form>
              </tr>
          </table>
          <hr>
          <div class="table-responsive">
              <table class="table" id="apf_lista">
                <thead class="text-bold">
                    <tr class="text-center">
                        <th>Nombre</th>
                        <th>Aporte Obligatorio</th>
                        <th>Comision R.A</th>
                        <th>Prima Seguro</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($apf as $contrato)
                    <tr>
                        <form method="POST" action="{{Route('manageNomina-Aporte-Updated-A')}}">
                          {!! csrf_field() !!}
                          <input type="hidden" name="id" value="{{$contrato->id}}">
                          <td><input class="form-control" required="" name="nombre" type="text" value="{{$contrato->nombre}}"></td>
                          <td><input class="form-control" required="" name="aporte_obligatorio" type="number" step="0.01" value="{{$contrato->aporte_obligatorio}}"></td>
                          <td><input class="form-control" required="" name="comision_ra" type="number" step="0.01" value="{{$contrato->comision_ra}}"></td>
                          <td><input class="form-control" required="" name="prima_seguro" type="number" step="0.01" value="{{$contrato->prima_seguro}}"></td>
                          <td><button class="btn btn-danger" type="submit">Guardar</button></td>
                      </form>
                  </tr>
                  @endforeach
              </tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn cerrarApf btn-warning" data-dismiss="modal">Cerrar</button>
    </div>
</div>
</div>
</div>
<!--________________________MODAL OTROS APORTES__________________________-->
<div class="modal-md modal modalAportes" style="overflow-y: auto;">
    <div class="modal-content">
        <div class="modal-body">
            <h3>APORTES</h3>
            <table class="table" id="apf_lista">
                @foreach($aportes as $contrato)
                <tr>
                    <td>NOMBRE</td>
                    <td>MONTO</td>
                </tr>
                <tr>
                    <form method="POST" action="{{Route('manageNomina-AporteOtros-Updated-A')}}">
                      {!! csrf_field() !!}
                      <input type="hidden" name="id" value="{{$contrato->id}}">
                      <td><input class="form-control" required="" readonly=" class="form-control"" name="nombre" type="text" value="{{$contrato->nombre}}"></td>
                      <td><input class="form-control" required="" name="monto" type="number" step="0.01" value="{{$contrato->monto}}"></td>
                      <td><button class="btn btn-danger" type="submit">Guardar</button></td>
                  </form>
              </tr>
              @endforeach
          </table>
          <div class="modal-footer">
            <button type="button" class="btn cerrarAportes btn-warning" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>
</div>
@endsection