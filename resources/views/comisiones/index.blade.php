@extends('layouts.master')

@section('titulo', 'Comisiones')

@section('css')
    <!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
    <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
@endsection
@section('script')


    <script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
    <script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
    <script src={!! asset("admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>



    <script type="text/javascript">
        $(function () {
            $('#comisiones').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                 "lengthMenu": [ 50,100, 200, 500],
                "autoWidth": true
            });
        });
    </script>

@endsection

@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box padding_box1">
                <div class="row">
                    <div class="col-md-10">
                        <div class="x_title">
                            <h2><i class="fa fa-building"></i> Comisiones</h2>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-2" style="margin-top: 24px;">
                        <button type="button"
                                id="btn_new_comision"
                                class="btn btn-success"
                                style=" position: relative; z-index: 1;"
                                data-toggle="tooltip"
                                data-placement="left"
                                title="Nueva Comision">
                            <i class="fa fa-plus"></i> 
                        </button>
                    </div>
                </div>
                <hr>
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


                @if (count($comisiones) > 0)
                    <div class="table-responsive">
                        <table class="table" id="comisiones" >
                            <thead style="background-color: #dd4b39; color: white; ">
                            <tr>
                                <th class="col-md-1 text-center">ID</th>
                                <th class="col-md-2">Linea Aerea</th>
                                <th class="col-md-2">Consolidador</th>
                                <th class="col-md-2">Comision</th>
                                <th class="col-md-2">Acciones</th>

                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($comisiones as $comision)

                                <tr>
                                    <td class="text-center">{{$comision->id}}</td>
                                    <td>@if(!empty($comision->laereas->nombre))
                                            {{$comision->laereas->nombre}}
                                        @else
                                            
                                        @endif
                                    </td>
                                    <td>@if(!empty($comision->consolidadores->nombre))
                                            {{$comision->consolidadores->nombre}}

                                        @else
                                            Este cosnolidador Ya no Existe
                                    @endif</td>
                                    <td>{{$comision->comision}}</td>
                                    <td>
                                        <a class="btn btn-warning btn-xs" href="{{ route('manageComision-edit-A', $comision->id) }}" data-toggle="tooltip" data-placement="left" title="Editar">
                                            <i class="fa fa-pencil fa-lg"></i>
                                        </a>

                                        <a class="btn btn-danger btn-xs" href="{{ route('manageComision-destroy-A', $comision->id) }}" onclick="return confirm('Seguro que desea Eliminar el Registro {{$comision->id}}?')" data-toggle="tooltip" data-placement="left" title="Eliminar">
                                            <i class="fa fa-trash fa-lg"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach



                            </tbody>

                        </table>
                    </div>

                @else

                    <div class="alert alert-block alert-info" style="margin-top: 44px;">
                        <i class="fa fa-exclamation-triangle fa-1" style="float:left; margin-right: 16px;"></i>
                        <p class="margin-bottom-10">
                            No existen items registrados en el sistema.
                        </p>
                    </div>

                @endif
                <div class="modal fade" id="new_comision" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" style="width:112%;margin-left:0%">
                            <div class="modal-header">
                                <h4 class="modal-title">Crear Nueva Comisión</h4>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{route('manageComision-store-A')}}" id="form_store_comi">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="only_operator" value="0">
                                    <div class="row" style="margin-bottom: 10px">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3">
                                            <a class="btn btn-success pull-right" style="display: none" id="btn_with_laerea">Usar con Linea Aerea</a>
                                        </div>
                                        <div class="col-md-6">
                                            <a class="btn btn-success" id="btn_only_conso">Solo usar Consolidador</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Consolidadores</label>
                                            <select name="consolidador_id" required class="form-control select2">
                                                <option value="">Selecciona el Consolidador</option>
                                                @foreach($consolidadores as $consolidador)
                                                    <option value="{{$consolidador->id}}">{{$consolidador->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6" id="col-laerea">
                                            <label class="form-label">Lineas Aereas</label>
                                            <select name="laerea_id" required class="form-control select2">
                                                <option value="">Selecciona linea Aerea</option>
                                                @foreach($laereas as $laerea)
                                                    <option value="{{$laerea->id}}">{{$laerea->nombre}}</option>
                                                @endforeach
                       
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 12px;">
                                        <div class="col-md-6">
                                            <label class="form-label">Comision</label>
                                            <input type="number" step="any" class="form-control" name="comision" value="" placeholder="comision" >
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button id="cerrar_modal" type="button" class="btn btn-white">Cerrar</button>
                                <button id="create_comi" class="btn btn-danger">Crear Comisión</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(() => {
            let only_operator = 0;
            $("#btn_new_comision").click(() => {
                var span_con = $("select[name='consolidador_id']")[0].nextElementSibling
                var span_lin = $("select[name='laerea_id']")[0].nextElementSibling
                $(span_con).css('width','100%');
                $(span_lin).css('width','100%');
                $("#new_comision").modal('show');
            })
            $("#cerrar_modal").click(() => $("#new_comision").modal('hide'))

            $("#btn_only_conso").click(() => {
                $("input[name='only_operator']").val(1)
                $("#btn_only_conso").css('display', 'none')
                $("#col-laerea").css('display', 'none')
                $("#btn_with_laerea").css('display', '')
            })

            $("#btn_with_laerea").click(() => {
                $("input[name='only_operator']").val(0)

                $("#btn_only_conso").css('display', '')
                $("#col-laerea").css('display', '')
                $("#btn_with_laerea").css('display', 'none')
            })
            $("#create_comi").click(() => $("#form_store_comi").submit())
        })
    </script>
@endpush

