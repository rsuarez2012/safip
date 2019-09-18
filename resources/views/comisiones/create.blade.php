@extends('layouts.master')

@section('titulo', 'Crear Comision')



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
                            <h2><i class="fa fa-building"></i> Registrar Comision</h2>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            <hr>
          <div class="row">
              <div class="col-sm-8 col-sm-offset-2">

             <form class="form-horizontal" role="form" method="POST" action="{{ route('manageComision-store-A') }}" enctype="multipart/form-data">
                          {!! csrf_field() !!}

                 <div class="form-group {{ $errors->has('consolidador_id') ? ' has-error' : '' }}">
                  <label class="col-sm-2 control-label">Consolidador</label>
                  <div class="col-sm-10">
                     <select name="consolidador_id" required class="form-control select2">
                         <option value="">Selecciona el Consolidador</option>
                         @foreach($consolidadores as $consolidador)
                             <option value="{{$consolidador->id}}">{{$consolidador->nombre}}</option>
                         @endforeach
                     </select>

                     @if ($errors->has('consolidador_id'))
                         <span class="help-block">
                                          <strong>{{ $errors->first('consolidador_id') }}</strong>
                                      </span>
                     @endif
                     </div>
                 </div>

                 <div class="form-group {{ $errors->has('laerea_id') ? ' has-error' : '' }}">
                   <label class="col-sm-2 control-label">Linea Aerea</label>
                  <div class="col-sm-10">
                     <select name="laerea_id" required class="form-control select2">
                         <option value="">Selecciona linea Aerea</option>
                         @foreach($laereas as $laerea)
                             <option value="{{$laerea->id}}">{{$laerea->nombre}}</option>
                         @endforeach

                     </select>

                     @if ($errors->has('laerea_id'))
                         <span class="help-block">
                                          <strong>{{ $errors->first('laerea_id') }}</strong>
                                      </span>
                     @endif
                   </div>
                 </div>

                 <div class="form-group {{ $errors->has('comision') ? ' has-error' : '' }} has-feedback">
                   <label class="col-sm-2 control-label">Comision</label>
                  <div class="col-sm-10">
                     <input type="number" step="any" class="form-control" name="comision" value="" placeholder="comision" >

                     <span class="fa fa-archive form-control-feedback right" aria-hidden="true"></span>

                     @if ($errors->has('comision'))
                         <span class="help-block">
                                      <strong>{{ $errors->first('comision') }}</strong>
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




   
