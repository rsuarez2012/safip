<div class="row">
<div class="col-md-12">
<div class="box box-solid">
<div class="box-header with-border">
<h3 class="box-title">Collapsible Accordion</h3>
</div>
<!-- /.box-header -->
<div class="box-body">
<div class="box-group" id="accordion">
<!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
<div class="panel box box-danger">
<div class="box-header with-border">
<h4 class="box-title">
<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
<i class="fa fa-sun-o"></i>  Dias
</a>
</h4>
</div>
<div id="collapseOne" class="panel-collapse collapse in">
<div class="box-body">
<div  class="row">
<div class="col-xs-12">
<button :disabled="view_button_new" @click="newDay(package.id)" class="btn btn-danger pull-right"><i class="fa fa-plus-circle"></i> Agregar Dia</button>    
</div>
</div>
<br>
<div class="table-responsive">
<table class="table table-bordered">
<thead style="background-color: #dd4b39;">
<tr style="color: #fff">
<th class="col-xs-2">Imagen</th>
<th class="col-xs-1">N° del Dia</th>
<th class="col-xs-1">Nombre</th>
<th class="col-xs-4">Descripción</th>
<th class="col-xs-1 text-center">Acciones</th>
</tr>
</thead>
<tbody>
<tr v-for="(day, index) in package.dias">
<td class="text-center" style=" vertical-align: middle;"><img  :src="route+'/storage/miniature/dia'+day.imagen" alt="Este dia no tiene una imagen"></td>
<td class="text-center">@{{(index+1)}}</td>
<td class="text-center">@{{day.nombre}}</td>
<td style="text-align: justify;">@{{day.descripcion}}</td>
<td class="text-center">
<button @click="showActivities(index)" class="btn btn-primary btn-xs" title="Ver Actividades" data-toggle="tooltip"><i class="fa fa-calendar"></i></button>
<button @click="editDay(day)" class="btn btn-warning btn-xs" title="Editar Dia" data-toggle="tooltip"><i class="fa fa-pencil"></i></button>
<button @click="deleteDay(day,index)" class="btn btn-danger btn-xs" title="Eliminar Dia" data-toggle="tooltip"><i class="fa fa-trash"></i></button>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
<div class="panel box box-danger">
<div class="box-header with-border">
<h4 class="box-title">
<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
<i class="fa fa-calendar"></i> Itinerario
</a>
</h4>
</div>
<div id="collapseTwo" class="panel-collapse collapse">
<div class="box-body">
Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
labore sustainable VHS.
</div>
</div>
</div>
<div class="panel box box-danger">
<div class="box-header with-border">
<h4 class="box-title">
<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
<i class="fa fa-money"></i>  Monto Neto
</a>
</h4>
</div>
<div id="collapseThree" class="panel-collapse collapse">
<div class="box-body">
Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
labore sustainable VHS.
</div>
</div>
</div>
<div class="panel box box-danger">
<div class="box-header with-border">
<h4 class="box-title">
<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
<i class="fa fa-percent"></i> Monto con 12 %
</a>
</h4>
</div>
<div id="collapseTwo" class="panel-collapse collapse">
<div class="box-body">
Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
labore sustainable VHS.
</div>
</div>
</div>
<div class="panel box box-danger">
<div class="box-header with-border">
<h4 class="box-title">
<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
<i class="fa fa-percent"></i> 
Monto con 10% y 12$ 
</a>
</h4>
</div>
<div id="collapseTwo" class="panel-collapse collapse">
<div class="box-body">
Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
labore sustainable VHS.
</div>
</div>
</div>
<div class="panel box box-danger">
<div class="box-header with-border">
<h4 class="box-title">
<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
<i class="fa fa-star"></i>

Promociones
</a>
</h4>
</div>
<div id="collapseTwo" class="panel-collapse collapse">
<div class="box-body">
Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
labore sustainable VHS.
</div>
</div>
</div>
</div>
</div>
<!-- /.box-body -->
</div>
<!-- /.box -->
</div>
</div>