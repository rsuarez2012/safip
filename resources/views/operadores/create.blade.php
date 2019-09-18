@extends('layouts.master')

@section('titulo', 'Crear Operador')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-tagsinput.css') }}">
    <style>
      .bootstrap-tagsinput{
        width: 100%;
        border-radius: 0px;
        border-color: #d2d6de;
      }
    </style>
@endsection




@section('content')
<div class="box padding_box1">
  <div id="wrapper">
    <div id="login" class=" form" style="background-color: #FFF; padding: 0 20px; border-radius: 10px;">
      <section class="login_content">
        <div class="clearfix"></div>

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
        <div class="row"> 
          <div class="col-md-10">
            <div class="x_title">
                 <h2><i class="fa fa-building"></i> Registrar Operador</h2>
                <div class="clearfix"></div>
            </div>
            </div>
         <div class="col-md-10">
          <div class="x_title">
            
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
          <form class="form-horizontal " id="form-crear-operador" role="form" method="POST" action="{{ route('manageOperador-store-A') }}" enctype="multipart/form-data">
          {!! csrf_field() !!}

          <div class="form-group {{ $errors->has('empresa') ? ' has-error' : '' }}">
            <label class="col-sm-2 control-label">Empresa</label>
            <div class="col-sm-10">
           <select name="empresa" required class="form-control select2">
             <option value="">Selecciona La Empresa</option>
             @foreach($empresas as $empresa)
             <option value="{{$empresa->id}}">{{$empresa->nombre}}</option>
             @endforeach

           </select>
           </div>
         </div>

         <div class="form-group">
          <label class="col-sm-2 control-label">Nombre</label>
          <div class="col-sm-10">
           <input type="text" class="form-control" name="nombre" value="" placeholder="Nombre" >
           </div>
         </div>

         <div class="form-group">
           <label class="col-sm-2 control-label">Ruc</label>
          <div class="col-sm-10">
           <input type="text" class="form-control" name="rif" value="" placeholder="RUC">
         </div>
         </div>

         <div class="form-group" >
           <label class="col-sm-2 control-label">Direccion</label>
          <div class="col-sm-10">
           <input type="text" class="form-control" name="direccion" value="" placeholder="Direccion"  maxlength="255">
         </div>
         </div>
         <div class="form-group">
           <label class="col-sm-2 control-label">Telefono</label>
          <div class="col-sm-10">
           <input type="text" class="form-control" name="telefono" value="" placeholder="Telefono">
         </div>
         </div>

         <div class="form-group">
           <label class="col-sm-2 control-label">Email</label>
          <div class="col-sm-10">
           <input type="text" data-role="tagsinput" name="email" value="" placeholder="Email">
         </div>
         </div>

         <div class="form-group">
           <label class="col-sm-2 control-label">Web Empresarial</label>
          <div class="col-sm-10">
           <input type="text" class="form-control" name="web" value="" placeholder="Web Empresarial">
         </div>
         </div>
         <div class="form-group">
           <label class="col-sm-2 control-label">Tipo de Categoria</label>
          <div class="col-sm-10">
           <select name="tipo" id="" class="form-control select2" style="width: 100%;">
              <option value="" selected="selected">Tipo de Categoria</option>
              @foreach($tipos as $tipo)
                <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
              @endforeach
           </select>
         </div>
         </div>
         <div class="form-group">
           <label class="col-sm-2 control-label">Seleccione un Destino</label>
          <div class="col-sm-10">
           <select name="destino" id="" class="form-control select2" style="width: 100%;">
              <option value="" selected="selected">Seleccione un Destino</option>
              @foreach($destinos as $destino)
                <option value="{{$destino->id}}">{{$destino->nombre}}</option>
              @endforeach
           </select>
         </div>
         </div>
         <div class="form-actions">
          <button type="submit" id="enviar-data-form" class="btn btn-success pull-right">
            Registrar <i class="fa fa-arrow-circle-right"></i>
          </button>
        </div>
      </form>
    </div>
  </div>

</section>
</div>


</div>
</div>


{{--@endsection--}}

@section('script')

<script src="{{ asset('/js/bootstrap-tagsinput.js') }}"></script>
{{-- <script>
  $("#enviar-data-form").on("click",function(e){
    e.preventDefault();
    if($("input[name='email']").tagsinput('items').length > 0){
      $("#form-crear-operador").submit(); 
    }else{
      toastr.warning("coloque al menos un email");
    }
  });
  /* function submitForm(e){
    e.preventDefault();
    let emails = $("input[name='email']").tagsinput('items');
    if (emails.length == 0) {
      toastr.warning("Coloque al menos un email");
    }else{
      $("#form-crear-operador").submit;
    }
  } */
</script> --}}

@endsection





