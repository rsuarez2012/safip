function cargarlistado(listado,APP_URL){
    //funcion para cargar los diferentes  en general
if(listado==1){ var route = ""+APP_URL+"/tablero/cotizaciones/admin/listar2"; }
$("#contenido_principal").html($("#cargador_empresa").html());
    $.get(route,function(resul){
        $("#contenido_principal").html(resul);
   })
}
function buscarusuario(APP_URL){
    var dato=$("#dato_buscado").val();
    if(dato == "")
    {
       alert("Debe escribir algo en el campo de busqueda");
        var listado = 1;
        if(listado==1){ var route = ""+APP_URL+"/tablero/cotizaciones/admin/listar2"; }
        $("#contenido_principal").html($("#cargador_empresa").html());
        $.get(route,function(resul) {
            $("#contenido_principal").html(resul);
        })
        }else{
        var url= ""+APP_URL+"/tablero/cotizaciones/admin/buscar2/"+dato+"";
        $("#contenido_principal").html($("#cargador_empresa").html());
        $.get(url,function(resul){
            $("#contenido_principal").html(resul);
        })
    }
}
 $(document).on("submit",".form_entrada",function(e){
//funcion para atrapar los formularios y enviar los datos
       e.preventDefault();
     $('html, body').animate({scrollTop: '0px'}, 200);
        var formu=$(this);
        var quien=$(this).attr("id");
        if(quien=="f_nuevo_usuario"){ var varurl="agregar_nuevo_usuario"; var divresul="notificacion_resul_fanu"; }
           $("#"+divresul+"").html($("#cargador_empresa").html());
              $.ajax({
                    type: "POST",
                    url : varurl,
                    datatype:'json',
                    data : formu.serialize(),
                    success : function(resul){
                        $("#"+divresul+"").html(resul);
                        $('#'+quien+'').trigger("reset");
                    }
                });
})
  $(document).on("click",".pagination li a",function(e){
 e.preventDefault();
 var url =$( this).attr("href");
 $("#contenido_principal").html($("#cargador_empresa").html());
    $.get(url,function(resul){
        $("#contenido_principal").html(resul);
   })
  })

