@extends('layouts.master')

@section('titulo', 'Editor TDeudas')



@section('script')


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
                            <h2><i class="fa fa-building"></i> Registrar Tipo de Deuda</h2>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            <hr>
          <div class="row">
              <div class="col-sm-8 col-sm-offset-2">

                  <div class="clearfix"></div>
              

             <form class="form-horizontal" role="form" method="POST" action="{{ route('manageDeuda-store-A') }}" enctype="multipart/form-data">
                          {!! csrf_field() !!}



                 <div class="form-group {{ $errors->has('tipo') ? ' has-error' : '' }} has-feedback">
                     <input type="text" class="form-control" name="tipo" value="" placeholder="Tipo" >

                     <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                     @if ($errors->has('tipo'))
                         <span class="help-block">
                                      <strong>{{ $errors->first('tipo') }}</strong>
                                  </span>
                     @endif
                 </div>

                 <div class="form-group {{ $errors->has('descripcion') ? ' has-error' : '' }} has-feedback">
                     <input type="text" class="form-control" name="descripcion" value="" placeholder="Descripcion" >

                     <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                     @if ($errors->has('descripcion'))
                         <span class="help-block">
                                      <strong>{{ $errors->first('descripcion') }}</strong>
                                  </span>
                     @endif
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




   
