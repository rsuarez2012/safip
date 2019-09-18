
function cambiar_fecha_grafica(){

    var anio_sel=$("#anio_sel").val();
    var mes_sel=$("#mes_sel").val();
    var anio_mes;
    if(mes_sel >= 1 && mes_sel <= 9) anio_mes = anio_sel+'-0'+mes_sel;
    else anio_mes = anio_sel+'-'+mes_sel;

    cargar_grafica_barras(anio_sel,mes_sel);
    cargar_grafica_lineas(anio_sel,mes_sel);
    preload_data_grafica_ganancias(anio_mes);
}



function cargar_grafica_barras(anio,mes){

var options={
	 chart: {
	 	    renderTo: 'div_grafica_barras',
            type: 'column'
        },
        title: {
            text: 'Numero de Boletos Vendidos'
        },
        subtitle: {
            text: 'SAFIP'
        },
        xAxis: {
            categories: [],
             title: {
                text: 'Dias del mes'
            },
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Cantidad de Boletos'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y} </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 1
            }
        },
        series: [{
            name: 'Boletos',
            data: []

        }]
}

$("#div_grafica_barras").html( $("#cargador_empresa").html() );

var url = "grafica_registros/"+anio+"/"+mes+"";


$.get(url,function(resul){
var datos= jQuery.parseJSON(resul);
var totaldias=datos.totaldias;
var registrosdia=datos.registrosdia;
var i=0;
	for(i=1;i<=totaldias;i++){
	
	options.series[0].data.push( registrosdia[i] );
	options.xAxis.categories.push(i);


	}


 //options.title.text="aqui e podria cambiar el titulo dinamicamente";
 chart = new Highcharts.Chart(options);

})


}



function cargar_grafica_lineas(anio,mes){

var options={
     chart: {
            renderTo: 'div_grafica_lineas',
           
        },
          title: {
            text: 'Numero de Registros en el Mes',
            x: -20 //center
        },
        subtitle: {
            text: 'Source: Plusis.net',
            x: -20
        },
        xAxis: {
            categories: []
        },
        yAxis: {
            title: {
                text: 'REGISTROS POR DIA'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ' registros'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'registros',
            data: []
        }]
}

$("#div_grafica_lineas").html( $("#cargador_empresa").html() );
var url = "grafica_registros/"+anio+"/"+mes+"";
$.get(url,function(resul){
var datos= jQuery.parseJSON(resul);
var totaldias=datos.totaldias;
var registrosdia=datos.registrosdia;
var i=0;
    for(i=1;i<=totaldias;i++){
    
    options.series[0].data.push( registrosdia[i] );
    options.xAxis.categories.push(i);


    }
 //options.title.text="aqui e podria cambiar el titulo dinamicamente";
 chart = new Highcharts.Chart(options);

})


}




function cargar_grafica_pie(){

var options={
     // Build the chart
            chart: {
                renderTo: 'div_grafica_pie',
                plotBackgroundColor: false,
                plotBorderWidth: true,
                plotShadow: true,
                type: 'pie'
            },
            title: {
                text: 'Porcentaje de Ventas Generales por Vendedor'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: []
            }]

}

$("#div_grafica_pie").html( $("#cargador_empresa").html() );

var url = "grafica_publicaciones";


$.get(url,function(resul){
var datos= jQuery.parseJSON(resul);
var tipos=datos.tipos;
var totattipos=datos.totaltipos;
var numeropublicaciones=datos.numerodepubli;

    for(i=0;i<=totattipos-1;i++){  
    var idTP=parseInt(tipos[i].id);
    var objeto= {name: tipos[i].nombres+" "+tipos[i].apellidos, y:numeropublicaciones[idTP] };
    options.series[0].data.push( objeto );
    }
 //options.title.text="aqui e podria cambiar el titulo dinamicamente";
 chart = new Highcharts.Chart(options);

})



}

function preload_data_grafica_ganancias(anio_mes = null){
    let dt = new Date();
    if(anio_mes == null){
        anio_mes = dt.getFullYear()+'-'+(dt.getMonth()+1);
    }
    let url = APP_URL+"/vBoletosP/get/"+anio_mes;
    fetch(url).then(response => response.json()).then(data => {
        console.log(data);
        cargar_grafica_ganancias_perdidas(data)
    }).catch(error => {
        console.log(error);
        console.log(error.response);
    });
}

function cargar_grafica_ganancias_perdidas(data){
    let dt = new Date();
    let fecha_actual = dt.getFullYear()+'-'+dt.getMonth()+'-'+dt.getDate();
    let total_deuda = 0;
    let total_venta_b = 0;

    data.vboletosp.forEach(vbp => {
        total_venta_b += parseFloat(vbp.total);
    });

    if(data.ope_ban.length > 0){
        data.ope_ban.forEach(opb => {
            total_deuda += parseFloat(opb.monto);
        });
    }

    total_venta_b = Math.round((total_venta_b * 100)/100);

        var options = {
        // Build the chart
        chart: {
            renderTo: 'div_grafica_ganancias_perdidas',
            plotBackgroundColor: false,
            plotBorderWidth: true,
            plotShadow: true,
            type: 'pie'
        },
        title: {
            text: 'Porcentaje de Ganancias y Perdidas'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Porcent',
            colorByPoint: true,
            data: []
        }]
    }

    var objeto = [
        {
            name:   'Ganancias',
            y:      total_venta_b,
        },
        {
            name:   'Perdidas',
            y:      total_deuda,
        }
    ];
    options.series[0].data = objeto;
    chart = new Highcharts.Chart(options);
}