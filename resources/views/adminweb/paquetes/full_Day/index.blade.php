@extends('layouts.master')
@section('titulo', 'Paquetes Full Day')

@push('css')
    <style type="text/css">
        
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="box">
                <div class="row" style="margin-left: 1%;margin-right: 1%;">
                    <div class="col-md-10">
                        <div>
                            <h2><i class="fa fa-cubes"></i>Paquetes Full Day</h2>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <a href="{{route('full_day.new_paquete')}}"
                            class="btn btn-danger pull-right" style="margin-top:14%;">
                            <i class="fa fa-plus-circle"></i> Crear Nuevo Paquete
                        </a>
                    </div>
                </div>
                <hr>
                <div class="box-body">
                    <table id="full_days" class="table table-bordered table-striped table-responsive">
                        <thead style="background-color: #dd4b39; color: white; ">
                            <tr>
                                <th>IMAGEN</th>
                                <th>CODIGO</th>
                                <th>NOMBRE</th>
                                <th>ESTADO</th>
                                <th class="text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paquetes as $paquete)
                                {{-- {{dd($paquete)}} --}}
                                <tr>
                                    <td class="text-center">
                                        <img src="{{ asset('/storage/miniature/full_day/'.$paquete->imagen) }}" alt="img paquete full day" width="100" height="70">
                                    </td>
                                    <td>{{ $paquete->codigo }}</td>
                                    <td>{{ $paquete->nombre }}</td>
                                    <td id="td_estado_{{ $paquete->id }}">{{ $paquete->estado }}</td>
                                    <td>
                                        @if ($paquete->statusCreado != 'terminado')
                                        <a href="{{ route('full_day.edit_paquete', $paquete->id) }}" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> Continuar</a>
                                        @else                                            
                                        <a href="{{ route('full_day.edit_paquete', $paquete->id) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Editar</a>
                                        <button class="btn btn-xs bg-olive"
                                                title="Clonar Paquete"
                                                data-toggle="tooltip"
                                                onclick="">
                                            <i class="fa fa-clone"></i>
                                        </button>
                                            @if($paquete->estado == 'visible')
                                                <button class="btn btn-xs btn-primary btn_ocultar_{{$paquete->id}}"
                                                        style="display: ;" 
                                                        onclick="cambiar_estado('{{$paquete->id}}', 'oculto')"
                                                        value="oculto"
                                                        title="Ocultar Para La Web"
                                                        data-toggle="tooltip">
                                                    <i class="fa fa-eye-slash"></i>
                                                </button>
                                                <button class="btn btn-xs btn-primary btn_visible_{{$paquete->id}}"
                                                        style="display: none;" 
                                                        onclick="cambiar_estado('{{$paquete->id}}', 'visible')"
                                                        value="visible"
                                                        title="Mostrar en La Web"
                                                        data-toggle="tooltip">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <button class="btn btn-xs btn-warning btn_destacado_{{$paquete->id}}"
                                                        onclick="cambiar_estado('{{$paquete->id}}', 'destacado')"
                                                        value="destacado"
                                                        title="Colocar en Destacados"
                                                        data-toggle="tooltip">
                                                    <i class="fa fa-star"></i>
                                                </button>
                                            @elseif($paquete->estado ==  'oculto')
                                                <button class="btn btn-xs btn-primary btn_visible_{{$paquete->id}}"
                                                        onclick="cambiar_estado('{{$paquete->id}}', 'visible')"
                                                        value="visible"
                                                        title="Mostrar en La Web"
                                                        data-toggle="tooltip">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <button class="btn btn-xs btn-primary btn_ocultar_{{$paquete->id}}"
                                                        style="display: none;" 
                                                        onclick="cambiar_estado('{{$paquete->id}}', 'oculto')"
                                                        value="oculto"
                                                        title="Ocultar Para La Web"
                                                        data-toggle="tooltip">
                                                    <i class="fa fa-eye-slash"></i>
                                                </button>
                                                <button class="btn btn-xs btn-warning btn_destacado_{{$paquete->id}}"
                                                        style="display: none;" 
                                                        onclick="cambiar_estado('{{$paquete->id}}', 'destacado')"
                                                        value="destacado"
                                                        title="Colocar en Destacados"
                                                        data-toggle="tooltip">
                                                    <i class="fa fa-star"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-xs btn-primary btn_ocultar_{{$paquete->id}}"
                                                        style="display: ;" 
                                                        onclick="cambiar_estado('{{$paquete->id}}', 'oculto')"
                                                        value="oculto"
                                                        title="Ocultar Para La Web"
                                                        data-toggle="tooltip">
                                                    <i class="fa fa-eye-slash"></i>
                                                </button>
                                                <button class="btn btn-xs btn-primary btn_visible_{{$paquete->id}}"
                                                        onclick="cambiar_estado('{{$paquete->id}}', 'visible')"
                                                        value="visible"
                                                        title="Mostrar en La Web"
                                                        data-toggle="tooltip">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            @endif
                                        @endif
                                        <a class="btn btn-xs btn-danger"
                                            title="Eliminar Paquete"
                                            data-toggle="tooltip"
                                            onclick="delete_paquete('{{$paquete->id}}')">
                                            <i class="fa fa-trash "></i>
                                        </a>
                                        <form id="form_delete_{{$paquete->id}}" action="{{route('full_day.delete_paquete', $paquete->id)}}" method="POST" style="display:none;">
                                            {{method_field('DELETE')}}
                                            {{csrf_field()}}
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $("#full_days").DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
        });

        function delete_paquete(id){
            swal({
                title: "Alerta!.",
                text: "Realmente esta seguro que desea eliminar este paquete.\n Tenga en cuenta que también eliminara los datos que dependan de este paquete!.",
                icon: "warning",
                buttons: {
                    cancel: "Cancelar",
                    confirm: {
                        text: "Acepto",
                        closeModal: false,
                    }
                },
                closeOnClickOutside: false,
                closeOnEsc: false,
                dangerMode: true,
            }).then(response => {
                if(response){
                    $('#form_delete_'+id).submit(); 
                }
            });
        }

        function cambiar_estado(paquete_id, estado){
            let url_state = APP_URL + '/tablero/Paquete/Full_Day/change/state/paquete/' + paquete_id;
            toastr.info('El estado del paquete esta siendo cambiado!');
            axios.post(url_state, {estado: estado}).then(response => {
                console.log(response.data);
                if(estado == 'oculto'){
                    $("#td_estado_"+paquete_id).text('oculto')
                    $(".btn_ocultar_"+paquete_id).css('display', 'none');
                    $(".btn_visible_"+paquete_id).css('display', '');
                    $(".btn_destacado_"+paquete_id).css('display', 'none');
                } else if(estado == 'visible'){
                    $("#td_estado_"+paquete_id).text('visible')
                    $(".btn_ocultar_"+paquete_id).css('display', '');
                    $(".btn_destacado_"+paquete_id).css('display', '');
                    $(".btn_visible_"+paquete_id).css('display', 'none');
                } else if(estado == 'destacado'){
                    $(".btn_destacado_"+paquete_id).css('display', 'none');
                }
                toastr.success('El estado del paquete ha sido cambiado!', 'Excelente!');
            }).catch(error => {
                console.log(error);
                console.log(error.response);
            });
        }
    </script>
@endpush