
@extends('layouts.master')
@section('titulo', 'Procesar Cotizacion')
@section('css')

<!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
@endsection
@section('script')
<script src="{!! asset('admin-lte/plugins/iCheck/icheck.js') !!}"></script>
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">

<script>
  $(document).ready(function(){
    $(function () {
      $('#cpaquetes').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true
      });
    });

    $('[data-toggle="tooltip"]').tooltip()
   //Initialize Select2 Elements
   $(".select2").select2();

     //modal nuevo pasajero
     $(".nuevopasajero").click(function(){
       $(".modalpasajeros").fadeIn();
     });
     $(".cerrarpasajero").click(function(){
      $(".modalpasajeros").fadeOut(300);
    });

  //modal forma de pago
  $(".abrirfpago").click(function(){
   $(".modalpagos").fadeIn();
 });
  $(".cerrarfpago").click(function(){
    $(".modalpagos").fadeOut(300);
  });
   //modal peocesar ticket


   $(".abrirproceso").click(function(){
     $(".modalprocesar").fadeIn();
   });
   $(".cerrarproceso").click(function(){
    $(".modalprocesar").fadeOut(300);
  });

 });
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
  });


</script>
<script type="">

  $(document).ready(function(){
    $("#hide").click(function(){
      $(".mostrar").hide();
    });
    $("#show").click(function(){
      $(".mostrar").show();
    });
  });

</script>

@endsection

@section('content')

<div class="row">
  <div class="col-xs-12">
   <div class="box">
    <div class="box-header">
      <div class="x_title">
       <h2 ><i class="fa fa-check-square-o"></i> Procesar Cotizaciones</h2><hr>
     </div>
   </div>
   <!-- /.box-header -->
   <div class="box-body">
     <div class="col-sm-10 col-sm-offset-1">
      <!--collapse1-->
     {{--  <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Cotizacion</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Desplegar">
              <i class="fa fa-minus"></i></button>

            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title"> <strong>Numero de Cotización </strong></h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <div class="box-body">
                    <div class="form-group">
                      <label>Venta:</label>
                      <input class="form-control input-sm" type="text" class="form-control" value="" id="numero" name="numero" placeholder="Nro Cotizacion" readonly>
                    </div>

                  </div>
                  <!-- /.box-body -->
                </div>
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title"> <strong>Informacion de Agencia de Viajes </strong></h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <div class="box-body">
                    <div class="form-group">
                      <label>Agencia:</label>
                      <input class="form-control input-sm" type="text" class="form-control" value="" id="agenciav" name="agenciav" placeholder="Agencia" readonly>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>

                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title"> <strong>Informacion de la Cotización de Boletos </strong></h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <div class="box-body">
                    <div class="form-group">
                      <label>País:</label>
                      <input class="form-control input-sm" type="text" class="form-control" value="" id="pais" name="pais" placeholder="País" readonly>
                      <label>Fecha de Salida:</label>
                      <input class="form-control input-sm" type="date" class="form-control" value="" id="dsalida" name="dsalida" placeholder="Salida" readonly>
                      <label>Fecha de Llegada:</label>
                      <input class="form-control input-sm" type="date" class="form-control" value="s" id="dllegada" name="dllegada" placeholder="Llegada" readonly>

                      <div>
                        <label>
                          <span class="fa fa-exchange"></span>
                          <input type="checkbox"  name="idavuelta" readonly disabled>
                          Ida y Vuelta |

                        </label>
                        <label>
                          <span class="fa fa-angle-double-right"></span>
                          <input type="checkbox" value="si" name="solovuelta" checked readonly disabled>
                          Solo Ida |
                        </label>
                      </div>

                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
              </div>
              <div class="col-sm-6">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title"> <strong>Informacion del Agente </strong></h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <div class="box-body">
                    <div class="form-group">
                      <label>Agente:</label>
                      <input class="form-control input-sm" type="text" class="form-control" value="" id="nagente" name="nagente" placeholder="Agente" readonly>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title"> <strong>Informacion de la Cotización de Boletos </strong></h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <div class="box-body">
                    <div class="form-group">
                      <label>Salida:</label>
                      <input class="form-control input-sm" type="text" class="form-control" value="" id="csalida" name="csalida" placeholder="Salida" readonly>
                      <label>Llegada:</label>
                      <input class="form-control input-sm" type="text" class="form-control" value="" id="cllegada" name="cllegada" placeholder="Llegada" readonly>
                      <label>Pasajeros:</label>
                      <input class="form-control input-sm" type="text" class="form-control" value="" id="cantidadp" name="cantidadp" placeholder="País" readonly>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
              </div>
            </div><!-- /row-->
          </div>
          <!-- /.box-body -->

        </div> --}}
        <!-- /.box -->
        <!-- /.collapse1 -->

        <!--collapse2-->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Informacion del Proveedor </h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Desplegar">
                <i class="fa fa-minus"></i></button>

              </div>
            </div>
            <div class="box-body">
             <div class="row col-sm-12">

               <div class="col-md-6">
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title"> <strong> </strong></h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <div class="box-body">
                    <label>Proveedor</label>
                    <div class="form-group ">
                      <select class="form-control select2" style="width: 100%;">
                       <option selected="selected">Seleccione lel Proveedor</option>
                       <option id="" >Qantu Travel</option>
                       <option id="" >CTM</option>

                     </select>

                   </div>
                   <div class="mostrar">
                    <label>Codigo de Paquete:</label>
                    <div class="form-group">
                      <input class="form-control" type="text" class="form-control" value="" id="codigo" name="codigo" placeholder="Codigo" required >
                      
                    </div>
                  </div>
                  <div class="mostrar">
                   <label>Nombre del Paquete:</label>
                   <div class="form-group">
                    <input class="form-control" type="text" class="form-control" value="" id="nombre" name="nombre" placeholder="#nombre" required >

                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.form-group -->
          </div>
          <!-- /.col -->

          <div class="col-md-6">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"> <strong> </strong></h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <div class="box-body">
              <div class="mostrar">
                <label>Hotel</label>
                <div class="form-group ">
                  <select name="laerea" id="laerea" onchange="" required class="form-control">
                    <option value="">Selecciona el Hotel</option>

                    <option value=>nombre</option>

                  </select>


                </div>
                </div>
                <div class="mostrar">
                <label>Habitacion</label>
                <div class="form-group ">
                  <select name="laerea" id="laerea" onchange="" required class="form-control">
                    <option value="">Selecciona la habitacion</option>

                    <option value=> Simple</option>
                    <option value=> Doble</option>
                    <option value=> Triple</option>

                  </select>


                </div>
                </div>
                <label>


                <input type="radio" id="show"
                  name="tventa" value="agencia" checked>
                  <label for="agencia">Agencia</label>

                  <input type="radio" id="hide"
                  name="tventa" value="venta directa">
                  <label for="venta directa">Venta directa</label>
                </label>


              </div>
              <!-- /.box-body -->
            </div>
          </div>
          <!-- / col-->

        </div><!-- /row-->
      </div>
      <!-- /.box-body -->

    </div>
    <!-- /.box -->
    <!-- /.collapse2 -->

    <!--collapse3-->
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Pasajeros</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Desplegar">
            <i class="fa fa-minus"></i></button>

          </div>
        </div>
        <div class="box-body">

         <div class="row">
          <div class="pull-right">

            <a href="#" class="nuevopasajero btn btn-warning"><i class="fa fa-plus-circle"></i> Nuevo Pasajero </a>
          </div>
        </div><br>
        <div class="table-responsive">
          <table id="cpaquetes" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Empresa</th>
                <th>DNI/RUC</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Tipo</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>QANTU TRAVEL SAC</td>
                <td>77899</td>
                <td>JOSE</td>
                <td>PEREZ</td>
                <td>Directo</td>
                <td>
                  <a href="#" class="abrirproceso  btn btn-primary btn-xs" data-toggle="tooltip" title="procesar">Procesar Paquete</a>

                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <!-- /.box-body -->

    </div>
    <!-- /.box -->
    <!-- /.collapse3 -->

    <!--collapse4-->
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Informacion del Boleto</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Desplegar">
            <i class="fa fa-minus"></i></button>

          </div>
        </div>
        <div class="box-body">


          <div class="table-responsive">
            <table id="cpaquetes" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>DNI/RUC</th>
                  <th>Nombre y Apellido</th>
                  <th>Numero de Paquete</th>
                  <th>Neto</th>
                  <th>Tarifa</th>
                  <th>Comision de Agencia</th>
                  <th>IVG</th>
                  <th>Total</th>
                  <th>Pago a Consolidadores</th>
                  <th>Tarifa + FEE</th>
                  <th>Utilidad</th>               
                  <th>Incentivo</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>12344</td>
                  <td>jose perez</td>
                  <td>2</td>
                  <td>876</td>
                  <td>765</td>
                  <td>54</td>
                  <td>78</td>
                  <td>8765</td>
                  <td>876</td>
                  <td>777</td>
                  <td>7</td>
                  <td>43</td>
                  <td>
                    <a href="#" class="btn btn-danger">Eliminar</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div><hr>
          <div>
            <div class="form-group row">
              <div>
                <label class="col-sm-1 control-label"> Cantidad</label>
                <div class="col-sm-2">
                  <input type="text" name="Cantidad" class="form-control" readonly="" value="0">
                </div>
              </div>
              <div>
                <label class="col-sm-2 control-label"> Total a pagar</label>
                <div class="col-sm-2">
                  <input type="text" name="Total" class="form-control" readonly="" value="0">
                </div>
              </div>
              <div class="col-sm-2">
                <a href="# " class="btn btn-danger abrirfpago" data-toggle="tooltip" title="forma de pago">Forma de Pago</a>

              </div>
              <div class=" col-sm-2">
                <a href="{{ route('manageCotizacionPaquete-A') }}" class="btn btn-danger "><i class="fa fa-arrow-circle-right"></i> Guardar</a>
              </div>
            </div>
          </div>

        </div>
        <!-- /.box-body -->

      </div>
      <!-- /.box -->
      <!-- /.collapse4 -->
    </div>
  </div><!--/box-body-->
</div>
</div>


<!-- MODAL NUEVO PASAJERO -->
<div class="modal-md modal modalpasajeros" style="overflow-y: auto;">
  <div class="modal-content">
    <div class="modal-body">
      <h3>Nuevo Pasajero</h3>
      <div class="col-sm-10 col-sm-offset-1">
        <form><br>
          <div class="form-group row">

            <div class="col-sm-12">
              <select class="form-control select2" style="width: 100%;">
                <option selected="selected">Seleccione la Empresa</option>
                <option>Alaska</option>
                <option>California</option>
                <option>Delaware</option>
                <option>Tennessee</option>
                <option>Texas</option>
                <option>Washington</option>
              </select>
            </div>
          </div>

          <div class="form-group row">

            <div class="col-sm-12">
              <select class="form-control">
                <option>Seleccione el Tipo</option>
                <option value="">Corporativo</option>
                <option value="">Directo</option>
                <option value="">Indirecto</option>

              </select>
            </div>
          </div>
          <div class="form-group row">

            <div class="col-sm-12">
              <input type="text" name="nombre" class="form-control" placeholder="Nombre">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 control-label"> Apellido</label>
            <div class="col-sm-12">
              <input type="text" name="Apellido" class="form-control" placeholder="Apellido">
            </div>
          </div>

          <div class="form-group row">

            <div class="col-sm-12">
              <input type="text" name="DNI" class="form-control" placeholder="DNI">
            </div>
          </div>
          <div class="form-group row">

            <div class="col-sm-12">
              <input type="text" name="Direccion" class="form-control" placeholder="Direccion">
            </div>
          </div>
          <div class="form-group row">

            <div class="col-sm-12">
              <input type="text" name="Telefono" class="form-control" placeholder="Telefono">
            </div>
          </div>
          <div class="form-group row">

            <div class="col-sm-12">
              <input type="email" name="Email" class="form-control" placeholder="Email">
            </div>
          </div>


        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn cerrarpasajero btn-warning" data-dismiss="modal">Cerrar</button>

        <a href="#" class="btn btn-danger"><i class="fa fa-arrow-circle-right"></i> Registrar</a>

      </div>
    </div>
  </div>
</div>
<!-- /MODAL NUEVO PASAJERO -->

<!-- MODAL FORMA DE PAGO -->
<div class="modal-md modal modalpagos" style="overflow-y: auto;">
  <div class="modal-content">
    <div class="modal-body">
      <h3>Forma de Pago</h3>
      <div class="col-sm-10 col-sm-offset-1">
        <form action="" method=""><br>
          <div class="form-group row">

            <div class="col-sm-12">
              <select class="form-control select2" style="width: 100%;">
                <option selected="selected">Seleccione el Tipo de Pago</option>
                <option>Efectivo</option>
                <option>TDO</option>
                <option>TDC</option>
                <option>Cheque</option>
                <option>Transferencia</option>
                <option>Deposito</option>
                <option>A credito</option>
                <option>Pendiente</option>
              </select>
            </div>
          </div>
          <div class="form-group row">

            <div class="col-sm-12">
              <input type="number" name="Monto" class="form-control" placeholder="Monto">
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="checkbox">
                <label>
                  <input type="checkbox"> Monto Completo
                </label>
              </div>
            </div>
          </div>

          <div class="form-group row">

            <div class="col-sm-12">
              <select class="form-control select2" style="width: 100%;">
                <option selected="selected">Seleccione el Banco Emisor</option>
                <option value="">Corporativo</option>
                <option value="">Directo</option>
                <option value="">Indirecto</option>

              </select>
            </div>
          </div>

          <div class="form-group row">

            <div class="col-sm-12">
              <select class="form-control select2" style="width: 100%;">
                <option selected="selected">Seleccione el Banco Receptor</option>
                <option value="">Corporativo</option>
                <option value="">Directo</option>
                <option value="">Indirecto</option>

              </select>
            </div>
          </div>

          <div class="form-group row">

            <div class="col-sm-12">
              <input type="text" name="Nro de Operacion" class="form-control" placeholder="Nro de Operacion">
            </div>
          </div>

          <div class="form-group row">

            <div class="col-sm-12">
              <input type="text" name="Dias para Pagar" class="form-control" placeholder="Dias para Pagar">
            </div>
          </div>
          <div class="pull-right ">
           <a href="#" class="btn btn-danger">Agregar</a>
         </div><br>

       </form><br>

       <div class="table-responsive">
        <table id="cpaquetes" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Tipo de Pago</th>
              <th>Monto</th>
              <th>Banco Emisor</th>
              <th>Banco Receptor</th>
              <th>Nro de Operacion</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Efectivo</td>
              <td>100</td>
              <td>banco1</td>
              <td>banco2</td>
              <td>34</td>
              <td>
                <a href="#" class="btn btn-danger btn-xs"> Eliminar</a>
              </td>
            </tr>
          </tbody>
        </table>

      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn cerrarfpago btn-warning" data-dismiss="modal">Cerrar</button>
    </div>
  </div>
</div>
</div>


<!--// MODAL FORMA DE PAGO -->

<!-- MODAL PROCESAR PAQUETE -->

<div class="modal-md modal modalprocesar" style="overflow-y: auto;">
  <div class="modal-content">
    <div class="modal-body">
      <h3>Paquetes y Costo</h3>
      <form action="" method="">
       <div class=" row">
        <div class="col-sm-10 col-sm-offset-1">

          <div class="clearfix"></div>
          <div id="formulario">
            <input name="ruc" class="btn btn-sm btn-info btn-flat pull-left form-control required" type="button" class="form-control" value="5677" id="userid" placeholder="" required>
            <input name="userid" class="btn btn-sm btn-info btn-flat pull-left form-control required" type="button" class="form-control" value="jose perez" id="userid" placeholder="" required>

            <div  class="col-md-6">
              <label>File</label>
              <input class="form-control required input-sm text-red" type="text"  value="" id="File"  name="tikets" placeholder="#File" >
              <label>Neto</label>
              <input class="form-control required input-sm text-red" type="text"  value="" name="neto" id="neto" placeholder="Neto" >
              <label>Tarifa</label>
              <input class="form-control required input-sm text-red" type="text"  value="" name="tarifa" id="tarifa"  placeholder="Tarifa" >
              <label>Comision de Agencia</label>
              <input class="form-control monto required input-sm text-red" type="text"  value="" name="comi"  id="comi"  placeholder="Comision" >
              <label>IGV</label>
              <input class="form-control monto required input-sm text-red" type="number" step="any"  value="" name="igv" id="igv"  placeholder="IGV" >
            </div>
            <div  class="col-md-6">
              <label>Total</label>
              <input class="form-control required input-sm text-red" type="number" step="any" value="" id="total" name="total" placeholder="Total" >
              <label>Pagar a Consolidador</label>
              <input class="form-control required input-sm text-red " type="text"  value="" name="conso" id="conso" placeholder=""  readonly>
              <label>Tarifa + FEE</label>
              <input class="form-control required input-sm text-red" type="text"  value=""  name="tarifaf" id="tarifaf" placeholder="Tarifa + FEE" >
              <label>Utilidad</label>
              <input class="form-control required input-sm text-red" type="text"  value="" name="utilidad" id="utilidad" placeholder="Utilidad" >
              <label>Incentivo</label>
              <input class="form-control required input-sm text-red" type="text"  value="" name ="incentivo" id="incentivo" placeholder="Incentivo" >
            </div>
            <div align="center" class="col-md-10 col-sm-offset-1">
            </div>
          </div>
        </div>
      </div>
    </form>

    <div class="modal-footer">
      <button type="button" class="btn  btn-warning" data-dismiss="modal">Adicionar Cliente</button>
      <button type="button" class="btn cerrarproceso btn-warning" data-dismiss="modal">Cerrar</button>
    </div>
  </div>
</div>
<!-- //MODAL PROCESAR PAQUETE -->

</div>
@endsection