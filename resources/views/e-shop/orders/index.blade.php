@extends('layouts.master')

@section('script')
    <script type="text/javascript">
    $(document).ready(function(){

    $(".btn-detalle-pedido").on('click', function(e){
    e.preventDefault();

    var id_pedido = $(this).data('id');
    var path = $(this).data('path');
    var token = $(this).data('token');
    var modal_title = $(".modal-title");
    var modal_body = $(".modal-body");
    var loading = '<p><i class="fa fa-circle-o-notch fa-spin"></i> Cargando datos</p>';
    var table = $("#table-detalle-pedido tbody");
    var data = {'_token' : token, 'order_id' : id_pedido};

    modal_title.html('Detalle del Pedido: ' + id_pedido);
    table.html(loading);

    $.post(
    path,
    data,
    function(data){
    //console.log(response);
    table.html("");

    for(var i=0; i<data.length; i++){
        var APP_URL = {!!json_encode(url('/'))!!};
    var fila = "<tr>";
        fila += "<td><img src=" + APP_URL + "uploads/images/products/" + data[i].product.image + " width='30'></td>";
        fila += "<td>" + data[i].product.name + "</td>";
        fila += "<td>$ " + parseFloat(data[i].price).toFixed(2) + "</td>";
        fila += "<td>" + parseInt(data[i].quantity) + "</td>";
        fila += "<td>$ " + (parseFloat(data[i].quantity) * parseFloat(data[i].price)).toFixed(2) + "</td>";
        fila += "</tr>";

    table.append(fila);
    }
    },
    'json'
    );

    });


    });
    </script>
    @endsection

@section('content')
    <div class="container text-center">
        <div class="page-header">
            <h1>
                <i class="fa fa-shopping-cart"></i> PEDIDOS
            </h1>
        </div>
        
        <div class="page">
            
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Ver Detalle</th>
                            <th>Eliminar</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Subtotal</th>
                            <th>Envio</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>
                                    <a 
                                        href="#" 
                                        class="btn btn-primary btn-detalle-pedido"
                                        data-id="{{ $order->id }}"
                                        data-path="{{ route('manageOrders-getItems-A') }}"
                                        data-toggle="modal" 
                                        data-target="#myModal"
                                        data-token="{{ csrf_token() }}"
                                    >
                                        <i class="fa fa-external-link"></i>
                                    </a>
                                </td>
                                <td>
                                    <form class="form-horizontal" role="form" method="POST" action="{{ route('manageOrders-destroy-A',$order->id) }}" enctype="multipart/form-data">
                                        {!! csrf_field() !!}

        								<button onClick="return confirm('Eliminar registro?')" class="btn btn-danger">
        									<i class="fa fa-trash-o"></i>
        								</button>
                                    </form>
                                </td>
                                <td>{{ $order->created_at }}</td>
                                <td>{{ $order->user->name . " " . $order->user->last_name }}</td>
                                <td>${{ number_format($order->subtotal,2) }}</td>
                                <td>${{ number_format($order->shipping,2) }}</td>
                                <td>${{ number_format($order->subtotal + $order->shipping,2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <hr>
            
            <?php echo $orders->render(); ?>
            
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Detalle del Pedido: </h4>
                </div>
                <div class="modal-body">

                    <div class="table-responsive">
                        <table class="table table-stripped table-bordered table-hover" id="table-detalle-pedido">
                            <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@stop