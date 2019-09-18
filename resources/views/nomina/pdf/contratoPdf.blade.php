<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <title>CONTRATO</title>
</head>
<body>
    <div class="container-fluid">
        <div class="box padding_box1">
            <div class="row">
                <div class="col-md-12"> 
                    <h2>Contrato de Trabajo Temporal por Inicio de Actividad</h2>          
                    <table class="table table-bordered">
                            <tr>
                                <td colspan="4" class="text-bold">Conste por el presente documento, el contrato de trabajo de naturaleza temporal por INICIO DE
                                    ACTIVIDADES que celebran de conformidad del Articulo 57 del D.S. N° 003-97-TR y el decreto
                                    legislativo N° 1086 y su reglamento el DECRETO SUPREMO N° 008-2008 y del Texto Unico
                                    Ordenado de la ley del Impulso al desarrollo productivo y al crecimiento Empresarial aprobado por
                                    el Decreto Supremo N° 013-2013 – PRODUCE, de una parte QANTU TRAVEL SAC, con RUC N°
                                    20551016049, representado por su Gerente General DURAND RAMOS JESUS ANTHONI,
                                    identificado con DNI 46008410 y domicilio AV. ALFREDO MENDIOLA N°3621, URB. PANAMERICA
                                    NORTE – LIMA – LIMA – LOS OLIVOS, a quien en adelante se le llamara EMPLEADOR.
                                </td>
                            </tr>
                        <tbody>
                            <tr class="text-center">
                                <td colspan="4"><h3>Datos del Tabajador</h3></td>
                            </tr>
                            <tr class="text-bold bg-danger">
                                <td>NOMBRES</td>
                                <td>APELLIDOS</td>
                                <td>CEDULA</td>
                                <td>SUELDO</td>
                            </tr>
                            <tr>
                                <td>{{$contrato->nombres}}</td>
                                <td>{{$contrato->apellidos}}</td>
                                <td>{{$contrato->documento}}</td>
                                <td>{{$contrato->datoslaborales[0]->contrato[0]->sueldo}}</td>
                            </tr>
                            <tr class="text-center">
                                <td colspan="4"><h3>Datos de la Cuenta Bancaria</h3></td>
                            </tr>
                            <tr class="text-bold bg-danger">
                                <th scope="col" colspan="2">NUMERO DE CUENTA</th>
                                <th scope="col">BANCO</th>
                                <th scope="col">SUELDO</th>
                            </tr>
                            <tr>
                                <td colspan="2">{{$contrato->datoslaborales[0]->numero_cuenta}}</td>
                                <td>{{$contrato->datoslaborales[0]->banco}}</td>
                                <td>{{$contrato->datoslaborales[0]->contrato[0]->sueldo}}</td>
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
                                    EMPLEADOR ocupando el cargo de {{$contrato->datoslaborales[0]->cargo}}, debiendo someterse al
                                    cumplimiento estricto de la labor para la cual ha sido contratado, bajo las directivas que emanen
                                    de EL EMPLEADOR.
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-bold">
                                    TERCERO.- El presente contrato es de duración determinada, puesto que se celebra para el
                                    incremento de la actividad productiva de la microempresa, y su vigencia se extiende del
                                    {{$contrato->datoslaborales[0]->contrato[0]->fecha_inicio}} hasta {{$contrato->datoslaborales[0]->contrato[0]->fecha_fin}} pudiendo prorrogarse el mismo siempre que EL EMPLEADOR
                                    conserve las condiciones legales preestablecida para mantenerse dentro del régimen laboral
                                    especial de las microempresas. EL TRABAJADOR estará sujeto a un periodo de prueba de tres (03)
                                    meses, de conformidad con los establecido en los artículos 10° y 75° de la LPCL.
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-bold">
                                    CUARTO.- en contraprestación a los servicios del TRABAJADOR, EL EMPLEADOR se obliga a
                                    pagar una remuneración mensual de S/.{{$contrato->datoslaborales[0]->contrato[0]->sueldo}} soles, EL TRABAJADOR tendrá derecho a n
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
            <div class="row" style="margin-bottom:5px;">
                <div class="col-md-12">
                    <h4>Lima, ___________ del ____</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3>&nbsp;&nbsp;&nbsp;Empleador &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Trabajador<br /><br/>----------------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;----------------------------</h3>
                    
                </div>
            </div>
        </div>
    </div>  

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

</body>
</html>