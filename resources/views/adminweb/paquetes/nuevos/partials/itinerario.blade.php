<table class="table table-bordered">
  <thead>
    <tr>
      <th>Dias</th>
      <th>Actividad</th>
      <th>Peruano Adulto</th>
      <th>Extranjero Adulto</th>
      <th>Comunidad Adulto</th>
      <th>Niño Peruano</th>
      <th>Niño Extranjero</th>
    </tr>
  </thead>
  <tbody>
    <template v-for="dia in package.dias">    
      <tr>
        <td :rowspan="dia.actividades.length+1">@{{dia.nombre}}</td> 
      </tr>
      <tr  v-for="actividad in dia.actividades">
        <td>@{{actividad.nombre}}</td>
        <template v-if="actividad.tipo == 'servicio'">
          <td>@{{actividad.servicio[0].servicio.peruano.adulto}}</td>
          <td>@{{actividad.servicio[0].servicio.extranjero.adulto}}</td>
          <td>@{{actividad.servicio[0].servicio.comunidad.adulto}}</td>
          <td>@{{actividad.servicio[0].servicio.peruano.ninio}}</td>
          <td>@{{actividad.servicio[0].servicio.extranjero.ninio}}</td>
        </template>    
        <template v-if="actividad.tipo == 'restaurante'">
          <td>@{{actividad.restaurante[0].restaurante.peruano.adulto}}</td>
          <td>@{{actividad.restaurante[0].restaurante.extranjero.adulto}}</td>
          <td>@{{actividad.restaurante[0].restaurante.comunidad.adulto}}</td>
          <td>@{{actividad.restaurante[0].restaurante.peruano.ninio}}</td>
          <td>@{{actividad.restaurante[0].restaurante.extranjero.ninio}}</td>
        </template>   
      </tr>
    </template>    
  </tbody>
  <tfoot><!--class="bg-head-tabla"-->
    <tr>
      <td colspan="2">TOTAL </td>
      <td v-for="col in total_itinerary">
          @{{Math.round(col * 100) / 100}}
      </td>
    </tr>
  </tfoot>
</table>