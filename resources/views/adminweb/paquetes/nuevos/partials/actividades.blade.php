  <table class="table table-bordered">
    <thead style="background-color: #dd4b39;">
      <tr style="color: #fff">
        <th class="col-xs-2" style="text-align: center;">Imagen</th>
        <th class="col-xs-1" style="text-align: center;" width="15px">N° del Dia</th>
        <th class="col-xs-1" style="text-align: center;">Día</th>
        <th class="col-xs-3" style="text-align: center;">Descripción</th>
        <th class="col-xs-1 text-center">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @php
        $id = 1;
      @endphp
      @foreach($dias as $dia)
        <tr v-for="(day, index) in package.dias">
          <td class="text-center" style=" vertical-align: middle;">
            <img src="{{asset('storage/miniature/'.$dia->imagen)}}" alt="Este dia no tiene una imagen">
            {{--<img  :src="route+'/storage/miniature/dia'+day.imagen" alt="Este dia no tiene una imagen">--}}
          </td>
          <td class="text-center">{{ $id++}}</td>
          <td class="text-center">{{ $dia->nombre }}</td>
          <td style="text-align: justify;">{{ $dia->descripcion}}</td>
          <td class="text-center">
              <button @click="showActivities(index)" class="btn btn-primary btn-xs" title="Ver Actividades" data-toggle="tooltip"><i class="fa fa-calendar"></i></button>
              <button @click="editDay(day)" class="btn btn-warning btn-xs" title="Editar Dia" data-toggle="tooltip"><i class="fa fa-pencil"></i></button>
              <button @click="deleteDay(day,index)" class="btn btn-danger btn-xs" title="Eliminar Dia" data-toggle="tooltip"><i class="fa fa-trash"></i></button>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>