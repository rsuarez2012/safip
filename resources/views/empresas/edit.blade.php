@extends('layouts.master')

@section('titulo', 'Editar Empresa')

@section('css')
    <link href="{!! asset('admin-lte/plugins/select2/select2.min.css') !!}" rel="stylesheet">
@endsection

@section('content')
<div class="box padding_box1">
    
            <div class="x_title">
                <h2><i class="fa fa-pencil"></i>Editar Empresa</h2>
                <hr>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-8 col-sm-offset-2">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('manageEmpresa-update-A',$empresas->id)}}">
                        {!! csrf_field() !!}


                          <div class="form-group {{ $errors->has('logo') ? ' has-error' : '' }} has-feedback">

                  <label class="control-label col-sm-2">Logo</label>
                  <div class="col-sm-10">
                   <input type="file" class="form-control" name="imagen" value="{{$empresas->logo}}" placeholder="Logo" >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('imagen'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('imagen') }}</strong>
                                </span>
                            @endif
                  </div>
                     
                 </div>
                        
                          <div class="form-group {{ $errors->has('nombre') ? ' has-error' : '' }} has-feedback">

                  <label class="control-label col-sm-2">Nombre</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="nombre" value="{{$empresas->nombre}}" placeholder="Nombre" >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('nombre'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nombre') }}</strong>
                                </span>
                            @endif
                  </div>
                     
                 </div>
                       



                          <div class="form-group {{ $errors->has('rif') ? ' has-error' : '' }} has-feedback">

                  <label class="control-label col-sm-2">Ruc</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="rif" value="{{$empresas->rif}}" placeholder="RUC" >

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('rif'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('rif') }}</strong>
                                </span>
                            @endif
                  </div>
                     
                 </div>

                     
                          <div class="form-group {{ $errors->has('direccion') ? ' has-error' : '' }} has-feedback">

                  <label class="control-label col-sm-2">Direccion</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="direccion" value="{{$empresas->direccion}}" placeholder="Direccion"  maxlength="255">

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('direccion'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('direccion') }}</strong>
                                </span>
                            @endif
                  </div>
                     
                 </div>
                           <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} has-feedback">

                  <label class="control-label col-sm-2">Correo</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" name="email" value="{{$empresas->email}}" placeholder="Email">

                            <span class="fa fa-at form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                  </div>
                     
                 </div>

     <div class="form-group {{ $errors->has('telefono_1') ? ' has-error' : '' }} has-feedback">

                  <label class="control-label col-sm-2">Telefono 1</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="telefono_1" value="{{$empresas->telefono_1}}" placeholder="Telefono 1">

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('telefono_1'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('telefono_1') }}</strong>
                                </span>
                            @endif
                  </div>
                     
                 </div>

                  <div class="form-group {{ $errors->has('telefono_2') ? ' has-error' : '' }} has-feedback">

                  <label class="control-label col-sm-2">Telefono 2</label>
                  <div class="col-sm-10">
                   <input type="text" class="form-control" name="telefono_2" value="{{$empresas->telefono_2}}" placeholder="Telefono 2">

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('telefono_2'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('telefono_2') }}</strong>
                                </span>
                            @endif
                  </div>
                     
                 </div>
               
                <div class="form-group {{ $errors->has('web') ? ' has-error' : '' }} has-feedback ">

                  <label class="control-label col-sm-2">Web Empresarial</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="web" value="{{$empresas->web}}" placeholder="Web Empresarial">

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('web'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('web') }}</strong>
                                </span>
                            @endif
                  </div>
                     
                 </div>

                  <div class="form-group  {{ $errors->has('slogan') ? ' has-error' : '' }} has-feedback ">

                  <label class="control-label col-sm-2">Slogan</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="slogan" value="{{$empresas->slogan}}" placeholder="Slogan">

                            <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('slogan'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('slogan') }}</strong>
                                </span>
                            @endif
                  </div>
                     
                 </div>
                    

                        <div class="form-actions">
                            <button type="submit" class="btn btn-success pull-right">
                                Actualizar <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                            
                    </form>

                </div>

            </div>
            <div class="clearfix"></div>
</div>

@endsection

@section('script')
    <script src="{!! asset('admin-lte/plugins/select2/select2.min.js') !!}"></script>
@endsection