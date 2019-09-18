@extends('layouts.master')

@section('titulo', 'Empleados')

@section('css')
<!--  <link href="{!! asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') !!}" rel="stylesheet">-->

@endsection
@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.3/moment.min.js"></script>

<script src={!! asset("admin-lte/bootstrap/js/bootstrap.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/jquery.dataTables.min.js")!!}></script>
<script src={!! asset("admin-lte/plugins/datatables/datatables.bootstrap.js")!!}></script>
<link rel="stylesheet" href="{{ asset("admin-lte/dist/css/style_child.css")}}">

<script type="text/javascript">
    function printDiv(nombreDiv) {
        var contenido= document.getElementById(nombreDiv).innerHTML;
        var contenidoOriginal= document.body.innerHTML;

        document.body.innerHTML = contenido;

        window.print();
        document.body.innerHTML = contenidoOriginal;
        location.reload();
    }
    $(function () {
        $('#listado').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true
        });
    });

    $(document).ready(function(){

        $(".abrirFaltas").click(function(){
            var x=$(this).attr("id");
            $("input[name=inasistencia_id]").val(x);
            $(".modalFaltas").fadeIn();
        });
        $(".cerrarFaltas").click(function(){

            $(".modalFaltas").fadeOut(300);
        });

    });
</script>


@endsection

@section('content')
<div class="box padding_box1">
    <div class="row" style="text-align: right;">
        <div class="col-sm-12"><a target="_blank" href="{{route('manageNomina-contratoPdf-A',$empleado->id)}}" class="btn btn-success">Imprimir Contrato <i class="fa fa-print"></i></a></div>
    </div>
    <div class="row">
        <div class="col-md-12"> 
            <h2>Contrato de Trabajo Temporal por Inicio de Actividad</h2>          
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="3">Conste por el presente documento, el contrato de trabajo de naturaleza temporal por INICIO DE
                            ACTIVIDADES que celebran de conformidad del Articulo 57 del D.S. N° 003-97-TR y el decreto
                            legislativo N° 1086 y su reglamento el DECRETO SUPREMO N° 008-2008 y del Texto Unico
                            Ordenado de la ley del Impulso al desarrollo productivo y al crecimiento Empresarial aprobado por
                            el Decreto Supremo N° 013-2013 – PRODUCE, de una parte QANTU TRAVEL SAC, con RUC N°
                            20551016049, representado por su Gerente General DURAND RAMOS JESUS ANTHONI,
                            identificado con DNI 46008410 y domicilio AV. ALFREDO MENDIOLA N°3621, URB. PANAMERICA
                            NORTE – LIMA – LIMA – LOS OLIVOS, a quien en adelante se le llamara EMPLEADOR.
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td colspan="3"><h3>Datos del Tabajador</h3></td>
                    </tr>
                    <tr class="text-bold bg-danger">
                        <td align="center">NOMBRES</td>
                        <td align="center">APELLIDOS</td>
                        <td align="center">CEDULA</td>
                    </tr>
                    <tr>
                        <td align="center">{{$empleado->nombres}}</td>
                        <td align="center">{{$empleado->apellidos}}</td>
                        <td align="center">{{$empleado->documento}}</td>
                    </tr>
                    <tr class="text-center">
                        <td colspan="3"><h3>Datos de la Cuenta Bancaria</h3></td>
                    </tr>
                    <tr class="text-bold bg-danger">
                        <td colspan="" align="center">NUMERO DE CUENTA</td>
                        <td align="center">BANCO</td>
                        <td align="center">SUELDO</td>
                    </tr>
                    <tr>
                        <td colspan="" align="center">{{$empleado->datoslaborales[0]->numero_cuenta}}</td>
                        <td align="center">{{$empleado->datoslaborales[0]->banco}}</td>
                        <td align="center">{{$empleado->datoslaborales[0]->contrato[0]->sueldo}}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-bold">
                            A
                            quien en adelante se le llamara TRABAJADOR, en los términos y condiciones siguientes:
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-bold">
                            PRIMERO.- EL EMPLEADOR es una persona Jurídica cuyo objeto social es el de dedicarse a
                            prestación de servicios relacionados a una agencia de viajes y guía de turismo y que requiere los
                            servicios del TRABAJADOR en forma temporal.
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-bold">
                            SEGUNDO.- Por el presente contrato el TRABAJADOR se obliga a prestar sus servicios al
                            EMPLEADOR ocupando el cargo de {{$empleado->datoslaborales[0]->cargo}}, debiendo someterse al
                            cumplimiento estricto de la labor para la cual ha sido contratado, bajo las directivas que emanen
                            de EL EMPLEADOR.
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-bold">
                            TERCERO.- El presente contrato es de duración determinada, puesto que se celebra para el
                            incremento de la actividad productiva de la microempresa, y su vigencia se extiende del
                            {{$empleado->datoslaborales[0]->contrato[0]->fecha_inicio}} hasta {{$empleado->datoslaborales[0]->contrato[0]->fecha_fin}} pudiendo prorrogarse el mismo siempre que EL EMPLEADOR
                            conserve las condiciones legales preestablecida para mantenerse dentro del régimen laboral
                            especial de las microempresas. EL TRABAJADOR estará sujeto a un periodo de prueba de tres (03)
                            meses, de conformidad con los establecido en los artículos 10° y 75° de la LPCL.
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-bold">
                            CUARTO.- en contraprestación a los servicios del TRABAJADOR, EL EMPLEADOR se obliga a
                            pagar una remuneración mensual de S/.{{--$contrato[0]->sueldo--}} soles, EL TRABAJADOR tendrá derecho a n
                            mínimo de quince (15) días de descanso vacacional por año de trabajo. Este tiempo podrá ser
                            reducido hasta siete (7) días al año, mediando la respectiva compensación por día laborado, lo
                            cual deberá constar en un acuerdo escrito.
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-bold">
                            QUINTO.- EL TRABAJADOR deberá prestar sus servicios en el horario y la jornada que establezca
                            EL EMPLEADOR, que podrán ser variados de acuerdo con los requerimientos de la empresa.
                            Asimismo, EL EMPLEADOR designara en lugar donde prestara sus servicios EL TRABAJADOR. La
                            trabajadora se obliga también a informar sobre cualquier acto irregular que ocurra durante el
                            desarrollo de sus actividades.
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-bold">
                            SEXTO.- EL EMPLEADOR se obliga a inscribir al TRABAJADOR en el Libro de Planillas, así como a
                            poner en conocimiento de la Autoridad Administrativa de Trabajo el presente contrato, para su
                            aprobación, en cumplimiento de la PLCL.
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-bold">
                            SEPTIMO.- En todo lo no previsto por el presente contrato, se estará a las disposiciones laborales
                            que regulan los contratos de trabajo sujetos a modalidad, contenidas en la LPCL.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection