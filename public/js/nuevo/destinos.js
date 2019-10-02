var protocol = $(location).attr('protocol');
var url = $(location).attr('host');
var full_url = protocol + '//' + url;

var destinos = [];  
var destino_id;
var hotel; //agregado
var url; 
var i = 0;
$(document).ready(function(){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  var url = window.location.pathname;
  var pack = $('#paquete_id').val();
  //alert(url + pack);
  //
  $('#dest').select2({
    tags: true
  }); 
  $('#dest').on('change', function(){
    var val_dest = $(this).val();
    console.log(val_dest);
    var separador = "_";
    desti = val_dest.split(separador);
    //alert(product[
    //Aqui debe ir el valor del id del producto que falta
    $('#nombre-destino').val(desti[1]);
    $('#destino_id').val(desti[0]);
  });
  /*$('#destinos-select #edit-dest').click(function(){
    var id = $(this).attr('data-id');
    //var paquete_id = $(this).attr('data-paquete');
    var paquete_id = $('#paquete_id').val();
    //var destino_id = $(this).attr('data-destino');
    var destino_id = $(this).attr('data-dest');
    console.log(destino_id);
    //var dias = $('#'+id).val();
    var dias = $('#count-days').val();

    //alert(texto);
    if(dias ===""){
      toastr.success('Por favor ingrese la cantidad de dias!.');
    }else{
      $.ajax({
          type:'POST',
          data: {
          id: id,
          _token: $('#signup-token').val(),
          dias: dias,
          paquete_id: paquete_id,
          destino_id: destino_id,
        },
        url: '/safip/public/dias/destino/'+id,
        success:function(data){
          console.log(data);
          toastr.success('Dato actualizado con exito!.');
        },
        error:function(data){
          console.log('Error:',data);
        }
      })
    }
  });*/

$('#destinos-select #edit-dest').click(function(){
    var id = $(this).attr('data-id');
    var paquete_id = $(this).attr('data-paquete');
    var destino_id = $(this).attr('data-destino');
    //var dias = $('#'+id).val();
    var dias = $('#count-days').val();

    //alert(texto);
    if(dias ===""){
      toastr.success('Por favor ingrese la cantidad de dias!.');
    }else{
      $.ajax({
          type:'POST',
          data: {
          id: id,
          _token: $('#signup-token').val(),
          dias: dias,
          paquete_id: paquete_id,
          destino_id: destino_id,
        },
        url: '/safip/public/dias/destino/'+id,
        success:function(data){
          console.log(data);
          toastr.success('Dato actualizado con exito!.');
        },
        error:function(data){
          console.log('Error:',data);
        }
      })
    }
  });
  
  $('#destinos-select #delete-dest').click(function(e){

    var id = $(this).attr('data-dele');
    var destino_id = $(this).attr('data-destino');
    var paquete_id = $(this).attr('data-paquete');

    e.preventDefault();
    $.ajax({
      type:'POST',
      url:'/safip/public/Paso/2/Paquete/DestroyDestino/' + id,
      data: { id: id,destino: destino_id, paquete_id: paquete_id },
      success: function(data, msg){
        
        $('.destino_id' + id).remove();
        toastr.success('Destino eliminado con exito!.');

      },
      error:function(data){
        console.log('Error:', data);
      }
    })
  });
  $('#next').click(function(event){
    event.preventDefault();
    var id = $(this).attr('data-id');

      swal({
        title: "Atención!.",
        text: "¿Está seguro de que desea ir a dias.?",
        icon: "warning",
        buttons: {
          cancel: 'No',
          confirm: 'Si'
        },
        closeOnClickOutside: false,
                  closeOnEsc: false,
          dangerMode: true,
          timer: 8000,
      }).then(response => {
          if(response){
            // url = {{route('paquete.edit.paso3',id}}
            window.location.href = "/safip/public/paquete/editar/dias/"+id;
            //window.location.href = this.route + "/tablero/Admin/Paso/3/Itinerario/Paquete/" + this.paquete.id;
          } else {
            return;
          }
      });

  });
  $('#opcion').change(function(){
    var val = $(this).val();
    if(val == 'si'){
      $('#dest-hot').show();
      $('#btn-step2-hoteles').show();

    }else{
      $('#dest-hot').hide();
      $('#btn-step2-hoteles').hide();
      //$('#next').show();
      //$('.selector-hoteles').hide();
    }
  });
  //MULTISELECT DE HOTELES Y DESTINOS
   //$('#destinos-hoteles').multiSelect({ 
   //   selectableOptgroup: true, 
   //   selectableHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Buscar hotel...'>",
   //   selectionHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Buscar hotel...'>",

      /*afterInit: function(ms){
        var that = this,
        $selectableSearch = that.$selectableUl.prev(),
        $selectionSearch = that.$selectionUl.prev(),
        selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
        selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';
        that.qs1 = $selectableSearch.quicksearch(selectableSearchString).on('keydown', function(e){
                        if (e.which === 40){
                          that.$selectableUl.focus();
                          return false;
                        }
                    });
        that.qs2 = $selectionSearch.quicksearch(selectionSearchString).on('keydown', function(e){
                      if (e.which == 40){
                        that.$selectionUl.focus();
                        return false;
                      }
                    });
        },
        afterSelect: function(value){
          var values = value[0].split("_");
          destinos.push({ paquete_id: $('#paquete_id').val(), destino_id: values[0], hotel_id: values[1], noches: $('#noches').val(), value: value });
        
        },
        afterDeselect: function(value){
          destinos.splice(destinos.findIndex(item => item.value === value[0]), 1)
        }*/
    //});
  
  $('#hot-dest').change(function() {
    var id = $(this).val();
    var paquete_id = $('#paquete_id').val();
    destino = [];
    //$('#destinos-hoteles').multiSelect('refresh');
    $.ajax({
      //url:full_url + '/destinosP/'+id,
      url:full_url + '/safip/public/destinosP/'+id,
      type: 'GET',
      data: {destino:id},
      success: function(data){
        if(data.length>0){          
          $("#destinos-hoteles").empty();
          $("#destinos-hoteles").append('<option value="" disabled>Seleccione el Hotel</option>');
              destinos = [];
              $.each(data, function(index, el) {
                $("#destinos-hoteles").append('<optgroup label="">');
                $("#destinos-hoteles").append('<option value='+el.id+"_"+el.destino_id+' data-id='+el.destino_id+'>'+el.nombre+'</option>');  
                destinos.push({paquete_id:paquete_id, destino_id:el.destino_id, hotel_id:el.id, noches: $('#count-days').val()});               

              });
                         

              $('#destinos-hoteles').multiSelect({
                  selectableHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Buscar hotel...'>",
                  selectionHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Buscar hotel...'>",

                  afterInit: function(ms){
                    var that = this,
                    $selectableSearch = that.$selectableUl.prev(),
                    $selectionSearch = that.$selectionUl.prev(),
                    selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                    selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';
                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString).on('keydown', function(e){
                                    if (e.which === 40){
                                      that.$selectableUl.focus();
                                      return false;
                                    }
                                });
                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString).on('keydown', function(e){
                                  if (e.which == 40){
                                    that.$selectionUl.focus();
                                    return false;
                                  }
                                });
                    },

                    afterSelect: function(value){
                      var values = value[0].split("_");                     
                      destino.push({ paquete_id: $('#paquete_id').val(), destino_id: values[1], hotel_id: values[0], noches: $('#noches').val(), value: value });
                    
                    },
                    afterDeselect: function(value){
                      var values = value[0].split("_");                                
                      destino.splice(destinos.findIndex(item => item.value === value[0]), 1)
                    }
                          });       

                    $('#destinos-hoteles').multiSelect('refresh');       

        }else {
            $("#destinos-hoteles").append('<option value="" disabled>No hay hoteles registrados</option>');
          }
        $('.selector-hoteles').show();
      }
      })
        
    });//end ajax
  //end hot-dest
 
  $('#destinos-hoteles > option:selected ').each(
    function(i){
      destinos[i] = $(this).val();
      console.log("Destinos seleccionados "+destinos);
  });

  /*$('#btn-step2-hoteles').on('click', function(e){
      e.preventDefault();
      var frm = $('#destino-form');
      var paquete_id = $('#paquete_id').val();
      var a = $('#destinos-hoteles > option').val();
      var ab = window.location;
      $('#destinos-hoteles > option:selected').each(
        function(i){
          var destin = $('#destinos-hoteles > option:selected').attr('data-id');
          destinos.push({paquete_id:paquete_id, hotel_id:$(this).val(), noches: $('#count-days').val(), destino_id: destin});
          
        });

      console.log(destinos);
      $.ajax({
         // url: full_url + '/safip/public/Paso/2/Enlazar/Hoteles/Paquete/'+destinos[0]['paquete_id'],
          
        url: full_url + '/safip/public/Paso/2/Enlazar/Hoteles/Paquete/'+paquete_id,         
        //url: full_url + '/Paso/2/Enlazar/Hoteles/Paquete/'+paquete_id,         
          type: frm[0].method,
          dataType: 'json',
          data: { destinos: destinos },
          success: function(response){ //
            $('#hoteles-table tbody').remove();
            var hoteles_enlazados = '';
            var p_swb = 0; p_dwb = 0; p_tpl = 0; p_chd = 0;
            var e_swb = 0; e_dwb = 0; e_tpl = 0; e_chd = 0;

            response.enlazados.forEach(function (enlazado) {
                hoteles_enlazados += enlazado.hotel.nombre + ' / ';
                p_swb += parseFloat(enlazado.hotel.p_swb); 
                p_dwb += parseFloat(enlazado.hotel.p_dwb); 
                p_tpl += parseFloat(enlazado.hotel.p_tpl); 
                p_chd += parseFloat(enlazado.hotel.p_chd); 
                e_swb += parseFloat(enlazado.hotel.e_swb); 
                e_dwb += parseFloat(enlazado.hotel.e_dwb); 
                e_tpl += parseFloat(enlazado.hotel.e_tpl); 
                e_chd += parseFloat(enlazado.hotel.e_chd);                 
            });
            $('#hoteles-table').append("<tr><td>" + hoteles_enlazados + "</td><td>HOSTEL</td><td>" + p_swb.toFixed(2) + "</td><td>" + p_dwb.toFixed(2) + "</td><td>" + p_tpl.toFixed(2) + "</td><td>" + p_chd.toFixed(2) + "</td><td>" + e_swb.toFixed(2) + "</td><td>" + e_dwb.toFixed(2) + "</td><td>" + e_tpl.toFixed(2) + "</td><td>" + e_chd.toFixed(2) + "</td><td>&nbsp;</td></tr>");
            location.reload(ab);
            if(response){
            }
        }
      }); 
    });*/


    $('#btn-step2-hoteles').on('click', function(e){
      e.preventDefault();
      var frm = $('#destino-form');
      var paquete_id = $('#paquete_id').val();
      var a = $('#destinos-hoteles > option').val();
    
      $('#destinos-hoteles > option:selected').each(
        function(i){
          //var values = value[0].split("_");
          var destin = $('#destinos-hoteles > option:selected').attr('data-id');
          destinos.push({paquete_id:paquete_id, hotel_id:$(this).val(), noches: $('#count-days').val(), destino_id: destin});
          
        });

      $.ajax({
          url: full_url + '/safip/public/Paso/2/Enlazar/Hoteles/Paquete/'+destinos[0]['paquete_id'],
          //url: full_url + '/Paso/2/Enlazar/Hoteles/Paquete/'+paquete_id,         
          type: frm[0].method,
          dataType: 'json',
          data: { destinos: destino },
          success: function(response){ //}
            
            $('#hoteles-table tbody').remove();
            var hoteles_enlazados = '';
            var p_swb = 0; p_dwb = 0; p_tpl = 0; p_chd = 0;
            var e_swb = 0; e_dwb = 0; e_tpl = 0; e_chd = 0;
            
              response.enlazados.forEach(function (enlazado) {
              
                  hoteles_enlazados += enlazado.hotel.nombre + ' / ';
                  p_swb += parseFloat(enlazado.hotel.p_swb); 
                  p_dwb += parseFloat(enlazado.hotel.p_dwb); 
                  p_tpl += parseFloat(enlazado.hotel.p_tpl); 
                  p_chd += parseFloat(enlazado.hotel.p_chd); 
                  e_swb += parseFloat(enlazado.hotel.e_swb); 
                  e_dwb += parseFloat(enlazado.hotel.e_dwb); 
                  e_tpl += parseFloat(enlazado.hotel.e_tpl); 
                  e_chd += parseFloat(enlazado.hotel.e_chd);                 
              });
              $('#hoteles-table').append("<tr><td>" + hoteles_enlazados + "</td><td>HOSTEL</td><td>" + p_swb.toFixed(2) + "</td><td>" + p_dwb.toFixed(2) + "</td><td>" + p_tpl.toFixed(2) + "</td><td>" + p_chd.toFixed(2) + "</td><td>" + e_swb.toFixed(2) + "</td><td>" + e_dwb.toFixed(2) + "</td><td>" + e_tpl.toFixed(2) + "</td><td>" + e_chd.toFixed(2) + "</td><td><button type=\"button\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Eliminar Enlace\" class=\"btn btn-danger btn-xs\" id=\"quitar_enlace\" data-id=\"{{$paquete->id}}\"><i class=\"fa fa-close\"></i></button></td></tr>");
            
            $('#hoteles-list').show();
        }
      }); 
    });



 $('#quitar_enlace').click(function(codigo_enlace){
    var enlace = $(this).attr('data-id');
    console.log(enlace);
      let text = 'este enlace de hoteles';
      if(codigo_enlace === 'todos') text = 'todos los hoteles enlazados en este paquete';
      swal({
        title: "Atención!.",
        text: "¿Está seguro de que desea eliminar "+text+'?.',
        icon: "warning",
        buttons: {
          cancel: 'No',
          confirm: 'Si'
        },
        dangerMode: true
      }).then(response => {
        if(response){
          let to = 'Este enlace de hoteles está siendo eliminado!.';
          if(codigo_enlace === 'todos') to = 'Todos los hoteles enlazados de este paquete estan siendo eliminados!.';
          //let url = this.route+'/Paso/2/Paquete/DestroyEnlace';
          $.ajax({
            url: full_url + '/safip/public/Paso/2/Paquete/DestroyEnlace',         
          //url: full_url + '/Paso/2/Enlazar/Hoteles/Paquete/'+paquete_id,         
            type: 'POST',
            dataType: 'json',
            data: { enlazado_id: enlace },
            success: function(response){
              $('#hoteles-table tbody').remove();
            var hoteles_enlazados = '';
            var p_swb = 0; p_dwb = 0; p_tpl = 0; p_chd = 0;
            var e_swb = 0; e_dwb = 0; e_tpl = 0; e_chd = 0;

            if(response.enlazados.length > 0) {
              response.enlazados.forEach(function (enlazado) {
                  hoteles_enlazados += enlazado.hotel.nombre + ' / ';
                  p_swb += parseFloat(enlazado.hotel.p_swb); 
                  p_dwb += parseFloat(enlazado.hotel.p_dwb); 
                  p_tpl += parseFloat(enlazado.hotel.p_tpl); 
                  p_chd += parseFloat(enlazado.hotel.p_chd); 
                  e_swb += parseFloat(enlazado.hotel.e_swb); 
                  e_dwb += parseFloat(enlazado.hotel.e_dwb); 
                  e_tpl += parseFloat(enlazado.hotel.e_tpl); 
                  e_chd += parseFloat(enlazado.hotel.e_chd);                 
              });
              $('#hoteles-table').append("<tr><td>" + hoteles_enlazados + "</td><td>HOSTEL</td><td>" + p_swb.toFixed(2) + "</td><td>" + p_dwb.toFixed(2) + "</td><td>" + p_tpl.toFixed(2) + "</td><td>" + p_chd.toFixed(2) + "</td><td>" + e_swb.toFixed(2) + "</td><td>" + e_dwb.toFixed(2) + "</td><td>" + e_tpl.toFixed(2) + "</td><td>" + e_chd.toFixed(2) + "</td><td>&nbsp;</td></tr>");
            } 
          }
        });
          /*this.alert_loader(to, 'loader', false, false);
          //axios.post(url, {codigo: codigo_enlace, paquete:this.paquete.id}).then(response => {
            swal.close();
            //this.enlazados = [];
            this.cargar_paquete();
            this.cargar_destinos();
            this.alert_success('Operación realizada con exito!.', true, true, 4000);
            //console.log(this.$children[0].destacados);
            if(codigo_enlace === 'todos'){
              this.$children[0].destacados = [];
            } else {
              if(this.$children[0].destacados.length > 0){
                this.$children[0].destacados.forEach((dest, index) => {
                  if(dest == codigo_enlace) this.$children[0].destacados.splice(index,1);
                });
              }
            }
          }).catch(error => {
            swal.close();
            console.log(error);
            console.log(error.response);
          });*/
        }
      });
    });







});