@extends('paginaexterna.index')

@section('titulo', 'Terminos y Condiciones')

@section('css')

@endsection

@section('script')


@endsection


@section ('content')

        <div class="col-md-6 ">
            <div class="form-group">
                <input name="nombre" type="text" id="nombre" class="form-control" placeholder="Nombre">
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="form-group">
                <input name="email" type="email" id="email" class="form-control" placeholder="e-mail">
            </div>
        </div>

        <div class="col-md-6 col-offset-3 ">
            <div class="form-group">
                <textarea name="mensaje" id="mensaje" class="form-control" placeholder="Consultas e Informes"></textarea>
            </div>
        </div>
        <div class="col-md-6 col-offset-3 ">
            <div class="form-group {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }} has-feedback">
                {!! NoCaptcha::renderJs() !!}
                {!! NoCaptcha::display() !!}

                @if ($errors->has('g-recaptcha-response'))
                    <span class="help-block">
                                          <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                      </span>
                @endif
            </div>
        </div>
        <div class="col-md-6 col-offset-3">
            <div class="form-group">
                <input type="submit" name="enviar" value="Enviar" onclick="" id="enviar" class="btn btn_orange btn-lg btn-block">
            </div>
        </div>


@endsection
