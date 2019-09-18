@extends('layouts.master')

@section('titulo', 'Validar Boletos')

@section('content')
    <div class="row" id="boletos_por_validar">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box" id="venta_boletos">
                <div class="box-header with-border">
                    <h2 class="box-title" style="font-size: 24px;"><i class="fa fa-ticket"></i> Boletos para validar</h2>
                </div>
                <div class="box-body">
                    <div class="col-md-10">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-danger">
                                    <tr>
                                        <th><input @click="checkGlobal()" type="checkbox" v-model="checked"></th>
                                        <th>Agente</th>
                                        <th>Agencia Viaje</th>
                                        <th>Codigo</th>
                                        <th>Numero Ticket</th>
                                        <th>Tarifa</th>
                                        <th>Tarifa FEE</th>
                                        <th>Utilidad</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="boleto in boletos">
                                        <th><input @change="checkCount()" type="checkbox" :id="boleto.id" :value="boleto" v-model="boletos_checked"></th>
                                        <th>@{{boleto.agentes_id}}</th>
                                        <th>@{{boleto.aviajes}}</th>
                                        <th>@{{boleto.codigo}}</th>
                                        <th>@{{boleto.nro_ticket}}</th>
                                        <th>@{{boleto.tarifa}}</th>
                                        <th>@{{boleto.tarifa_fee}}</th>
                                        <th>@{{boleto.utilidad}}</th>
                                        <th>
                                            <button @click="sendChanges(1,false,boleto)" class="btn btn-sm btn-primary">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            <button @click="sendChanges(0,false,boleto)" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input disabled class="form-control" :value="boletos.length + ' Boletos Por Verificar'">
                        <button v-show="boletos_checked.length > 0" class="btn btn-danger" style="margin: 10px 0px" @click="sendChanges(0,true)">Rechazar @{{boletos_checked.length}} Seleccionados</button>
                        <button v-show="boletos_checked.length > 0" class="btn btn-info" style="margin: 10px 0px" @click="sendChanges(1,true)">Aprobar @{{boletos_checked.length}} Seleccionados</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script >
        const boletos_por_validar = new Vue({
            el: '#boletos_por_validar',
            created() {
                this.loadPage()
            },
            data: {
                route:APP_URL,
                boletos_checked:[],
                checked:false,
                boletos:[]

            },
            methods: {
                loadPage()
                {
                    this.loading()
                    this.getBoletos()
                },
                getBoletos()
                {
                    let url_get_boletos = this.route + "/get/boletos/sin-validar"
                    axios.get(url_get_boletos).then(response => {
                        this.boletos = response.data
                        swal.close()
                    }).catch(errors => {
                        console.log(errors)
                        console.log(errors.response);
                        document.write(errors.response.data)
                    })
                },
                checkCount()
                {
                    if (this.boletos.length == this.boletos_checked.length) 
                    {
                        this.checked = true
                    }else 
                        {
                            this.checked = false
                        }
                },
                checkGlobal()
                {
                    if (this.checked) 
                    {
                        this.boletos_checked = []
                    }else 
                        {
                            this.boletos_checked = this.boletos
                            $("input:checkbox").attr("checked")   
                        }
                },
                sendChanges(change,multiple=false,boleto=null)
                {
                    let msg = "APROBAR"
                    if (change==0) {
                        msg = "RECHAZAR"
                    }
                    let ruta_cambiar_boletos = this.route + "/boletos/" + change
                    let aux_boletos = []
                    if (multiple)
                        {
                            aux_boletos = this.boletos_checked
                        } else 
                            {
                                aux_boletos.push(boleto)
                            }
                    swal("¿Esta seguro de quiere " + msg + " " + aux_boletos.length + " boletos ?" , {
                      buttons: {
                        cancel: "Cancelar",
                        catch: {
                          text: "Aceptar",
                          value: true,
                        },
                      },
                      icon:"warning"
                    })
                    .then((confirm) => {
                      if (confirm) {
                        this.loading()
                        axios.post(ruta_cambiar_boletos,{boletos : aux_boletos}).then(response => {
                            this.boletos = response.data
                            this.boletos_checked = []
                            this.alert("Exito","Se Editaron " + aux_boletos.length + " boleto(s)",'success')
                        }).catch(errors =>{
                            console.log(errors.response)
                            console.log(errors)
                            document.write(errors.response.data)
                        })
                      }
                    });
                    
                    
                    
                },
                loading() 
                {
                    swal({
                        title: "Procesando",
                        text: "espere un momento mientras se procesa la solicitud",
                        icon: this.route + "/imagenes/loader.gif",
                        button: {
                            text: "Ok",
                            value: false,
                            closeModal: false,
                        },
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        dangerMode: true,
                    })
                },
                alert(titles, texts, icons) 
                {
                    swal({
                        title: titles,
                        text: texts,
                        icon: icons,
                        button: {
                            text: "Continuar",
                            className: "btn-danger"
                        },
                    })
                },
            },
        });
    </script>
@endpush

