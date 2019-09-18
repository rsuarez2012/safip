@extends('layouts.master')

@section('titulo', 'Crear Empresa')



@section('script')
    <script src="{!! asset('admin-lte/plugins/jquery/dist/jquery.min.js') !!}"></script>

    <script src="{!! asset('admin-lte/plugins/iCheck/icheck.js') !!}"></script>
        <link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">

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
                            <h2><i class="fa fa-building"></i> Registrar Empresa</h2>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            <hr>
          <div class="row">
              <div class="col-sm-8 col-sm-offset-2">
                  
                  <div class="clearfix"></div>
              

             <form class="form-horizontal" role="form" method="POST" action="{{ route('manageEmpresa-store-A') }}" enctype="multipart/form-data">
                          {!! csrf_field() !!}
                       
                   <div class="form-group {{ $errors->has('logo') ? ' has-error' : '' }} has-feedback">

                  <label class="control-label col-sm-2"> Cargar Logo</label>
                  <div class="col-sm-10">
                     <input type="file" class="form-control" name="imagen" value="" placeholder="Logo" >

                     <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                     @if ($errors->has('imagen'))
                         <span class="help-block">
                                      <strong>{{ $errors->first('imagen') }}</strong>
                                  </span>
                     @endif
                  </div>
                     
                 </div>

                   <div class="form-group {{ $errors->has('nombre') ? ' has-error' : '' }} has-feedback">

                  <label class="control-label col-sm-2"> Nombre</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="nombre" value="" placeholder="Nombre" >

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
                     <input type="text" class="form-control" name="rif" value="" placeholder="RUC" >

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
                    <input type="text" class="form-control" name="direccion" value="" placeholder="Direccion"  maxlength="255">

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
                     <input type="email" class="form-control" name="email" value="" placeholder="Email">

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
                     <input type="text" class="form-control" name="telefono_1" value="" placeholder="Telefono 1">

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
                     <input type="text" class="form-control" name="telefono_2" value="" placeholder="Telefono 2">

                     <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                     @if ($errors->has('telefono_2'))
                         <span class="help-block">
                                      <strong>{{ $errors->first('telefono_2') }}</strong>
                                  </span>
                     @endif
                  </div>
                     
                 </div>

                    <div class="form-group {{ $errors->has('web') ? ' has-error' : '' }} has-feedback">

                  <label class="control-label col-sm-2">Web Empresarial</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" name="web" value="" placeholder="Web Empresarial">

                     <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                     @if ($errors->has('web'))
                         <span class="help-block">
                                      <strong>{{ $errors->first('web') }}</strong>
                                  </span>
                     @endif
                  </div>
                     
                 </div>

                    <div class="form-group {{ $errors->has('slogan') ? ' has-error' : '' }} has-feedback">

                  <label class="control-label col-sm-2">Slogan</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="slogan" value="" placeholder="Slogan">

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

@endsection




   
