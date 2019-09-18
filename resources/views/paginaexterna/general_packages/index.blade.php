@extends('paginaexterna.index')

@section('titulo', '')

@section('css')

@endsection

@section('script')
<script>
    $(document).ready(function(){
        $('.abrir').click(function(){
            $('#modalTarifas').fadeIn(300);
        });
    });
</script>
@endsection


@section ('content')
<div class="clearfix"></div>
<div class="row">
	<div class="contenido2 contenidos-custom">
		<div class="content_filt content_filt2">
            <div class="content-selects">
                <div style="display: block;" id="Tab1" class="tabcontent">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Destino" aria-label="Search for...">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" placeholder="Fecha" id="reservation">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Aereolinea" aria-label="Search for...">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <button class="btn">Buscar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="Tab2" class="tabcontent">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Buscar por" aria-label="Destino">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Buscar por" aria-label="Fecha">
                        </div>
                    </div>
                </div>
            </div>

            <div id="Tab3" class="tabcontent">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Buscar por" aria-label="Aereolinea">
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab">
                <a class="tablinks" onclick="openTab(event, 'Tab1')"><img src="{{asset('web/images/iconos/cruceros.png')}}" alt="Vuelos"><span class="image-title">Paquetes</span>
                </a>
                <a class="tablinks" onclick="openTab(event, 'Tab2')"><img src="{{asset('web/images/iconos/vuelos.png')}}" alt="Vuelos"><span class="image-title">Salidas Confirmadas</span>
                </a>
                <a class="tablinks" onclick="openTab(event, 'Tab3')"><img src="{{asset('web/images/iconos/oferta.png')}}" alt="Vuelos"><span class="image-title">Exclusiones y Entradas</span>
                </a>
            </div>

        </div>

    </div>
    <br>
    {{-- @foreach($destinos as $fila)
    <div class="box-paquetesgen">
     <ul>
        <h3>{{$fila->destination_name}}</h3>
        <h5>Paquete</h5>
        <li>
           @foreach($paquetes as $paquete)
           @if($paquete->destino == $fila->destination_name)
           <div class="row">
              <div class="col-sm-5">
                 <h6>{{$paquete->nombre}}</h6>
                 <p>
                    @if($paquete->duracion==1)
                    {{$paquete->duracion." Dia / ".$paquete->duracion." Noche "}}
                    @else
                    {{$paquete->duracion." Dias / ".($paquete->duracion-1)." Noches"}}
                    @endif
                </p>
            </div>
            <div class="col-sm-4 tarif-co">{{"$".$paquete->precio_dolar." ó S/".$paquete->precio_sol}}<p>Tarifa por pax</p></div>

            <div class="col-sm-3">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Tarifas
                </button></div>
            </div>
            @endif
            @endforeach
        </li>
    </ul>
</div>	
@endforeach --}}



</div>
</div>
<div class="example-modal" >
    <div class="modal modal-danger fade in" id="modalTarifas">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Danger Modal</h4>
          </div>
          <div class="modal-body">
            <p>One fine body&hellip;</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-outline">Save changes</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
</div>

<!-- Modal -->
<div class="modal fade modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="left: 20%;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Lista Tarifas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body text-center">
     <table class="text-dark">
 {{--     @foreach($tarifas as $tarifa)
       <tr>
            <td><input type="radio"></td>
            <td>{{$tarifa->hotel}}</td>
            <td>{{$tarifa->star}}</td>
            <td>{{$tarifa->categoria}}</td>
            <td>{{$tarifa->e_swb}}</td>
            <td>{{$tarifa->e_dwb}}</td>
            <td>{{$tarifa->e_tpl}}</td>
            <td>{{$tarifa->e_chd}}</td>
            <td>{{$tarifa->p_swb}}</td>
            <td>{{$tarifa->p_dwb}}</td>
            <td>{{$tarifa->p_tpl}}</td>
            <td>{{$tarifa->p_chd}}</td>
            <td>{{$tarifa->check_in}}</td>
            <td>{{$tarifa->check_out}}</td>
        </tr>
    @endforeach() --}}
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
</div>
</div>
</div>
</div>
@endsection
