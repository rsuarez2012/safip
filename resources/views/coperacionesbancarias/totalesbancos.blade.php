@extends('layouts.mastersm')

@section('titulo', 'Consulta de Montos')

@section('css')
    <!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
    <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
    <style type="text/css">
        .modal-body {
            overflow-y: auto;
        }
          .content-wrapper{
            margin-left: 0 !important;
             min-height: 400px;
        }
        .content-header{
            padding: 0 !important
        }
    </style>
@endsection
@section('script')
    <script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
    <script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
    <script src={!! asset("admin-lte/plugins/datatables/dataTables.bootstrap.js")!!}></script>
@endsection

@section('content')

    <div style="background-color: #fff" class="">
        <div class="padding_box1">
            <div class="row">

                <form class="form-horizontal" role="form" method="POST"
                      action="{{route('manageCoperacionesbancarias-ttbsm-A')}}" enctype="multipart/form-data">
                    {!! csrf_field() !!}

                    <div class="col-sm-4"><label>Desde:</label>
                        <div class="form-group {{ $errors->has('fechai') ? ' has-error' : '' }} has-feedback">

                            <input type="date" class="form-control" name="fechai" value="{{$fechai}}"
                                   placeholder="Fecha">

                            <span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('fechai'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('fechai') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-4"><label>Hasta:</label>
                        <div class="form-group {{ $errors->has('fechaf') ? ' has-error' : '' }} has-feedback">
                            <input type="date" class="form-control" name="fechaf" value="{{$fechaf}}"
                                   placeholder="Fecha">

                            <span class="fa fa-calendar form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('fechaf'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('fechaf') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div  class="col-sm-12"><H4>Banco emisor</H4></div>
                        <div class="col-sm-5" style="width: 70%;">
                            <select name="bancoem" class="form-control select2" style="margin-top: 7px">
                                @if($banco)
                                    <option value="{{$banco}}">{{$banco}}</option>
                                    @else
                                <option value="">Selecciona un Banco Emisor</option>
                                @endif
                                @foreach($bancosg as $bancos)
                                    <option value="{{$bancos->banco}}">{{$bancos->banco}}</option>
                                @endforeach
                            </select>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-sm-2">
                        <button type="submit" style="margin-top: -8.2%;padding: 7px; margin-left: 72%;" class="btn btn-warning btn-xs btn"
                                data-toggle="tooltip" data-placement="right" title=""
                                data-original-title="Filtrar por fecha">
                            <i class="fa fas fa-calendar" aria-hidden="true"></i>
                        </button>
                    </div>
                    </div>
                    

                    <!--<button type="" style="margin-top: 24px;padding: 7px;" class="btn btn-warning btn-xs btn abrirFiltro"  data-toggle="tooltip" data-placement="left" title="" data-original-title="">
                                   <i class="fa fas fa-filter" aria-hidden="true"></i> Filtros Generales
                           </button>-->
                </form>
                <br>
                @if($operacionespos)
                    <!--{{$suma= 0}}-->
                    @for($i=0; $i< sizeof($operacionespos); $i++ )
                       <!--{{$suma = $suma + abs($operacionespos[$i]->monto)}}-->
                       @endfor
                    <label for="">El total del monto Pagado es:</label>
                       <h3>{{$suma}}$</h3>
                    @else
                         <h4>Inicia una nueva busqueda!</h4>
                    @endif

                    @if($operacionesneg)
                    <!--{{$suma= 0}}-->
                        @for($i=0; $i< sizeof($operacionesneg); $i++ )
                        <!--{{$suma = $suma + abs($operacionesneg[$i]->monto)}}-->
                        @endfor
                        <label for="">El total del monto que se debe pagar es:</label>
                        <h3>{{$suma}}$</h3>
                @else

                @endif
            </div>
@endsection

