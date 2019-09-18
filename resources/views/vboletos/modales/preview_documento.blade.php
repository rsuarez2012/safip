<div class="modal" id="modalPreviewDocumento" style="overflow-y: scroll;overflow: auto">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: auto;margin: auto;">
      <div class="modal-header">
        <h4 id="titulo-modal-cotizacion" class="modal-title" style="display: inline;">
          <i class="fa fa-pencil-square-o"></i> Documento Cobranza</h4>
          <button type="button" class="close" data-dismiss="modal" onclick="$('#modalPreviewDocumento').fadeOut(300)">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" >
          <div class="p-1 border-document" v-if="$root.boletos_documento.length > 0">
            <table class="table">
              {{-- header --}}
              <tr class="row">
                <td class="col-8">
                  <p class="text-justify w-100 mb-0">
                    <strong>QANTU TRAVEL SOCIEDAD ANONIMA CERRADA – QANTU TRAVEL</strong>
                    <br>
                    AV. ALFREDO MENDIOLA 3621- URB. PANAMERICANA NORTE  
                    <br>
                    LOS OLIVOS – LIMA – LIMA
                    <br>
                    TELEFONO: 6776615 - 7463164
                    <br>
                    CELULAR:   
                  </p>
                </td>
                <td class="col-4 ">
                  <p class="w-100 my-1 border-document p-1">
                    <strong>DOCUMENTO DE COBRANZA</strong>
                    <br>
                    RUC: 20551016049
                    <br>
                    QT
                    <br>
                    DIA MES AÑO
                    <br>
                    {{date("d-m-Y")}}
                  </p>   
                </td>   
              </tr>
              {{-- body --}}
                <tr class="row border-document">
                <td>Señores:
                  <ul v-for="boleto in $root.boletos_documento">
                    <li>@{{boleto.nombre_cliente}}</li>
                  </ul>
                </td>
                <td>Documento: 
                  <ul v-for="boleto in $root.boletos_documento">
                    <li>@{{boleto.cliente_id}}</li>
                  </ul>
                </td>
                </tr>
                <tr class="row  border-document">
                <td>Direccion: 
                  <ul v-for="boleto in $root.boletos_documento">
                    <li>@{{boleto.cliente.direccion}}</li>
                  </ul>
                </td>
                <td>Telefono:
                  <ul v-for="boleto in $root.boletos_documento">
                    <li>@{{boleto.cliente.telefono}}</li>
                  </ul>  
                </td>
                </tr>
                <tr class="row border-document">
                  <td >Observacion: <span> @{{$root.cotizacion_documento.observacion}}</span></td>
                  <td>Agencia : @{{boletos_documento[0].aviajes}}</td>
                </tr>
            </table> 
            {{--lista--}}
            <table class="table border-document text-center">
              <thead>
                <tr class="row">
                  <th class="col-2">Cantidad</th>
                  <th class="col-2">Codigo</th>
                  <th class="col-6">Descripcion</th>
                  <th class="col-2">Valor Unitario</th>
                </tr>
              </thead>
              <tbody>
                <tr class="row">
                  <td class="col-2">@{{boletos_documento.length}}</td>
                  <td class="col-2">@{{boletos_documento[0].codigo}}</td>
                  <td class="col-6">Por la venta de boleto aereo</td>
                  <td class="col-2">@{{boletos_documento[0].tarifa_fee}}</td>
                </tr>
              </tbody>
            </table>
            <!--importante-->
            <table class="table border-document">
              <tr>  
                <td>
                  <p class="mt-2">IMPORTANTES:</p>
                  <textarea rows="6" class="form-control" v-model="observacion_documento"></textarea>
                  <p class="mt-2">COUNTER: @{{$root.boletos_documento[0].agentes_id}}</p>
                </td>
                <td>
                  <table class="table m-2 border-document">
                    <tr>
                      <td>A CUENTA</td>
                      <td class="border-document">@{{$root.pagado_documento}}</td>
                    </tr>
                    <tr>
                      <td>PENDIENTE</td>
                      <td class="border-document">@{{total_valor_unitario - $root.pagado_documento }}</td>
                    </tr>
                    <tr>
                      <td>TOTAL</td>
                      <td class="border-document">@{{total_valor_unitario}}</td>
                    </tr> 
                    <tr>
                      <td>PRECIO SOLES</td>
                      <td class="border-document">
                        <input type="number" step=".01" v-model="$root.soles_documento">
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>        
            </table>
            <table class="table text-center">
              <tr>
                <td>
                  ___________________________
                  <br>
                  FIRMA DE LA AGENCIA
                </td>
                <td>
                  ___________________________
                  <br>
                  FIRMA DEL PASAJERO
                </td>    
              </tr>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button onclick="$('#modalPreviewDocumento').fadeOut(300)" type="button" class="pull-left btn btn-secondary"><i class="fa fa-close"></i> Cancelar</button>
          <button onclick="document.getElementById('form-print-pdf').submit()" v-if="$root.boletos_documento.length > 0" target="_blank" class="pull-right btn btn-danger"><i class="fa fa-print"></i> Imprimir</button>
        </div>
      </div>
    </div>
        <form v-if="boletos_documento.length > 0"  id="form-print-pdf" :action="route+'/documento/cobranza/'+boletos_documento[0].codigo+'/print'">
          <input type="hidden" step=".01"  v-model="$root.soles_documento" name="soles">
          <textarea class="form-control" style="opacity: 0" name="texto" v-model="observacion_documento"></textarea>
        </form>  
  </div>