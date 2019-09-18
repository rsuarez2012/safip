@extends('layouts.master')

@section('titulo','Boletos Paquetes')

@section('content')
    <div id="main-vue">
        <div class="row">
            <div class="col-sm-12">
              {{-- box --}}
              <div class="box box-danger">
                {{-- box header --}}
                <div class="box-header">
                  <h3 class="box-title"><i class="fa fa-ticket"></i> Ventas de boletos de paquetes</h3>
                </div>
                {{-- box body --}}
                <div class="box-body">
                    <div class="col-12">
                        <!-- Custom Tabs -->
                        <div class="nav-tabs-custom tab-danger">
                          <ul class="nav nav-tabs">
                            <li class="active"><a href="#boletos_qantu" data-toggle="tab">Boletos Qantu</a></li>
                            <li><a href="#boletos_otro" data-toggle="tab">Boletos otro proveedor</a></li>
                          </ul>
                          <div class="tab-content">
                            <div class="tab-pane active" id="boletos_qantu">
                              <table-paginated tipo="qantu" ruta="{{ route('boletos.paquet.get') }}"></table-paginated>  
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="boletos_otro">
                              <table-paginated tipo="otro" ruta="{{ route('boletos.paquet.get') }}"></table-paginated>
                            </div>
                          </div>
                          <!-- /.tab-content -->
                        </div>
                        <!-- nav-tabs-custom -->
                      </div>
                </div>
                {{-- fin box-body --}}
              </div>
              {{-- fin box --}}
            </div>
          </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('/js/venta-paquete/index.js') }}"></script>
@endpush