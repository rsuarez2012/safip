@extends('layouts.master')

@section('titulo', 'Editor de Caja')

@section('css')
    <link href="{!! asset('admin-lte/plugins/select2/select2.min.css') !!}" rel="stylesheet">
@endsection

@section('script')
<script type="text/javascript">
    $("input[name=retiro]").keyup(function(){
        var monto={{$caja->monto}};
        var retiro= $("input[name=retiro]").val();
        var total = monto - retiro;
        $("input[name=monto]").val(total);
    });
</script>
@endsection

@section('content')
<div class="box padding_box1">
    
            <div class="x_title">
                <h2><i class="fa fa-building"></i>Retirar de Caja</h2>
                <hr>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-sm-8 col-sm-offset-2">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('manageCaja-retiro-save-A')}}">
                        {!! csrf_field() !!}
                        <input type="hidden" value="{{$caja->id}}" name="id">
                        <input type="hidden" value="0" name="impuesto">
                        <div class="form-group">
                            <input type="number" readonly="" class="form-control" name="monto" value="{{$caja->monto}}">
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" name="retiro" min="0" step="0.01">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="texto" placeholder="Motivo del retiro" required>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="sucursal" required>
                                <option value="">Seleccione Sucursal</option>
                                @foreach($opcion as $op)
                                <option value="{{$op->nombre}}">{{$op->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha del retiro <i class="fa fa-calendar"></i></label>
                            <input type="date" class="form-control" name="fecha" required>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success pull-right">
                                Retirar <i class="fa fa-arrow-circle-right"></i>
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