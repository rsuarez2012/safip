@extends('layouts.master')

@section('titulo', 'Registrar Iva')



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
                            <h2><i class="fa fa-percent"></i> Registrar Iva</h2>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            <hr>
          <div class="row">
              <div class="col-sm-8 col-sm-offset-2">

                  <div class="clearfix"></div>
              

             <form class="form-horizontal" role="form" method="POST" action="{{ route('manageIva-store-A') }}" enctype="multipart/form-data">
                          {!! csrf_field() !!}


                 <div class="form-group {{ $errors->has('iva') ? ' has-error' : '' }} has-feedback">
                  <label class="col-sm-2 control-label">Ingrese Iva</label>
                  <div class="col-sm-10">
                     <input type="number" class="form-control" name="iva" value="" placeholder="Iva" >

                     <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                     @if ($errors->has('iva'))
                         <span class="help-block">
                                      <strong>{{ $errors->first('iva') }}</strong>
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




   
