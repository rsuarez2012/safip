@extends('layouts.master')

@section('titulo', 'Generador de Codigos')



@section('script')
    <script src="{!! asset('admin-lte/plugins/jquery/dist/jquery.min.js') !!}"></script>

    <script src="{!! asset('admin-lte/plugins/iCheck/icheck.js') !!}"></script>

@endsection

@section('content')


    <div class="">

        <div id="wrapper">
            <div id="login" class=" form" style="background-color: #FFF; padding: 0 20px; border-radius: 10px;">
                <section class="login_content">
                    <div class="clearfix"></div>
                    <div class="x_title">

                        <h2 style="text-align: center;"><i class="fa fa-barcode"></i> Generador de Codigos!</h2>
                        <div class="clearfix"></div>
                    </div>

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('manageGenerador-store-A') }}">
                        {!! csrf_field() !!}

                                <h3 style="text-align: center;"><i class="fa fa-key"></i>Introduzca correo al cual se le asiganara un codigo de recuperacion de clave</h3>
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} has-feedback">

                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Correo Electrónico" required>
                            <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-success pull-right">
                                Generar <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>


                    </form>
                </section>
            </div>


        </div>
    </div>
@endsection

