@extends('layouts.master')
@section('titulo', 'Paquetes')

@section('css')
<style type="text/css">
.center-y{
  vertical-align: middle !important;
}
th, td {
  text-align: center;
}
</style>
<!----  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">

<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">
@endsection


@section('content')


  <div class="row">
      <div hidden="true"
          id="div-alerta"
          class="callout callout-danger"
          style="position: fixed;z-index: 999999;">
      </div>
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="box">
              <div class="row" style="margin-left: 1%;margin-right: 1%;">
                  <div class="col-md-10">
                      <div>
                          <h2><i class="fa fa-cubes"></i>Paquetes</h2>
                          <div class="clearfix"></div>
                      </div>
                  </div>
                  <div class="col-md-2">
                      {{--<a href="{{route('manageProduct-paso-1-A')}}"
                          class="btn btn-danger pull-right" style="margin-top:14%;">--}}
                      <a href="{{route('paquete.create')}}"
                          class="btn btn-danger pull-right" style="margin-top:14%;">
                          <i class="fa fa-plus-circle"></i> Crear Nuevo Paquete
                      </a>
                  </div>
              </div>
              <hr>
              <div class="box-body">
                  <table id="paquetes" class="table table-bordered table-hover table-responsive">
                      <thead style="background-color: #dd4b39; color: white; ">
                          <tr>
                              <th>IMAGEN</th>
                              <th>NOMBRE</th>
                              <th>CODIGO</th>
                              <th>ESTADO</th>
                              <th>EXTRACTO</th>
                              <th>CATEGORIA</th>
                              <th class="text-center">ACCIONES</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($paquetes as $paquete)
                          <tr >
                              <td class="text-center"><img src="{{asset('storage/miniature/'.$paquete->imagen)}}" alt="" width="100"></td>
                              <td class="center-y">{{$paquete->nombre}}</td>
                              <td class="center-y">{{$paquete->codigo}}</td>
                              <td class="center-y" id="estado-{{$paquete->id}}">{{$paquete->estado}}</td>
                              <td class="center-y">{{$paquete->extracto}}</td>
                              <td class="center-y">{{$paquete->categoria->nombre}}</td>
                              <td class="text-center center-y" style="min-width: 200px;" name="{{$paquete->id}}">
                                  
                                  <!--Verifico que el paquete no este terminado y verifico la categoria-->
                                  @if($paquete->categoria_id == '6' && $paquete->statusCreado != 'terminado')
                                      <a href="{{ route('full_day.edit_paquete', $paquete->id) }}" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> Continuar</a>
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
                                  @elseif($paquete->categoria_id == '6')
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
                                              @elseif($paquete->estado == 'oculto')
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
                                              <!--HASTA AQUI SON LOS PAQUETES FULLDAY-->

                                  @else
                                      @if($paquete->statusCreado != 'terminado' && $paquete->categoria_id != '6')
                                          <a href="{{ route('continuar.paquete', [$paquete, $paquete->statusCreado]) }}" class="btn-xs btn btn-warning"><i class="fa fa-pencil"></i> Continuar</a>
                                      @else
                                          <a href="{{ route('paquete.edit.paso1', $paquete->id) }}" class="btn btn-xs btn-warning" title="Datos del paquete" data-toggle="tooltip"><i class="fa fa-list-alt"></i></a>
                                          <a href="{{ route('paquete.edit.paso2', $paquete->id) }}" class="btn btn-xs btn-warning" title="Hoteles Y Destinos" data-toggle="tooltip"><i class="fa fa-hotel"></i></a>
                                  
                                          <a href="{{ route('paquete.edit.paso3', $paquete->id) }}" class="btn btn-xs btn-warning" title="Itinerario" data-toggle="tooltip"><i class="fa fa-calendar"></i></a>
                                      
                                          {{--<a href="{{ route('paquete.edit.paso4', $paquete->id) }}" class="btn btn-xs btn-warning" title="Datos Adicionales" data-toggle="tooltip"><i class="fa fa-list"></i></a>--}}
                                          @if($paquete->estado == 'visible' && $paquete->categoria_id != '6')
                                                  <button class="btn btn-xs btn-primary cambiar-estado" value="oculto" title="Ocultar Para La Web" data-toggle="tooltip"><i class="fa fa-eye-slash"></i></button>
                                                  <button class="btn btn-xs btn-primary cambiar-estado" value="destacado" title="Colocar en Destacados" data-toggle="tooltip"><i class="fa fa-star"></i></button>
                                              @elseif($paquete->estado ==  'oculto' && $paquete->categoria_id != '6')
                                                  <button class="btn btn-xs btn-primary cambiar-estado" value="visible" title="Mostrar en La Web" data-toggle="tooltip"><i class="fa fa-eye"></i></button>
                                                  <button class="btn btn-xs btn-primary cambiar-estado" value="destacado" title="Colocar en Destacados" data-toggle="tooltip"><i class="fa fa-star"></i></button>

                                              @else
                                                  <button class="btn btn-xs btn-primary cambiar-estado" value="visible" title="Mostrar en La Web" data-toggle="tooltip"><i class="fa fa-eye"></i></button>
                                                  <button class="btn btn-xs btn-primary cambiar-estado" value="oculto" title="Ocultar Para La Web" data-toggle="tooltip"><i class="fa fa-eye-slash"></i></button>
                                              @endif
                                              <button class="btn btn-xs bg-olive"title="Clonar Paquete" data-toggle="tooltip" onclick="levantar_modal_clonar_paquete('{{$paquete->id}}', '{{$paquete->nombre}}')"><i class="fa fa-clone"></i>
                                              </button>
                                          @endif
                                              <a class="btn btn-xs btn-danger" title="Eliminar Paquete" data-toggle="tooltip" onclick="delete_paquete('{{$paquete->id}}')"><i class="fa fa-trash "></i></a>
                                              <form id="form_delete_{{$paquete->id}}" action="{{route('paquetes.delete', $paquete->id)}}" method="POST" style="display:none;">
                                                  {{method_field('DELETE')}}
                                                  {{csrf_field()}}
                                              </form>
                                      
                                  @endif



                                 



                                  {{--@if($paquete->statusCreado != 'terminado' && $paquete->categoria_id != '6')
                                  <a href="{{ route('continuar.paquete', [$paquete, $paquete->statusCreado]) }}" class="btn-xs btn btn-warning"><i class="fa fa-pencil"></i> Continuar</a>
                                  @else
                                      <a href="{{ route('paquete.edit.paso1', $paquete->id) }}" class="btn btn-xs btn-warning" title="Datos Basicos" data-toggle="tooltip"><i class="fa fa-list-alt"></i></a>
                                  
                                      <a href="{{ route('paquete.edit.paso2', $paquete->id) }}" class="btn btn-xs btn-warning" title="Hoteles Y Destinos" data-toggle="tooltip"><i class="fa fa-hotel"></i></a>
                                  
                                      <a href="{{ route('paquete.edit.paso3', $paquete->id) }}" class="btn btn-xs btn-warning" title="Itinerario" data-toggle="tooltip"><i class="fa fa-calendar"></i></a>
                                  
                                      <a href="{{ route('paquete.edit.paso4', $paquete->id) }}" class="btn btn-xs btn-warning" title="Datos Adicionales" data-toggle="tooltip"><i class="fa fa-list"></i></a>
                              
                                      @if($paquete->estado == 'visible' && $paquete->categoria_id != '6')
                                      <button class="btn btn-xs btn-primary cambiar-estado" value="oculto" title="Ocultar Para La Web" data-toggle="tooltip"><i class="fa fa-eye-slash"></i></button>
                                      <button class="btn btn-xs btn-primary cambiar-estado" value="destacado" title="Colocar en Destacados" data-toggle="tooltip"><i class="fa fa-star"></i></button>
                                      @elseif($paquete->estado ==  'oculto' && $paquete->categoria_id != '6')
                                      <button class="btn btn-xs btn-primary cambiar-estado" value="visible" title="Mostrar en La Web" data-toggle="tooltip"><i class="fa fa-eye"></i></button>
                                      <button class="btn btn-xs btn-primary cambiar-estado" value="destacado" title="Colocar en Destacados" data-toggle="tooltip"><i class="fa fa-star"></i></button>

                                      @else
                                      <button class="btn btn-xs btn-primary cambiar-estado" value="visible" title="Mostrar en La Web" data-toggle="tooltip"><i class="fa fa-eye"></i></button>
                                      <button class="btn btn-xs btn-primary cambiar-estado" value="oculto" title="Ocultar Para La Web" data-toggle="tooltip"><i class="fa fa-eye-slash"></i></button>
                                      @endif--}}
                                      {{-- CLONAR PAQUETE --}}
                                      {{--<button class="btn btn-xs bg-olive"
                                              title="Clonar Paquete"
                                              data-toggle="tooltip"
                                              onclick="levantar_modal_clonar_paquete('{{$paquete->id}}', '{{$paquete->nombre}}')">
                                          <i class="fa fa-clone"></i>
                                      </button>
                                  @endif
                                  <a class="btn btn-xs btn-danger" title="Eliminar Paquete" data-toggle="tooltip" onclick="delete_paquete('{{$paquete->id}}')"><i class="fa fa-trash "></i></a>
                                  <form id="form_delete_{{$paquete->id}}" action="{{route('paquetes.delete', $paquete->id)}}" method="POST" style="display:none;">
                                      {{method_field('DELETE')}}
                                      {{csrf_field()}}
                                  </form>--}}
                              </td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
              <div class="modal fade" id="clonar_paquete_modal" tabindex="-1" role="dialog">
                  <div class="modal-dialog modal-sm" role="document">
                      <div class="modal-content" style="width:112%;margin-left:0%">
                          <div class="modal-header">
                              <h4 class="modal-title" id="test_paquete_name"></h4>
                          </div>
                          <div class="modal-body">
                              <form method="POST" action="{{route('clonar.paquete')}}" id="form_clonar_paquete">
                                  {{ csrf_field() }}
                                  <input type="hidden" id="paquete_id" name="paquete_id" value="">
                                  <input type="hidden" id="codigo_paquete" name="codigo_paquete" value="">
                                  <div class="row">
                                      <div class="col-md-12">
                                          <b>Código del nuevo paquete</b>
                                          <div class="form-line">
                                              <input  type="text"
                                                      name="codigo"
                                                      value=""
                                                      class="form-control"
                                                      placeholder="Ex: ABC1-DEF2-GHI3"
                                                      autofocus>
                                          </div>
                                      </div>
                                  </div>
                              </form>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-white" {{-- data-dismiss="modal" --}} onclick="cerrar_modal()">Cerrar</button>
                              <button id="validar_code" class="btn btn-danger" style="display:;" onclick="validar_codigo_paquete()">Validar Codigo</button>
                              <button id="clonar_paquete" class="btn btn-danger" style="display:none;" onclick="clonar_paquete()">Clonar Paquete</button>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>


@endsection

@section('script')

<script>
  $(function () {
    $('#paquetes').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
  });
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
  function levantar_modal_clonar_paquete(paquete_id, paquete_name){
      $('#test_paquete_name').text('Paquete a clonar: '+paquete_name)
      $("#paquete_id").val(paquete_id);
      $("#clonar_paquete_modal").modal('show')
  }
  function validar_codigo_paquete(){
      let codigo_a_validar = $("input[name='codigo']").val().toUpperCase()
      if(codigo_a_validar != ''){
          toastr.info('El codigo esta siendo validado!.')
          let url = APP_URL+'/validate/code/'+codigo_a_validar;
          axios.get(url).then(response => {
              if(response.data > 0){
                  toastr.warning('El código ingresado ya existe!.');
                  $("#clonar_paquete").css('display', 'none');
              } else {
                  toastr.success('Excelente!, el código ingresado es valido.');
                  $("input[name='codigo']").attr("disabled",true);
                  $("#validar_code").css('display', 'none');
                  $("#clonar_paquete").css('display', '');
              }
          }).catch(error => {
              console.log(error.response)
          });
      } else {
          toastr.warning('Disculpe!, Debe escribir un codigo!.');
      }
  }
  function clonar_paquete(){
      swal({
		title: "Atención!.",
		text: "¿Está seguro de que desea clonar este paquete?.",
		icon: "warning",
		buttons: {
			cancel: 'No',
			confirm: 'Si'
		}
	}).then(response => {
		if(response){
			swal({
				title: "Espere un momento!",
				text: "El paquete esta siendo clonado.",
				icon: APP_URL+"/imagenes/loader.gif",
				button: {
					text: "Entiendo",
					value: false,
					closeModal: false,
				  },
				closeOnClickOutside: false,
				closeOnEsc: false,
              });
              $("#codigo_paquete").val($("input[name='codigo']").val());
              $('#form_clonar_paquete').submit();
		}
	});
  }
  function cerrar_modal(){
      $("input[name='codigo']").val('');
      $("input[name='codigo']").removeAttr("disabled",false);
      $("#validar_code").css('display', '');
      $("#clonar_paquete").css('display', 'none');
      $("#clonar_paquete_modal").modal('hide')
  }
</script>


<script src="{{asset('js/paquetes/index.js')}}"></script>

@endsection
