@extends('layouts.master')

@section('titulo', 'Contabilidad')
 
@section('css')
<!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
@endsection
@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.3/moment.min.js"></script>

<script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>



@endsection

@section('content')
    <div style="min-height: 600px" class="box padding_box1">
    <h2><i class="fa fa-money"></i> Contabilidad</h2>
    <hr>
    <div class="row">
        <div class="col-xs-4">
            <div class="box-cont">
                <div style="text-align: center;"><br><br><i class="fa fa-share-square-o fa-5x"></i></div>
                <h2>Facturas de Compras</h2>
                <div style="text-align: center;"><a href="{{ route ('managefacturaCompra-A')}}" class="btn btn-danger">Ver mas</a></div>
            </div>
            
        </div>
        <div class="col-xs-4">
            <div class="box-cont">
                    <div style="text-align: center;"><br><br><i class="fa fa-sort-amount-desc fa-5x"></i></div>
                    <h2>Facturas de Ventas</h2>
                    <div style="text-align: center;"><a href="{{ route ('managefacturaVenta-A')}}" class="btn btn-danger">Ver mas</a></div>
            </div> 
        </div>
        <div class="col-xs-4">
            <div class="box-cont" style="padding-bottom: 5px;">
                <div style="text-align: center;"><br><br><i class="fa fa-table fa-5x"></i></div>
                <h2>Estado Perdidas y Ganancias</h2>
                <form action="{{Route('manageGananciaPerdida-A')}}" class="row" method="POST">
                    {!! csrf_field() !!}
                    <div class="col-sm-6">
                    <label for="">Mes</label>
                        <select class="form-control" required="" name="mes">
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
                        <label for="">año</label>
                        <select class="form-control" required="" name="anio">
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                        </select>
                    </div>
                   <div style="text-align: center;margin-top: 5px;margin-bottom: 5px;" class="col-sm-12">
                       <button type="submit" class="btn btn-danger">Ver Estado</button>
                   </div>
               </form>
            </div>
        </div>
    </div>
    </div>
@endsection

