
    <div class="col-sm-6">
        <div class="form-group">
            <label>Codigo Paquete</label>
            {{--<input :disabled="package.validated" class="form-control" v-model="package.code" type="text" placeholder="Codigo" id="codigo">--}}
            <input class="form-control" type="text" autocomplete="off" placeholder="Codigo" id="codigo" name="code" value="{{ old('code', $paquete->codigo)}}">
        </div>
        <div class="form-group">
            <label>Nombre Paquete</label>
            <input class="form-control" type="text" autocomplete="off" placeholder="Nombre" id="nombre" name="name" value="{{ old('name', $paquete->nombre) }}">
        </div>

        <div class="form-group">        
            <label>Categoria Paquete</label>
            <select name="category" id="category" class="form-control">
                @foreach($categorias as $categoria)
                <option value="{{$categoria->id}}" {{ $categoria->id == $paquete->categoria_id ? "selected" : "" }}>{{$categoria->nombre}}</option>    
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Zona</label>
            <select class="form-control" name="zone" id="zona">
                <option value="costa" {{ $paquete->zona == 'costa' ? 'selected' : '' }}>Costa</option>
                <option value="sierra" {{ $paquete->zona == 'sierra' ? 'selected' : '' }}>Sierra</option>
                <option value="selva" {{ $paquete->zona == 'selva' ? 'selected' : '' }}>Selva</option>    
            </select>
        </div>
    
        <div class="form-group">
            <label>Imagen Paquete</label>
            <input class="form-control" @change="processFile($event)" type="file" accept="image/*" id="file" name="img">
            <span class="help-block">Las medidas del banner deben ser 700px por 263px</span>
        </div>

        <div class="clearfix"></div>

        <br>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
        
                <center>
                <label>Imagen del paquete</label>
                
                <div id="preview">
                
                </div>
                    {{--<img  :src="route+'/storage/original/'+package.image" alt="Este dia no tiene una imagen">--}}
                    <img src="{{asset('storage/original/'.$paquete->imagen)}}" alt="" width="450" height="200">
                    {{--<img :src="route+'/storage/original/'+package.image" class="img-responsive" width="200px" height="200px" v-if="package.edit">
                    <img :src="'/web/images/paquetes/'+package.image" class="img-responsive" width="720px" height="80px" v-if="package.edit">--}}
                </center>
        </div>
                
                <!--<div class="col-sm-6 form-group hidden">
                    <label>Descripcion Corta</label>
                    <input class="form-control " v-model="package.extrac" type="text" placeholder="extracto">
                </div>
                <div class="col-sm-6 form-group  hidden">
                    <label>Descripcion Larga</label>
                    <textarea class="form-control" v-model="package.description" placeholder="description"></textarea>
                </div>-->
            
                        
    </div>
    <div class="clearfix"></div>
