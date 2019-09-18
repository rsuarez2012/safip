<?php

/* 
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware'=>['authen']],function(){

    Route::get('/logout',['as'=>'logout','uses'=>'LoginController@getLogout']);
});

Route::get('users/reset/password/{email}/{password}', 'Auth\ResetPasswordController@restore_password');

Route::group(['middleware'=>['authen','roles'],'roles'=>['1']],function(){
    
    route::get('/mover/imagenes/storage',"Pagina\PaginaPaqueteController@moveImagesStorage");

    Route::get('/debug/paquetes', 'Pagina\PaginaPaqueteController@debug_paquetes');

    Route::get('/tablero',['as'=>'tablero','uses'=>'DashboardController@dashboard']);

    Route::get('/tablero/usuarios/admin',['as'=>'manageUsuario-A','uses'=>'UsuarioController@getManageUsuario']);
    Route::post('/tablero/usuarios/admin/store',['as'=>'manageUsuario-store-A','uses'=>'UsuarioController@store']);
    Route::post('/tablero/usuarios/admin/update/{id}',['as'=>'manageUsuario-update-A','uses'=>'UsuarioController@update']);
    Route::get('/tablero/usuarios/admin/status/{id}',['as'=>'manageUsuario-status-A','uses'=>'UsuarioController@status']);
    Route::get('/tablero/usuarios/admin/edit/{id}',['as'=>'manageUsuario-edit-A','uses'=>'UsuarioController@edit']);
    Route::get('/tablero/usuarios/admin/create',['as'=>'manageUsuario-create-A','uses'=>'UsuarioController@create']);
    Route::get('/tablero/usuarios/admin/destroy/{id}',['as'=>'manageUsuario-destroy-A','uses'=>'UsuarioController@destroy']);


    //muestro la nomina
    Route::get('/tablero/Nomina/admin',['as'=>'manageNomina-A','uses'=>'NominaController@getManageNomina']);

    //vista nuevo empleado
    Route::get('/tablero/Nomina/admin/nuevoEmpleado',['as'=>'manageNomina-nuevo-A','uses'=>'NominaController@nuevo']);
    //Guardo nuevo empleado
    Route::post('/tablero/Nomina/admin/store',['as'=>'manageNomina-store-A','uses'=>'NominaController@postEmpleado1']);
    //Route::post('/tablero/Nomina/admin/store',['as'=>'manageNomina-store-A','uses'=>'NominaController@store']);
    
    //vista nuevo contrato
    Route::get('/tablero/Nomina/admin/nuevoEmpleado1',['as'=>'manageNomina-nuevo-1','uses'=>'NominaController@nuevo1']);
    //guardo nuevo contrato
    Route::post('/tablero/Nomina/admin/store1',['as'=>'manageNomina-store-B','uses'=>'NominaController@postEmpleado3']);

    //vista datos laborables
    Route::get('/tablero/Nomina/admin/nuevoEmpleado2',['as'=>'manageNomina-nuevo-2','uses'=>'NominaController@nuevo2']);
    //guardo datos laborables
    Route::post('/tablero/Nomina/admin/store2',['as'=>'manageNomina-store-C','uses'=>'NominaController@postEmpleado2']);

    //registrar banco en nomina
    Route::post('/tablero/Nomina/admin/bancoN', ['as' => 'bancoN', 'uses' => 'NominaController@storeBanco']);






    Route::get('/tablero/Nomina/admin/EditarEmpleado/{id}',['as'=>'manageNomina-editar-A','uses'=>'NominaController@editar']);
    Route::get('/tablero/Nomina/admin/EliminarEmpleado/{id}',['as'=>'manageNomina-delete-A','uses'=>'NominaController@delete']);
    Route::get('/tablero/Nomina/admin/ContratoEmpleado/{id}',['as'=>'manageNomina-contrato-A','uses'=>'NominaController@contrato']);
    Route::get('/tablero/Nomina/admin/ContratoPdfEmpleado/{id}',['as'=>'manageNomina-contratoPdf-A','uses'=>'NominaController@contratoPdf']);
    Route::get('/tablero/Nomina/admin/Recibo/{id}/{mes}/{anio}',['as'=>'manageNomina-reciboIndividual-A','uses'=>'NominaController@reciboPdf']);
    Route::post('/tablero/Nomina/admin/ReciboPago',['as'=>'manageNomina-GenerarNomina-A','uses'=>'NominaController@GenerarNomina']);
    Route::post('/tablero/Nomina/admin/DatoLaboral',['as'=>'manageNomina-datoLaboral-A','uses'=>'DatoscargadosController@store']);
    
    Route::post('/tablero/Nomina/admin/update',['as'=>'manageNomina-update-A','uses'=>'NominaController@update']);
    Route::post('/tablero/Nomina/admin/inasistencia',['as'=>'manageNomina-inasistencia-A','uses'=>'InasistenciaController@store']);
    Route::post('/tablero/Nomina/admin/adelanto',['as'=>'manageNomina-adelanto-A','uses'=>'AdelantoController@store']);
    Route::post('/tablero/Nomina/admin/Contrato',['as'=>'manageNomina-contratoNuevo-A','uses'=>'NominaController@nuevoContrato']);
    Route::post('/tablero/Nomina/admin/Aporte',['as'=>'manageNomina-Aporte-A','uses'=>'AporteController@store']);
    Route::post('/tablero/Nomina/admin/Aporte/updated',['as'=>'manageNomina-Aporte-Updated-A','uses'=>'AporteController@updated']);
    Route::post('/tablero/Nomina/admin/AporteOtros/updated',['as'=>'manageNomina-AporteOtros-Updated-A','uses'=>'OtrosAportesController@updated']);

    Route::post('/tablero/DatosCargados/admin/store',['as' =>'manageDatoscargados-store-A','uses'=>'DatoscargadosController@store']);

    Route::post('/tablero/Inasistencias/admin/store',['as' =>'manageInasistencia-store-A','uses'=>'InasistenciaController@store']);

    //actual en desarrollo
    Route::get('/tablero/Contabilidad/admin',['as' =>'manageContabilidad-A','uses'=>'ContabilidadController@index']);


    Route::get('/tablero/Contabilidad/admin/FacturaCompra',['as' =>'managefacturaCompra-A','uses'=>'FacturaCController@index']);
    Route::post('/tablero/Contabilidad/admin/FacturaCompra/store',['as'=>'managefacturaCompra-store-A','uses'=>'FacturaCController@guardar']);
    Route::get('/tablero/Contabilidad/admin/FacturaCompra/Modificar/{id}',['as' =>'managefacturaCompra-update-A','uses'=>'FacturaCController@formUpdate']);
    Route::post('/tablero/Contabilidad/admin/FacturaCompra/Modificar',['as' =>'managefacturaCompra-update-save-A','uses'=>'FacturaCController@formSave']);
    Route::get('/tablero/Contabilidad/admin/FacturaCompra/borrar/{id}',['as' =>'managefacturaCompra-delete-A','uses'=>'FacturaCController@delete']);
    Route::post('/tablero/Contabilidad/admin/FacturaCompra/filtrar',['as' => 'manageFacturaCompra-filtrar-A','uses'=>'FacturaCController@filtrar']);

    Route::get('/tablero/Contabilidad/admin/facturaVenta',['as' =>'managefacturaVenta-A','uses'=>'FacturaVController@index']);
    Route::post('/tablero/Contabilidad/admin/store',['as'=>'manageFacturaVenta-store-A','uses'=>'FacturaVController@guardar']);
    Route::get('/tablero/Contabilidad/admin/FacturaVenta/Modificar/{id}',['as' =>'managefacturaVenta-update-A','uses'=>'FacturaVController@formUpdate']);
    Route::post('/tablero/Contabilidad/admin/FacturaVenta/Modificar',['as' =>'managefacturaVenta-update-save-A','uses'=>'FacturaVController@formSave']);
    Route::get('/tablero/Contabilidad/admin/FacturaVenta/borrar/{id}',['as' =>'managefacturaVenta-delete-A','uses'=>'FacturaVController@delete']);
    Route::post('/tablero/Contabilidad/admin/FacturaVenta/filtrar',['as' => 'manageFacturaVenta-filtrar-A','uses'=>'FacturaVController@filtrar']);

    Route::post('/tablero/Contabilidad/GananciaPerdida',['as'=>'manageGananciaPerdida-A','uses'=>'GananciaPerdidaController@index']);
    Route::post('/tablero/Contabilidad/GananciaPerdida/mayorista',['as'=>'manageGananciaPerdida-mayorista-A','uses'=>'GananciaPerdidaController@mayorista']);
    Route::post('/tablero/Contabilidad/GananciaPerdida/taza',['as'=>'manageGananciaPerdida-taza-A','uses'=>'GananciaPerdidaController@taza']);
    Route::get('/tablero/Contabilidad/GananciaPerdida/actual/{mesa}/{anioa}',['as'=>'manageGananciaPerdida-actual-A','uses'=>'GananciaPerdidaController@auxiliar']);
    //-------------------------------

    Route::get('/tablero/empresas/admin',['as'=>'manageEmpresa-A','uses'=>'EmpresaController@getManageEmpresa']);
    Route::post('/tablero/empresas/admin/store',['as'=>'manageEmpresa-store-A','uses'=>'EmpresaController@store']);
    Route::post('/tablero/empresas/admin/update/{id}',['as'=>'manageEmpresa-update-A','uses'=>'EmpresaController@update']);
    Route::get('/tablero/empresas/admin/status/{id}',['as'=>'manageEmpresa-status-A','uses'=>'EmpresaController@status']);
    Route::get('/tablero/empresas/admin/edit/{id}',['as'=>'manageEmpresa-edit-A','uses'=>'EmpresaController@edit']);
    Route::get('/tablero/empresas/admin/create',['as'=>'manageEmpresa-create-A','uses'=>'EmpresaController@create']);
    Route::get('/tablero/empresas/admin/destroy/{id}',['as'=>'manageEmpresa-destroy-A','uses'=>'EmpresaController@destroy']);
    Route::get('/tablero/empresas/admin/show/{id}',['as'=>'manageEmpresa-show-A','uses'=>'EmpresaController@show']);

    Route::get('/tablero/consolidadores/admin',['as'=>'manageConsolidador-A','uses'=>'ConsolidadorController@getManageConsolidador']);
    Route::post('/tablero/consolidadores/admin/store',['as'=>'manageConsolidador-store-A','uses'=>'ConsolidadorController@store']);
    Route::post('/tablero/consolidadores/admin/update/{id}',['as'=>'manageConsolidador-update-A','uses'=>'ConsolidadorController@update']);
    Route::get('/tablero/consolidadores/admin/status/{id}',['as'=>'manageConsolidador-status-A','uses'=>'ConsolidadorController@status']);
    Route::get('/tablero/consolidadores/admin/edit/{id}',['as'=>'manageConsolidador-edit-A','uses'=>'ConsolidadorController@edit']);
    Route::get('/tablero/consolidadores/admin/create',['as'=>'manageConsolidador-create-A','uses'=>'ConsolidadorController@create']);
    Route::get('/tablero/consolidadores/admin/destroy/{id}',['as'=>'manageConsolidador-destroy-A','uses'=>'ConsolidadorController@destroy']);

    Route::get('/tablero/gastos/admin',['as'=>'manageGasto-A','uses'=>'GastoController@getManageGasto']);
    Route::post('/tablero/gastos/admin/store',['as'=>'manageGasto-store-A','uses'=>'GastoController@store']);
    Route::post('/tablero/gastos/admin/update/{id}',['as'=>'manageGasto-update-A','uses'=>'GastoController@update']);
    Route::get('/tablero/gastos/admin/status/{id}',['as'=>'manageGasto-status-A','uses'=>'GastoController@status']);
    Route::get('/tablero/gastos/admin/edit/{id}',['as'=>'manageGasto-edit-A','uses'=>'GastoController@edit']);
    Route::get('/tablero/gastos/admin/create',['as'=>'manageGasto-create-A','uses'=>'GastoController@create']);
    Route::get('/tablero/gastos/admin/destroy/{id}',['as'=>'manageGasto-destroy-A','uses'=>'GastoController@destroy']);

    Route::get('/tablero/deudas/admin',['as'=>'manageDeuda-A','uses'=>'DeudaController@getManageDeuda']);
    Route::post('/tablero/deudas/admin/store',['as'=>'manageDeuda-store-A','uses'=>'DeudaController@store']);
    Route::post('/tablero/deudas/admin/update/{id}',['as'=>'manageDeuda-update-A','uses'=>'DeudaController@update']);
    Route::get('/tablero/deudas/admin/status/{id}',['as'=>'manageDeuda-status-A','uses'=>'DeudaController@status']);
    Route::get('/tablero/deudas/admin/edit/{id}',['as'=>'manageDeuda-edit-A','uses'=>'DeudaController@edit']);
    Route::get('/tablero/deudas/admin/create',['as'=>'manageDeuda-create-A','uses'=>'DeudaController@create']);
    Route::get('/tablero/deudas/admin/destroy/{id}',['as'=>'manageDeuda-destroy-A','uses'=>'DeudaController@destroy']);

    Route::get('/tablero/bancos/admin',['as'=>'manageBanco-A','uses'=>'BancoController@getManageBanco']);
    Route::post('/tablero/bancos/admin/store',['as'=>'manageBanco-store-A','uses'=>'BancoController@store']);
    Route::post('/tablero/bancos/admin/update/{id}',['as'=>'manageBanco-update-A','uses'=>'BancoController@update']);
    Route::get('/tablero/bancos/admin/status/{id}',['as'=>'manageBanco-status-A','uses'=>'BancoController@status']);
    Route::get('/tablero/bancos/admin/edit/{id}',['as'=>'manageBanco-edit-A','uses'=>'BancoController@edit']);
    Route::get('/tablero/bancos/admin/create',['as'=>'manageBanco-create-A','uses'=>'BancoController@create']);
    Route::get('/tablero/bancos/admin/destroy/{id}',['as'=>'manageBanco-destroy-A','uses'=>'BancoController@destroy']);

    Route::any('/tablero/cajas/admin',['as'=>'manageCaja-A','uses'=>'CajaController@getManageCaja']);
    Route::post('/tablero/cajas/admin/store',['as'=>'manageCaja-store-A','uses'=>'CajaController@store']);
    Route::post('/tablero/cajas/admin/update/{id}',['as'=>'manageCaja-update-A','uses'=>'CajaController@update']);
    Route::get('/tablero/cajas/admin/status/{id}',['as'=>'manageCaja-status-A','uses'=>'CajaController@status']);
    Route::get('/tablero/cajas/admin/edit/{id}',['as'=>'manageCaja-edit-A','uses'=>'CajaController@edit']);
    Route::get('/tablero/cajas/admin/create',['as'=>'manageCaja-create-A','uses'=>'CajaController@create']);
    Route::get('/tablero/cajas/admin/destroy/{id}',['as'=>'manageCaja-destroy-A','uses'=>'CajaController@destroy']);
    Route::get('/tablero/cajas/admin/retiro/{id}',['as'=>'manageCaja-retiro-A','uses'=>'CajaController@retiro']);
    Route::post('/tablero/cajas/admin/retiro/save/',['as'=>'manageCaja-retiro-save-A','uses'=>'CajaController@retiro_save']);
    Route::post('/tablero/cajas/admin/fechas',['as'=>'manageCaja-fechas-A','uses'=>'CajaController@fechas']);
    Route::get("/tablero/cajas/admin/eliminar/monto/{gasto}","CajaController@eliminarMonto")->name("eliminar.monto.caja");

    Route::get('/tablero/ivas/admin',['as'=>'manageIva-A','uses'=>'IvaController@getManageIva']);
    Route::post('/tablero/ivas/admin/store',['as'=>'manageIva-store-A','uses'=>'IvaController@store']);
    Route::post('/tablero/ivas/admin/update/{id}',['as'=>'manageIva-update-A','uses'=>'IvaController@update']);
    Route::get('/tablero/ivas/admin/status/{id}',['as'=>'manageIva-status-A','uses'=>'IvaController@status']);
    Route::get('/tablero/ivas/admin/edit/{id}',['as'=>'manageIva-edit-A','uses'=>'IvaController@edit']);
    Route::get('/tablero/ivas/admin/create',['as'=>'manageIva-create-A','uses'=>'IvaController@create']);
    Route::get('/tablero/ivas/admin/destroy/{id}',['as'=>'manageIva-destroy-A','uses'=>'IvaController@destroy']);

    // rutas de agencias de viajes
    Route::get('/tablero/agviajes/admin',['as'=>'manageAviaje-A','uses'=>'AviajeController@getManageAviaje']);
    Route::post('/tablero/agviajes/admin/store',['as'=>'manageAviaje-store-A','uses'=>'AviajeController@store']);
    Route::post('/tablero/agviajes/admin/update/{id}',['as'=>'manageAviaje-update-A','uses'=>'AviajeController@update']);
    Route::get('/tablero/agviajes/admin/status/{id}',['as'=>'manageAviaje-status-A','uses'=>'AviajeController@status']);
    Route::get('/tablero/agviajes/admin/edit/{id}',['as'=>'manageAviaje-edit-A','uses'=>'AviajeController@edit']);
    Route::get('/tablero/agviajes/admin/create',['as'=>'manageAviaje-create-A','uses'=>'AviajeController@create']);
    Route::get('/tablero/agviajes/admin/destroy/{id}',['as'=>'manageAviaje-destroy-A','uses'=>'AviajeController@destroy']);
    // nuevas rutas
    Route::post("/agencias/viajes/cretado/por/counter",
        "AviajeController@createdByCounter");
    Route::get("/agencias/viajes/{agencia}/cambiar/estado/{estado}",
        "AviajeController@cambiarEstado");


    Route::get('/tablero/laereas/admin',['as'=>'manageLaerea-A','uses'=>'LaereaController@getManageLaerea']);
    Route::post('/tablero/laereas/admin/store',['as'=>'manageLaerea-store-A','uses'=>'LaereaController@store']);
    Route::post('/tablero/laereas/admin/update/{id}',['as'=>'manageLaerea-update-A','uses'=>'LaereaController@update']);
    Route::get('/tablero/laereas/admin/status/{id}',['as'=>'manageLaerea-status-A','uses'=>'LaereaController@status']);
    Route::get('/tablero/laereas/admin/edit/{id}',['as'=>'manageLaerea-edit-A','uses'=>'LaereaController@edit']);
    Route::get('/tablero/laereas/admin/create',['as'=>'manageLaerea-create-A','uses'=>'LaereaController@create']);
    Route::get('/tablero/laereas/admin/destroy/{id}',['as'=>'manageLaerea-destroy-A','uses'=>'LaereaController@destroy']);

    Route::get('/tablero/agentes/admin',['as'=>'manageAgente-A','uses'=>'AgenteController@getManageAgente']);
    Route::post('/tablero/agentes/admin/store',['as'=>'manageAgente-store-A','uses'=>'AgenteController@store']);
    Route::post('/tablero/agentes/admin/update/{id}',['as'=>'manageAgente-update-A','uses'=>'AgenteController@update']);
    Route::get('/tablero/agentes/admin/status/{id}',['as'=>'manageAgente-status-A','uses'=>'AgenteController@status']);
    Route::get('/tablero/agentes/admin/edit/{id}',['as'=>'manageAgente-edit-A','uses'=>'AgenteController@edit']);
    Route::get('/tablero/agentes/admin/create',['as'=>'manageAgente-create-A','uses'=>'AgenteController@create']);
    Route::get('/tablero/agentes/admin/destroy/{id}',['as'=>'manageAgente-destroy-A','uses'=>'AgenteController@destroy']);

    Route::post('/tablero/sucursales/admin/store',['as'=>'manageSucursal-store-A','uses'=>'SucursalController@store']);
    Route::get('/tablero/sucursales/admin/destroy/{id}',['as'=>'manageSucursal-destroy-A','uses'=>'SucursalController@destroy']);
    Route::get('/tablero/sucursales/admin/edit/{id}',['as'=>'manageSucursal-edit-A','uses'=>'SucursalController@edit']);
    Route::post('/tablero/sucursales/admin/update/{id}',['as'=>'manageSucursal-update-A','uses'=>'SucursalController@update']);

    Route::get('/tablero/incentivos/admin',['as'=>'manageIncentivo-A','uses'=>'IncentivoController@getManageIncentivo']);
    Route::post('/tablero/incentivos/admin/store',['as'=>'manageIncentivo-store-A','uses'=>'IncentivoController@store']);
    Route::post('/tablero/incentivos/admin/update/{id}',['as'=>'manageIncentivo-update-A','uses'=>'IncentivoController@update']);
    Route::get('/tablero/incentivos/admin/status/{id}',['as'=>'manageIncentivo-status-A','uses'=>'IncentivoController@status']);
    Route::get('/tablero/incentivos/admin/edit/{id}',['as'=>'manageIncentivo-edit-A','uses'=>'IncentivoController@edit']);
    Route::get('/tablero/incentivos/admin/create',['as'=>'manageIncentivo-create-A','uses'=>'IncentivoController@create']);
    Route::get('/tablero/incentivos/admin/destroy/{id}',['as'=>'manageIncentivo-destroy-A','uses'=>'IncentivoController@destroy']);

    Route::get('/tablero/clientes/admin',['as'=>'manageCliente-A','uses'=>'ClienteController@getManageCliente']);
    Route::any('/tablero/clientes/admin/buscar',['as'=>'adminbuscar','uses'=>'ClienteController@buscar']);
    Route::post('/tablero/clientes/admin/store',['as'=>'manageCliente-store-A','uses'=>'ClienteController@store']);
    Route::post('/tablero/clientes/admin/update/{cliente}',['as'=>'manageCliente-update-A','uses'=>'ClienteController@update']);
    Route::get('/tablero/clientes/admin/status/{id}',['as'=>'manageCliente-status-A','uses'=>'ClienteController@status']);
    Route::get('/tablero/clientes/admin/edit/{id}',['as'=>'manageCliente-edit-A','uses'=>'ClienteController@edit']);
    Route::get('/tablero/clientes/admin/create',['as'=>'manageCliente-create-A','uses'=>'ClienteController@create']);
    Route::get('/tablero/clientes/admin/destroy/{id}',['as'=>'manageCliente-destroy-A','uses'=>'ClienteController@destroy']);

    Route::get('/tablero/comisiones/admin',['as'=>'manageComision-A','uses'=>'ComisionController@getManageComision']);
    Route::post('/tablero/comisiones/admin/store',['as'=>'manageComision-store-A','uses'=>'ComisionController@store']);
    Route::post('/tablero/comisiones/admin/update/{id}',['as'=>'manageComision-update-A','uses'=>'ComisionController@update']);
    Route::get('/tablero/comisiones/admin/status/{id}',['as'=>'manageComision-status-A','uses'=>'ComisionController@status']);
    Route::get('/tablero/comisiones/admin/edit/{id}',['as'=>'manageComision-edit-A','uses'=>'ComisionController@edit']);
    Route::get('/tablero/comisiones/admin/create',['as'=>'manageComision-create-A','uses'=>'ComisionController@create']);
    Route::get('/tablero/comisiones/admin/destroy/{id}',['as'=>'manageComision-destroy-A','uses'=>'ComisionController@destroy']);

    Route::get('/tablero/ciudades/admin',['as'=>'manageCiudad-A','uses'=>'CiudadController@getManageCiudad']);
    Route::post('/tablero/ciudades/admin/store',['as'=>'manageCiudad-store-A','uses'=>'CiudadController@store']);
    Route::post('/tablero/ciudades/admin/update/{id}',['as'=>'manageCiudad-update-A','uses'=>'CiudadController@update']);
    Route::get('/tablero/ciudades/admin/status/{id}',['as'=>'manageCiudad-status-A','uses'=>'CiudadController@status']);
    Route::get('/tablero/ciudades/admin/edit/{id}',['as'=>'manageCiudad-edit-A','uses'=>'CiudadController@edit']);
    Route::get('/tablero/ciudades/admin/create',['as'=>'manageCiudad-create-A','uses'=>'CiudadController@create']);
    Route::get('/tablero/ciudades/admin/destroy/{id}',['as'=>'manageCiudad-destroy-A','uses'=>'CiudadController@destroy']);

    Route::get('/tablero/paises/admin',['as'=>'managePais-A','uses'=>'PaisController@getManagePais']);
    Route::post('/tablero/paises/admin/store',['as'=>'managePais-store-A','uses'=>'PaisController@store']);
    Route::post('/tablero/paises/admin/update/{id}',['as'=>'managePais-update-A','uses'=>'PaisController@update']);
    Route::get('/tablero/paises/admin/status/{id}',['as'=>'managePais-status-A','uses'=>'PaisController@status']);
    Route::get('/tablero/paises/admin/edit/{id}',['as'=>'managePais-edit-A','uses'=>'PaisController@edit']);
    Route::get('/tablero/paises/admin/create',['as'=>'managePais-create-A','uses'=>'PaisController@create']);
    Route::get('/tablero/paises/admin/destroy/{id}',['as'=>'managePais-destroy-A','uses'=>'PaisController@destroy']);

    /* Rutas de cotizaciones de boleto */
    Route::get('/tablero/cotizaciones/admin',['as'=>'manageCotizacion-A','uses'=>'CotizacionController@getManageCotizacion']);

    // Nuevas Rutas usando el getInRange
    Route::get('/tablero/cotizaciones/getCountDataFilter/{fecha_d}/{fecha_h}', 'CotizacionController@get_count_data_filter');
    Route::get('/tablero/cotizaciones/boletos/getInRange/{fecha_d}/{fecha_h}', 'CotizacionController@getBoletosInRange');
    
    Route::get('/tablero/cotizaciones/get_paquetes', 'CotizacionController@getC_Paquetes');
    Route::get('/tablero/cotizaciones/get_data_edit_Cpaquete', 'CotizacionController@get_data_edit_Cpaquete');
    Route::post('/tablero/cotizaciones/paquetes/update','CotizacionController@update_Cpaquete');
    Route::post('/tablero/cotizaciones/boletos/update', 'CotizacionController@update_Cboleto');
    Route::post('/tablero/cotizaciones/boletos/update/multi', 'CotizacionController@update_Cboletos_multi');
    Route::get('/tablero/Paquetes/Cotizaciones/destroy/{cotizacion}','Pagina\CotizacionPaqueteController@destroy');

    Route::post('/tablero/cotizaciones/admin/store',['as'=>'manageCotizacion-store-A','uses'=>'CotizacionController@store']);
    Route::get('/tablero/cotizaciones/admin/status/{id}',['as'=>'manageCotizacion-status-A','uses'=>'CotizacionController@status']);
    Route::get('/tablero/cotizaciones/admin/edit/{id}',['as'=>'manageCotizacion-edit-A','uses'=>'CotizacionController@edit']);
    Route::get('/tablero/cotizaciones/admin/create',['as'=>'manageCotizacion-create-A','uses'=>'CotizacionController@create']);
    Route::get('/tablero/cotizaciones/admin/destroy/{id}',['as'=>'manageCotizacion-destroy-A','uses'=>'CotizacionController@destroy']);

    Route::get('/tablero/cotizaciones/admin/anulado/{count}',['as'=>'manageCotizacion-anulate-A','uses'=>'CotizacionController@anulado']);
    Route::get('/tablero/test/total_publicaciones', 'GraficasController@total_publicaciones');

    /* rutas nuevas de procesar cotizacion */
    Route::get('/buscar/comision/{aerolinea}/{consolidador}','CotizacionController@buscarComision');
    Route::get('/validar/codigo/boleto/{codigo}','CotizacionController@validarCodigo');
    Route::get('/buscar/cedula/procesar/cotizacion/{cedula}','CotizacionController@buscarCedula');
    Route::get('/validar/numero/ticket/{numero}','CotizacionController@validarTicket');
    /* -------------------------------- */
    Route::get('/tablero/cotizaciones/admin/procesar/{id}',['as'=>'manageCotizacion-procesar-A','uses'=>'CotizacionController@procesar']);
    Route::get('/tablero/cotizaciones/admin/procesar/store',['as'=>'manageCotizacion-procesar-store-A','uses'=>'CotizacionController@procesarstore']);
    Route::post('/tablero/cotizaciones/admin/getcliente',['as'=>'manageCotizacion-procesar-getcliente-A','uses'=>'CotizacionController@temp']); 
    Route::get('/tablero/cotizaciones/admin/listar',['as'=>'manageListar-list-A','uses'=>'ListarController@listar']);
    Route::get('/tablero/cotizaciones/admin/listar2',['as'=>'manageListar-list2-A','uses'=>'ListarController@listar2']);
    Route::get('/tablero/cotizaciones/admin/listar3',['as'=>'manageListar-list3-A','uses'=>'ListarController@listar3']);
    Route::get('/tablero/cotizaciones/admin/listar4',['as'=>'manageListar-list4-A','uses'=>'ListarController@listar4']);
    Route::get('/tablero/cotizaciones/admin/buscar/{dato}',['as'=>'manageListar-find-A','uses'=>'ListarController@buscar']);
    Route::get('/tablero/cotizaciones/admin/buscar2/{dato}',['as'=>'manageListar-find2-A','uses'=>'ListarController@buscar2']);
    Route::get('/tablero/cotizaciones/admin/buscar3/{dato}',['as'=>'manageListar-find3-A','uses'=>'ListarController@buscar3']);
    Route::get('/tablero/cotizaciones/admin/buscar4/{dato}',['as'=>'manageListar-find4-A','uses'=>'ListarController@buscar4']);
    Route::get('/tablero/cotizaciones/admin/comision/{dato1}/{dato2}',['as'=>'manageListar-comision-A','uses'=>'ListarController@getComision']);
    Route::get('/tablero/cotizaciones/admin/pasajero/{dato1}/{dato2}/{dato3}/{dato4}/{dato5}/{dato6}/{dato7}/{dato8}',['as'=>'manageCrear-pasajero-A','uses'=>'ListarController@storeCliente']);
    Route::get('/tablero/cotizaciones/admin/codigo/{dato}',['as'=>'manageListar-codigo-A','uses'=>'ListarController@getCodigo']);
    Route::get('/tablero/cotizaciones/admin/tikets/{dato}',['as'=>'manageListar-tikets-A','uses'=>'ListarController@getTikets']);


    Route::get('/tablero/ventaboletos/respaldo_admin',['as'=>'respaldo_manageVboleto-A','uses'=>'VboletoController@getManageVboleto']);
    Route::post('/tablero/ventaboletos/admin/fecha',['as'=>'manageVboleto-A-fecha','uses'=>'VboletoController@getManageVboletofecha']);
    Route::post('/tablero/ventaboletos/admin/update/varios', 'VboletoController@update_varios_boletos');
    Route::post('/tablero/ventaboletos/admin/busquedag',['as'=>'manageVboleto-A-busquedag','uses'=>'VboletoController@getManageVboletobusqueda']); //----
    Route::get('/tablero/ventaboletos/admin/anulado/{nro_ticket}',['as'=>'manageVboleto-anulate-A','uses'=>'VboletoController@anulado']);
    Route::post('/tablero/ventaboletos/admin/cf/{id}',['as'=>'manageVboleto-A-cfecha','uses'=>'VboletoController@fecha']);
    Route::post('/tablero/ventaboletos/admin/store',['as'=>'manageVboleto-store-A','uses'=>'VboletoController@store']);
    Route::post('/tablero/ventaboletos/admin/doc_cobranza',['as'=>'manageVboleto-Doc_C-A','uses'=>'VboletoController@doc_cobranza']);
    Route::post('/tablero/ventaboletos/admin/update/',['as'=>'manageVboleto-update-A','uses'=>'VboletoController@update']);
    Route::get('/tablero/ventaboletos/admin/consulta/{h}',['as'=>'manageVboleto-consulta-A','uses'=>'VboletoController@consulta']);
    Route::get('/tablero/ventaboletos/admin/status/{id}',['as'=>'manageVboleto-status-A','uses'=>'VboletoController@status']);
    Route::get('/tablero/ventaboletos/admin/edit/{id}',['as'=>'manageVboleto-edit-A','uses'=>'VboletoController@edit']);
    Route::get('/tablero/ventaboletos/admin/create',['as'=>'manageVboleto-create-A','uses'=>'VboletoController@create']);
    Route::get('/tablero/ventaboletos/admin/destroy/{id}',['as'=>'manageVboleto-destroy-A','uses'=>'VboletoController@destroy']);
    Route::get('/tablero/ventaboletos/admin/pdf/{nro_ticket}',['as'=>'manageVboleto-pdf-A','uses'=>'VboletoController@invoice']);

    // ----------> New Routes Created's by CJ
    Route::get('/tablero/ventaboletos/admin'/*'/tablero/ventaboletos/getIndex'*/, function(){
        return view('vboletos.index');
    })->name('manageVboleto-A');

    // Ruta para cambiar las agencias que estan en 0
    Route::get('/tablero/ventaboletos/changeAgenciesInZero/{fecha_d}/{fecha_h}', 'VboletoController@change_agencies');

    Route::get('/tablero/ventaboletos/getCountDataFilter/{fecha_d}/{fecha_h}', 'VboletoController@get_count_data_filter');
    Route::get('tablero/ventaboletos/getInRange/{fecha_d}/{fecha_h}', 'VboletoController@get_vb_InRange');
    Route::get('/tablero/ventaboletos/getComision/{consolidador}/{laerea}', 'ListarController@getComision');
    Route::get('tablero/ventaboletos/getExcelExport/{fecha_d}/{fecha_h}/{consolidador}/{aviajes}/{laereas}/{vendedor}/{pasajero}/{tpago}/{rango_a}/{rango_b}/{search}',
                'VboletoController@exportarVboletos');

    Route::post('/tablero/ventaboletos/updateVb/{vboletop}', 'VboletoController@updateVboleto');
    Route::post('/tablero/ventaboletos/updateFecha/{vboletop}', 'VboletoController@updateFechaRegistro');
    Route::post('/tablero/ventaboletos/GeneralFilter', 'VboletoController@generalFilter');
    Route::post('/tablero/ventaboletos/updateVarios', 'VboletoController@updateVarios');
    Route::post('/tablero/ventaboletos/anularTicket/{vboletop}', 'VboletoController@anularTicket');
    // ----------> Fin




    Route::get('/tablero/porPagar/admin',['as'=>'managePago-C-A','uses'=>'PagoController@getManagePago']);
    Route::post('/tablero/porPagar/admin/store',['as'=>'managePago-store-A','uses'=>'PagoController@store']);
    Route::post('/tablero/porPagar/admin/storeb',['as'=>'managePago-storeb-A','uses'=>'PagoController@storeb']);
    Route::get('/tablero/porPagar/admin/principal',['as'=>'managePago-principal-A','uses'=>'PagoController@principal']);
    Route::get('/tablero/pagos/getdpagos/{codigo}',['as'=>'managePago-buscar-A','uses'=>'ListarController@getPagos']);


    Route::get('/tablero/porCobrar/admin',['as'=>'manageCobro-C-A','uses'=>'CobroController@getManageCobro']);
    Route::post('/tablero/porCobrar/admin/store',['as'=>'manageCobro-store-A','uses'=>'CobroController@store']);
    Route::post('/tablero/porCobrar/admin/update/{id}',['as'=>'manageCobro-update-A','uses'=>'CobroController@update']);
    Route::get('/tablero/porCobrar/admin/status/{id}',['as'=>'manageCobroController-status-A','uses'=>'CobroController@status']);
    Route::get('/tablero/porCobrar/admin/edit/{id}',['as'=>'manageCobroController-edit-A','uses'=>'CobroController@edit']);
    Route::get('/tablero/porCobrar/admin/create',['as'=>'manageCobroController-create-A','uses'=>'CobroController@create']);
    Route::get('/tablero/porCobrar/admin/destroy/{id}',['as'=>'manageCobroController-destroy-A','uses'=>'CobroController@destroy']);
    Route::get('/tablero/porCobrar/admin/principal',['as'=>'manageCobro-principal-A','uses'=>'CobroController@principal']);
    Route::get('/tablero/porCobrar/getdcobros/{dni_ruc}',['as'=>'manageCobro-buscar-A','uses'=>'ListarController@getCobros']);
    Route::post('/tablero/porCobrar/admin/storeb',['as'=>'manageCobro-storeb-A','uses'=>'CobroController@storeb']);


    Route::get('/tablero/pconsolidadores/admin',['as'=>'managePconsolidador-A','uses'=>'PconsolidadorController@getManagePconsolidador']);
    Route::post('/tablero/pconsolidadores/admin/fecha',['as'=>'managePconsolidador-A-fecha','uses'=>'PconsolidadorController@getManagePconsolidadorfecha']);
    Route::post('/tablero/pconsolidadores/admin/busquedag',['as'=>'managePconsolidador-A-busquedag','uses'=>'PconsolidadorController@getManagePconsolidadorbusqueda']);
    Route::post('/tablero/pconsolidadores/admin/busquedagsm',['as'=>'managePconsolidador-A-busquedagsm','uses'=>'PconsolidadorController@getManagePconsolidadorbusquedasm']);
    Route::get('/tablero/pconsolidadores/admin/sm',['as'=>'managePconsolidadorsm-A','uses'=>'PconsolidadorController@getManagePconsolidadorsm']);
    Route::post('/tablero/pconsolidadores/admin/sm/fecha',['as'=>'managePconsolidadorsm-A-fecha','uses'=>'PconsolidadorController@getManagePconsolidadorsmfecha']);
    Route::post('/tablero/pconsolidadores/admin/store',['as'=>'managePconsolidador-store-A','uses'=>'PconsolidadorController@store']);
    Route::post('/tablero/pconsolidadores/admin/storeb',['as'=>'managePagoC-storeb-A','uses'=>'PconsolidadorController@storeb']);
    Route::post('/tablero/pconsolidadores/admin/storebsm',['as'=>'managePagoC-storebsm-A','uses'=>'PconsolidadorController@storebsm']);
    Route::post('/tablero/pconsolidadores/admin/update/{id}',['as'=>'managePconsolidador-update-A','uses'=>'PconsolidadorController@update']);
    Route::get('/tablero/pconsolidadores/admin/status/{id}',['as'=>'managePconsolidador-status-A','uses'=>'PconsolidadorController@status']);
    Route::get('/tablero/pconsolidadores/admin/edit/{id}',['as'=>'managePconsolidador-edit-A','uses'=>'PconsolidadorController@edit']);
    Route::get('/tablero/pconsolidadores/admin/create',['as'=>'managePconsolidador-create-A','uses'=>'PconsolidadorController@create']);
    Route::get('/tablero/pconsolidadores/admin/destroy/{id}',['as'=>'managePconsolidador-destroy-A','uses'=>'VboletoController@destroy']);
    Route::get('/tablero/pconsolidadores/getdpagos/{codigo}/{ticket}',['as'=>'managePagoC-buscar-A','uses'=>'ListarController@getPagosC']);
    Route::post('/tablero/pconsolidadores/admin/busquedagif',['as'=>'managePconsolidador-A-busquedagif','uses'=>'PconsolidadorController@getManagePconsolidadorbusquedaif']);
    Route::get('/tablero/pconsolidadores/admin/if',['as'=>'managePconsolidadorif-A','uses'=>'PconsolidadorController@getManagePconsolidadorif']);
    Route::post('/tablero/pconsolidadores/admin/if/fecha',['as'=>'managePconsolidadorif-A-fecha','uses'=>'PconsolidadorController@getManagePconsolidadoriffecha']);
    Route::post('/tablero/pconsolidadores/admin/storepm',['as'=>'managePconsolidador-storepm-A','uses'=>'PconsolidadorController@storepm']);

    Route::get('/tablero/dagenciaviajes/admin',['as'=>'manageDagenciaviajes-A','uses'=>'DagenciaviajesController@getManageDagenciaviajes']);
    Route::post('/tablero/dagenciaviajes/admin/fecha',['as'=>'manageDagenciaviajes-A-fecha','uses'=>'DagenciaviajesController@getManageDagenciaviajesfecha']);
    Route::get('/tablero/dagenciaviajes/admin/sm',['as'=>'manageDagenciaviajessm-A','uses'=>'DagenciaviajesController@getManageDagenciaviajessm']);
    Route::post('/tablero/dagenciaviajes/admin/sm/fecha',['as'=>'manageDagenciaviajessm-A-fecha','uses'=>'DagenciaviajesController@getManageDagenciaviajessmfecha']);
    Route::post('/tablero/dagenciaviajes/admin/busquedag',['as'=>'manageDagenciaviajes-A-busquedag','uses'=>'DagenciaviajesController@getManageDagenciaviajesbusqueda']);
    Route::post('/tablero/dagenciaviajes/admin/busquedagsm',['as'=>'manageDagenciaviajes-A-busquedagsm','uses'=>'DagenciaviajesController@getManageDagenciaviajesbusquedasm']);
    Route::post('/tablero/dagenciaviajes/admin/store',['as'=>'manageDagenciaviajes-store-A','uses'=>'DagenciaviajesController@store']);
    Route::post('/tablero/dagenciaviajes/admin/storeb',['as'=>'manageDagenciaviajes-storeb-A','uses'=>'DagenciaviajesController@storeb']);
    Route::post('/tablero/dagenciaviajes/admin/storebsm',['as'=>'manageDagenciaviajes-storebsm-A','uses'=>'DagenciaviajesController@storebsm']);
    Route::post('/tablero/dagenciaviajes/admin/update/{id}',['as'=>'manageDagenciaviajes-update-A','uses'=>'DagenciaviajesController@update']);
    Route::get('/tablero/dagenciaviajes/admin/status/{id}',['as'=>'manageDagenciaviajes-status-A','uses'=>'DagenciaviajesController@status']);
    Route::get('/tablero/dagenciaviajes/admin/edit/{id}',['as'=>'manageDagenciaviajes-edit-A','uses'=>'DagenciaviajesController@edit']);
    Route::get('/tablero/dagenciaviajes/admin/create',['as'=>'manageDagenciaviajes-create-A','uses'=>'DagenciaviajesController@create']);
    Route::get('/tablero/dagenciaviajes/admin/destroy/{id}',['as'=>'manageDagenciaviajes-destroy-A','uses'=>'DagenciaviajesController@destroy']);
    Route::get('/tablero/dagenciaviajes/getdcobros/{codigo}/{ticket}',['as'=>'manageCobroA-buscar-A','uses'=>'ListarController@getCobrosA']);
    Route::get('/tablero/dagenciaviajes/getdeuda/{codigo}/{ticket}',['as'=>'manageDeuda-buscar-A','uses'=>'ListarController@getDeudasA']);
    Route::get('/tablero/dagenciaviajes/getconso/{consolidadores_id}',['as'=>'manageConso-buscar-A','uses'=>'ListarController@getConsoA']);

    Route::get('/tablero/coperacionesbancarias/admin',['as'=>'manageCoperacionesbancarias-A','uses'=>'CoperacionesbancariasController@getManageCoperacionesbancarias']);
    Route::post('/tablero/coperacionesbancarias/admin/fecha',['as'=>'manageCoperacionesbancarias-A-fecha','uses'=>'CoperacionesbancariasController@getManageCoperacionesbancariasfecha']);
    Route::post('/tablero/coperacionesbancarias/admin/busquedag',['as'=>'manageCoperacionesbancarias-A-busquedag','uses'=>'CoperacionesbancariasController@getManageCoperacionesbancariasbusqueda']);
    Route::post('/tablero/coperacionesbancarias/admin/store',['as'=>'manageCoperacionesbancarias-store-A','uses'=>'CoperacionesbancariasController@store']);
    Route::post('/tablero/coperacionesbancarias/admin/store/index',['as'=>'manageCoperacionesbancarias-storeindex-A','uses'=>'CoperacionesbancariasController@storeindex']);
    Route::post('/tablero/coperacionesbancarias/admin/update/{id}',['as'=>'manageCoperacionesbancarias-update-A','uses'=>'CoperacionesbancariasController@update']);
    Route::get('/tablero/coperacionesbancarias/admin/status/{id}',['as'=>'manageCoperacionesbancarias-status-A','uses'=>'CoperacionesbancariasController@status']);
    Route::get('/tablero/coperacionesbancarias/admin/edit/{id}',['as'=>'manageCoperacionesbancarias-edit-A','uses'=>'CoperacionesbancariasController@edit']);
    Route::get('/tablero/coperacionesbancarias/admin/create',['as'=>'manageCoperacionesbancarias-create-A','uses'=>'CoperacionesbancariasController@create']);
    Route::get('/tablero/coperacionesbancarias/admin/destroy/{id}',['as'=>'manageCoperacionesbancarias-destroy-A','uses'=>'CoperacionesbancariasController@destroy']);
    Route::post('/tablero/coperacionesbancarias/admin/import',['as'=>'manageCoperacionesbancarias-import-A','uses'=>'CoperacionesbancariasController@importExcel']);
    Route::get('/tablero/coperacionesbancarias/admin/operaciones',['as'=>'manageCoperacionesbancarias-mostrar-A','uses'=>'CoperacionesbancariasController@mostrar']);
    Route::post('/tablero/coperacionesbancarias/admin/ttbsm',['as'=>'manageCoperacionesbancarias-ttbsm-A','uses'=>'CoperacionesbancariasController@consultabancos']);
    Route::get('/tablero/coperacionesbancarias/admin/ttbsmi',['as'=>'manageCoperacionesbancarias-ttbsmi-A','uses'=>'CoperacionesbancariasController@consultabancosi']);
    /*Route::get('/tablero/admin/facturacion',['as'=>'manageFacturacion-A','uses'=>'ReservacionController@getManageReservacion']);*/

    /* RUTAS PARA OPERACIONES BANCARIAS - CESSARE JULIUS */
    Route::get('/tablero/opebanks/admin', function(){
        return view('opebanks.index');
    })->name('opebanks.index');
    Route::get('tablero/opebanks/load/data/{fecha_d}/{fecha_h}', 'CoperacionesbancariasController@load_data_ope');
    Route::get('tablero/opebanks/load/data/deudas/fechas/{fecha_d}/{fecha_h}/monto/{monto}',
                'CoperacionesbancariasController@load_data_deudas_fechas');
    Route::get('tablero/opebanks/load/data/deudas/agencia/{nro_ope}/monto/{monto}',
                'CoperacionesbancariasController@load_data_deudas_agencia');
    Route::post('tablero/opebanks/importExcel', 'CoperacionesbancariasController@processExcel')->name('process.excel');
    Route::post('tablero/opebanks/save/process/excel', 'CoperacionesbancariasController@save_process_excel');
    Route::post('tablero/opebanks/register/payments/deudas', 'CoperacionesbancariasController@register_payments_deudas');
    Route::post('tablero/opebanks/register/gasto', 'CoperacionesbancariasController@register_gastos');

    Route::get('tablero/opebanks/load/data/deudas/pagos/conso/{nro_ope}/monto/{monto}',
                'CoperacionesbancariasController@load_data_deudas_pagos_conso');
    Route::get('tablero/opebanks/load/data/deudas/pagos/conso/fechas/{fecha_d}/{fecha_h}/monto/{monto}',
                'CoperacionesbancariasController@load_data_deudas_pagos_conso_fechas');

    Route::post('/tablero/opebanks/destroy', 'CoperacionesbancariasController@delete_ope_bank');

    /* FIN RUTAS PARA OPERACIONES BANCARIAS */


    Route::get('/tablero/operadores/admin',['as'=>'manageOperador-A','uses'=>'OperadorController@getManageOperador']);
    Route::post('/tablero/operadores/admin/store',['as'=>'manageOperador-store-A','uses'=>'OperadorController@store']);
    Route::post('/tablero/operadores/admin/update/{id}',['as'=>'manageOperador-update-A','uses'=>'OperadorController@update']);
    Route::get('/tablero/operadores/admin/deleteOperador/{operador}', 'OperadorController@deleteOperador')->name('delete.operador');
    Route::get('/tablero/operadores/admin/status/{id}',['as'=>'manageOperador-status-A','uses'=>'OperadorController@status']);
    Route::get('/tablero/operadores/admin/edit/{id}',['as'=>'manageOperador-edit-A','uses'=>'OperadorController@edit']);
    Route::get('/tablero/operadores/admin/create',['as'=>'manageOperador-create-A','uses'=>'OperadorController@create']);
    /*Route::get('/tablero/operadores/admin/destroy/{id}',['as'=>'manageOperador-destroy-A','uses'=>'OperadorController@destroy']);*/
    Route::get('/tablero/operadores/servicios/admin',['as'=>'manageOperador-servicios-A','uses'=>'OperadorController@servicios']);
    Route::get('/tablero/operadores/servicios/admin/servicios/{id}',['as'=>'manageOperador-servicios-A','uses'=>'OperadorController@servicios']);
    Route::get('/tablero/operadores/servicios/admin/servicios/borrar/{id}/{operador}',['as'=>'manageServicios-destroy-A','uses'=>'OperadorController@serviciosDestroy']);
    Route::post('/tablero/operadores/servicios/admin/servicios/crear',['as'=>'manageServicios-store-A','uses'=>'OperadorController@serviciosStore']);
    Route::post('/tablero/operadores/servicios/admin/servicios/actualizar',['as'=>'manageServicios-updated-A','uses'=>'OperadorController@serviciosUpdated']);

    Route::post('/tablero/correo',['as'=>'manageCorreo-envio-A','uses'=>'CorreoController@correo']);
    Route::post('/tablero/correo/av',['as'=>'manageCorreo-envioAv-A','uses'=>'CorreoController@correoAv']);
    Route::post('/tablero/correo/op',['as'=>'manageCorreo-envioOp-A','uses'=>'CorreoController@correoOp']);

    Route::get('/generador/admin',['as'=>'manageGenerador-A','uses'=>'GeneradorController@create']);
    Route::post('/generador/admin/store',['as'=>'manageGenerador-store-A','uses'=>'GeneradorController@update1']);


    Route::get('listado_graficas', 'GraficasController@index');
    Route::get('grafica_registros/{anio}/{mes}', 'GraficasController@registros_mes');
    Route::get('grafica_publicaciones', 'GraficasController@total_publicaciones');

    // RUTAS PARA INDEX CREADAS POR CESSARE
    Route::get('vBoletosP/get/{anio_mes}', 'GraficasController@getvBoletosP');
    // FIN RUTAS INDEX

    Route::get('/tablero/e-shop/usuarios/admin',['as'=>'manageUser-A','uses'=>'Eshop\UsersController@index']);

    Route::post('/tablero/e-shop/usuarios/admin/store',['as'=>'manageUser-store-A','uses'=>'Eshop\UsersController@store']);

    Route::post('/tablero/e-shop/usuarios/admin/update/{id}',['as'=>'manageUser-update-A','uses'=>'Eshop\UsersController@update']);

    Route::get('/tablero/e-shop/usuarios/admin/status/{id}',['as'=>'manageUser-status-A','uses'=>'Eshop\UsersController@status']);


    Route::get('/tablero/e-shop/usuarios/admin/edit/{id}',['as'=>'manageUser-edit-A','uses'=>'Eshop\UsersController@edit']);
    Route::get('/tablero/e-shop/usuarios/admin/create',['as'=>'manageUser-create-A','uses'=>'Eshop\UsersController@create']);

    // -----------------------------------------> PAQUETES FULL DAY <---------------------------------------------------------------------//
    Route::get('/tablero/Paquete/Full_Day/index', 'Pagina\PaginaPaqueteFullDayController@index')->name('full_day.index');
    Route::get('/tablero/Paquete/Full_Day/create', 'Pagina\PaginaPaqueteFullDayController@create')->name('full_day.new_paquete');
    Route::get('/tablero/Paquete/Full_Day/edit/{paquete}', 'Pagina\PaginaPaqueteFullDayController@edit')->name('full_day.edit_paquete');

    Route::get('/tablero/Paquete/Full_Day/load_paquete/{paquete}', 'Pagina\PaginaPaqueteFullDayController@load_paquete');
    Route::get('/tablero/Paquete/Full_Day/mis_destinos/{paquete}', 'Pagina\PaginaPaqueteFullDayController@load_mis_destinos');

    Route::post('/tablero/Paquete/Full_Day/store_basic_data', 'Pagina\PaginaPaqueteFullDayController@store_basic_data');
    Route::post('/tablero/Paquete/Full_Day/update_basic_data/{paquete}', 'Pagina\PaginaPaqueteFullDayController@update_basic_data');

    Route::post('/tablero/Paquete/Full_Day/store_destino/{paquete}', 'Pagina\PaginaPaqueteFullDayController@store_destino');
    Route::post('/tablero/Paquete/Full_Day/destroy_destino/{paquete}', 'Pagina\PaginaPaqueteFullDayController@delete_destino');

    Route::post('/tablero/Paquete/Full_Day/save_dia', 'Pagina\PaginaPaqueteFullDayController@save_dia');
    Route::post('/tablero/Paquete/Full_Day/update_dia/{dia}', 'Pagina\PaginaPaqueteFullDayController@update_dia');
    Route::delete('/tablero/Paquete/Full_Day/destroy/{dia}', 'Pagina\PaginaPaqueteFullDayController@delete_dia');

    Route::post('/tablero/Paquete/Full_Day/save_new_percent/{paquete}', 'Pagina\PaginaPaqueteFullDayController@save_new_percent');

    Route::delete('/tablero/Paquete/Full_Day/Destroy/{paquete}', 'Pagina\PaginaPaqueteFullDayController@delete_paquete')->name('full_day.delete_paquete');

    Route::post('tablero/Paquete/Full_Day/change/state/paquete/{paquete}', 'Pagina\PaginaPaqueteFullDayController@change_state');

    // -----------------------------------------> FIN PAQUETES FULL DAY <---------------------------------------------------------------------//
    // PAQUETES
    Route::get('/tablero/e-shop/usuarios/admin/destroy/{id}',['as'=>'manageUser-destroy-A','uses'=>'Eshop\UsersController@destroy']);
    Route::get('/tablero/Paquetes/Admin/Index',['as'=>'manageProduct-A','uses'=>'Pagina\PaginaPaqueteController@index']);
    Route::get('/tablero/Paquetes/Admin/Continuar/{paquete}/{statusCreado}', function($paquete, $statusCreado) {
        if($statusCreado === '2'):
            return redirect()->route('managePaquete-paso-2-A', $paquete);
        elseif($statusCreado === '3'):
            return redirect()->route('managePaquete-paso-3-A', $paquete);
        elseif($statusCreado === '4'):
            return redirect()->route('managePaquete-paso-4-A', $paquete);
        else:
            return back();
        endif;
    })->name('continuar.paquete');
    Route::get('/tablero/Paquetes/Admin/Finalizar/{paquete}',['as'=>'managePaquete-Finalizar-A','uses'=>'Pagina\PaginaPaqueteController@finalizar']);

    Route::get('/tablero/Paquetes/Admin/Cambiar/Estado/{paquete}/{valor}',['as'=>'managePaquete-CambiarEstado-A','uses'=>'Pagina\PaginaPaqueteController@estado']);

    // PASO 1
    Route::get('/tablero/Paquetes/Admin/Paso/1/Datos/Paquetes',
            'Pagina\PaginaPaquetePaso1Controller@create')->name('manageProduct-paso-1-A');

    Route::post('/tablero/Paquete/Admin/Paso/1/Store',
                'Pagina\PaginaPaquetePaso1Controller@store');

    Route::get('/tablero/Paquetes/Admin/Paso/1/Datos/Paquetes/edit/{paquete}',
            'Pagina\PaginaPaquetePaso1Controller@edit')->name('paquete.edit.paso1');

    Route::post('/tablero/Paquete/Admin/Paso/1/Update/{paquete}',
                        'Pagina\PaginaPaquetePaso1Controller@update')
                   ->name('paquete.update.paso1');

    Route::delete('/tablero/Paquete/Admin/Destroy/{paquete}',
                    'Pagina\PaginaPaqueteController@delete')->name('paquetes.delete');

    Route::post('/tablero/Paquete/Admin/Paso/1/Clonar/Paquete', 'Pagina\PaginaPaqueteController@clonar_paquete')->name('clonar.paquete');

    Route::get('/paso1/get/package/{id}',
                'Pagina\PaginaPaquetePaso1Controller@getPackage');

    Route::get('/get/categories/packages',
                "Pagina\PaginaPaquetePaso1Controller@getCategories");

    Route::get('/validate/code/{code}',
                'Pagina\PaginaPaquetePaso1Controller@verCodigo');

    Route::post('/save/departure/{package_id}',
                'Pagina\PaginaPaquetePaso1Controller@saveDeparture');

    Route::put('/delete/departure/{package_id}',
                'Pagina\PaginaPaquetePaso1Controller@destroyDeparture');
    // PASO 2
    /* RUTAS PARA VUEJS */
    Route::get('/Paso/2/load/paquete/{paquete}', 'Pagina\PaginaPaquetePaso2Controller@load_paquete');
    Route::post('/Paso/2/load/destinos', 'Pagina\PaginaPaquetePaso2Controller@load_destinos');
    Route::post('/Paso/2/Paquete/{paquete}/Agregar/Destino', 'Pagina\PaginaPaquetePaso2Controller@agregarDestino');
    Route::post('/Paso/2/Paquete/DestroyDestino', 'Pagina\PaginaPaquetePaso2Controller@destroyDestino');
    Route::post('/Paso/2/Enlazar/Hoteles/Paquete/{paquete}', 'Pagina\PaginaPaquetePaso2Controller@enlazar');
    Route::post('/Paso/2/Paquete/DestroyEnlace', 'Pagina\PaginaPaquetePaso2Controller@eliminarEnlace');
    Route::post('/Paso/2/Destacar/Hoteles/Ind', 'Pagina\PaginaPaquetePaso2Controller@destacar_ind');
    Route::post('/Paso/2/Destacar/5/Hoteles/Paquete/{paquete}', 'Pagina\PaginaPaquetePaso2Controller@destacar_varios');

    Route::get('/tablero/Admin/Paso/2/Paquete/{paquete}',
            ['as'=>'managePaquete-paso-2-A','uses'=>'Pagina\PaginaPaquetePaso2Controller@create']);

    Route::get('/tablero/Admin/Paso/2/Paquete/{paquete}/edit',
               'Pagina\PaginaPaquetePaso2Controller@edit')
            ->name('paquete.edit.paso2');

    Route::get('/tablero/Admin/Paso/2/Paquete/Cambiar/Estado/{codigo}',
            ['as'=>'managePaquete-paso-2-estado','uses' => 'Pagina\PaginaPaquetePaso2Controller@estado']);

    Route::post('/tablero/Admin/Paso/2/Paquete/Eliminar/Enlace/',
            'Pagina\PaginaPaquetePaso2Controller@eliminarEnlace')
            ->name('eliminar.enlace');

    // PASO 3
    /* vue paso 3 */
    Route::get('/get/package/{id}',
               'Pagina\PaginaPaquetePaso3Controller@getPackage');

    Route::get('/delete/day/{dia}',
               'Pagina\PaginaPaquetePaso3Controller@eliminarDia');

    Route::post('/save/day/{paquete_id}',
               'Pagina\PaginaPaquetePaso3Controller@agregarDia');

    Route::post('/updated/day/{paquete_id}',
               'Pagina\PaginaPaquetePaso3Controller@updatedDia');

    Route::get('/tablero/Admin/Paso/3/Restaurants/Paquete/{id}',
               'Pagina\PaginaPaquetePaso3Controller@tool_restaurants');

    Route::get('/tablero/Admin/Paso/3/Mis_Services/Paquete/{id}',
               'Pagina\PaginaPaquetePaso3Controller@tool_services');

    Route::get('/tablero/Admin/Paso/3/Others_Destinos/Paquete/{id}',
               'Pagina\PaginaPaquetePaso3Controller@tool_others_destinos'); // ESTA RUTA ESTA REPETIDA

    Route::post('/tablero/Admin/Paso/3/Other_Services',
               'Pagina\PaginaPaquetePaso3Controller@tool_other_services'); // ESTA RUTA ESTA REPETIDA

    Route::post('/save/activity/day/{day}',
               'Pagina\PaginaPaquetePaso3Controller@agregarActividad');

    Route::get('/get/neto/package/{paquete}',
               'Pagina\PaginaPaquetePaso3Controller@tool_neto');

    Route::get('/get/other/destinies/{paquete}',
               'Pagina\PaginaPaquetePaso3Controller@tool_others_destinos');

    Route::get('/delete/activity/{actividad}',
               'Pagina\PaginaPaquetePaso3Controller@tool_others_destinos'); // ESTA RUTA ESTA REPETIDA

    Route::post('/get/other/services',
               'Pagina\PaginaPaquetePaso3Controller@tool_other_services');

    Route::post('/get/other/restaurants',
               'Pagina\PaginaPaquetePaso3Controller@tool_other_restaurants');

    Route::get('/tablero/Admin/Paso/3/borrar/{actividad}',
                'Pagina\PaginaPaquetePaso3Controller@eliminarActividad');

    Route::get('/change/state/hotels/{code}/to/{status}',
                'Pagina\PaginaPaquetePaso3Controller@changeStateHotels');

    Route::get('/change/type/tarifa/{package_id}/to/{type}/ppm/{ppm}',
                'Pagina\PaginaPaqueteController@changeTypeTarifa');

    Route::get('/tablero/Admin/Paso/3/Itinerario/Paquete/{id}',['as'=>'managePaquete-paso-3-A','uses'=>'Pagina\PaginaPaquetePaso3Controller@index']);

    Route::get('/tablero/Admin/Paso/3/Itinerario/Paquete/{id}/edit',
               'Pagina\PaginaPaquetePaso3Controller@edit')
         ->name('paquete.edit.paso3');

    Route::post('/tablero/Admin/Paso/3/Agregar/Dia/{paquete_id}',['as'=>'managePaquete-paso-3-agregar-dia','uses'=>'Pagina\PaginaPaquetePaso3Controller@agregarDia']);

    Route::post('/tablero/Admin/Paso/3/Agregar/Actividad/{dia}',['as'=>'managePaquete-paso-3-agregar-actividad','uses'=>'Pagina\PaginaPaquetePaso3Controller@agregarActividad']);

    
    Route::get('/tablero/Admin/Paso/3/Itinerario/eliminar/{dia}', 'Pagina\PaginaPaquetePaso3Controller@eliminarDia')->name('eliminar.itinerario');

    Route::get('/change/utility/{utility}/package/{package}',
                'Pagina\PaginaPaquetePaso3Controller@changeUtility');
    // PROBANDO EL ARTISAN
    Route::get('/view/clear', function () {
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        return back();
    })->name('view.clear');
    // FIN DE PROBANDO
    // PASO 4
    Route::get('/tablero/Admin/Paso/4/Datos/Adicionales/Paquete/{paquete}', 'Pagina\PaginaPaquetePaso4Controller@index')->name('managePaquete-paso-4-A');

    Route::get('/tablero/Admin/Paso/4/Datos/Adicionales/Paquete/{paquete}/edit',
               'Pagina\PaginaPaquetePaso4Controller@edit')
         ->name('paquete.edit.paso4');
    
    Route::get('/tablero/Admin/Paso/4/cargar/data/base/{paquete}', 'Pagina\PaginaPaquetePaso4Controller@cargar_data_base');

    Route::post('/tablero/Admin/Paso/4/Agregar/Dato/{paquete_id}', 'Pagina\PaginaPaquetePaso4Controller@agregarDato')->name('r-data-add');

    Route::get('/tablero/Admin/Paso/4/agregar/datos/{tipo}/paquete/{paquete}/paquete_act/{paquete_act}', 'Pagina\PaginaPaquetePaso4Controller@agregar_datos_paquete');

    Route::post('/tablero/Admin/Paso/4/Editar/Dato/{dato}', 'Pagina\PaginaPaquetePaso4Controller@editarDato');

    Route::delete('/tablero/Admin/Paso/4/Eliminar/Dato/{dato}', 'Pagina\PaginaPaquetePaso4Controller@eliminarDato');

    Route::post('/tablero/Admin/Paso/4/cargar/datos', 'Pagina\PaginaPaquetePaso4Controller@buscar_paquete');
    Route::get('/tablero/paso/4/print/enlazados/paquete/{id}', 'Pagina\PaginaPaquetePaso4Controller@imprmirPaquete')->name("print.enlazados");
    /*----------------------------------rutas de destinos------------------------------------------*/
    Route::get('/tablero/paquetes/destino/admin',['as'=>'manageDestino-A',
        'uses'=>'Pagina\PaginaDestinoController@index']);
    
    Route::post('/tablero/paquetes/destino/admin/update',
        'Pagina\PaginaDestinoController@update');

    Route::post('/tablero/paquetes/destino/admin/store',
        'Pagina\PaginaDestinoController@store');

    Route::delete('/tablero/paquetes/destino/admin/destroy/{destino}',
        'Pagina\PaginaDestinoController@destroy');
    /*----------------------------------rutas de destinos fin------------------------------------------*/
    
    /*----------------------------------rutas de restaurante------------------------------------------*/
    Route::get('/tablero/paquetes/restaurante/admin',['as'=>'manageRestaurante-A',
        'uses'=>'Pagina\PaginaRestauranteController@index']);
    Route::get('/get/restaurantes/lista',
        'Pagina\PaginaRestauranteController@getRestaurantes');    
    Route::post('/tablero/paquetes/restaurante/admin/store',
        'Pagina\PaginaRestauranteController@store');
    Route::post('/tablero/paquetes/restaurante/admin/Update/{id}',
        'Pagina\PaginaRestauranteController@update');
    Route::delete('/tablero/paquetes/restaurante/admin/destroy/{id}',
        'Pagina\PaginaRestauranteController@destroy');
    
    /*----------------------------------rutas de restaurante fin------------------------------------------*/

    /*-----------------------------------// RUTA DE HOTELES -------------------------------------*/
    Route::get('/tablero/Hoteles/Admin/Index',
        ['as'=>'manageHoteles-A','uses'=>'Pagina\PaginaHotelController@index']);
    Route::get('/hoteles/get',
        'Pagina\PaginaHotelController@getHoteles');
    Route::get("/get/destinos/hoteles",function(){
        $destinos = App\Pagina\PaginaDestino::orderBy('id','Desc')->get();
        return $destinos;  
    });
    Route::get("/get/categorias/hoteles",function(){
        $categorias = App\Pagina\PaginaCategoriaHotel::orderBy('id','Desc')->get();
        return $categorias;  
    });
    Route::post('/tablero/Hoteles/Admin/Store',
        'Pagina\PaginaHotelController@store');
    //delete
    Route::post('/tablero/Hoteles/Admin/delete/{hotel}',
        'Pagina\PaginaHotelController@delete');    
    Route::post('/tablero/Hoteles/Admin/Update',
        'Pagina\PaginaHotelController@update');
    
    Route::post('/tablero/Hoteles/Admin/Filtro',['as'=>'manageHoteles-filtro-A','uses'=>'Pagina\PaginaHotelController@filtro']);

    Route::get('tablero/Hoteles/Admin/edit/{id}', 'Pagina\PaginaHotelController@edit');

    Route::get('tablero/Hoteles/Admin/details/{id}','Pagina\PaginaHotelController@detailsHotel')->name('detalles_hotel');
    Route::post('tablero/Hoteles/Admin/servicios_hotel','Pagina\PaginaHotelController@serviceStore')->name('servicios_hotel');

    Route::post('tablero/Hoteles/Admin/details_hotel','Pagina\PaginaHotelController@detailsHotelStore')->name('detalles_store');
    Route::get('tablero/Hoteles/Admin/details_hotel_edit/{id}','Pagina\PaginaHotelController@detailsHotelEdit')->name('detalles_edit');
    Route::put('tablero/Hoteles/Admin/details_hotel_update/{id}','Pagina\PaginaHotelController@detailsHotelUpdate')->name('detalles_update');
    /*-----------------------------------Rutas Categoria De Hoteles---------------------------------*/
    Route::post('/tablero/Hoteles/Admin/Categorias/Store',
        'Pagina\PaginaHotelCategoriaController@store');
    Route::post('/tablero/Hoteles/Admin/Categorias/Update',
        'Pagina\PaginaHotelCategoriaController@update');
    //Route::delete('/tablero/Hoteles/Admin/Categoria/Delete/{categoria_delete}',
    //    'Pagina\PaginaHotelCategoriaController@destroyCategoria');
    Route::post('/tablero/Hoteles/Admin/Categoria/Delete/{categoria_delete}',
        'Pagina\PaginaHotelCategoriaController@destroyCategoria');
    /*-----------------------------------rutas de Operadores Categoria fin---------------------------------*/
    Route::post('/tablero/Operadores/Admin/create/Categoria/Store',['as'=>'manageOperadorCategoria-store-A','uses'=>'Pagina\PaginaOperadorCategoriaController@store']);
    
    Route::post('/tablero/Operadores/Admin/create/Categoria/Update',['as'=>'manageOperadorCategoria-update-A','uses'=>'Pagina\PaginaOperadorCategoriaController@update']);

    Route::get('/tablero/operadores/Admin/Categoria/Delete/{categoria}', 'OperadorController@destroyCategoria')->name('delete.categoria.operador');
    /*-----------------------------------rutas de cotizacion de Paquetes---------------------------------*/

    Route::get('/tablero/Paquetes/Cotizaciones/index',['as'=>'manageCotizacionPaquete-A','uses'=>'Pagina\CotizacionPaqueteController@index']);
    Route::get('/tablero/Paquetes/Cotizaciones/Crear','Pagina\CotizacionPaqueteController@created');
    Route::post('/tablero/Paquetes/Cotizaciones/store','Pagina\CotizacionPaqueteController@store');

    Route::post('/tablero/Paquetes/Cotizaciones/update',
                ['as'=>'manageCotizacionPaquete-update-A','uses'=>'Pagina\CotizacionPaqueteController@update']);

    // Procesar Cotizaciones Paquetes qantu
    Route::get('/tablero/Paquetes/Qantu/Procesar/Cotizaciones',['as'=>'manageCotizacionPaquete-qantu-A','uses'=>'Pagina\ProcesarCotizacionPaqueteController@qantu']);
    Route::get('/tablero/Paquetes/Qantu/Procesar/Cotizaciones/Buscar/Paquete/{codigo}',['as'=>'manageCotizacionPaquete-buscar-paquete-A','uses'=>'Pagina\ProcesarCotizacionPaqueteController@buscarCodigo']);
    Route::post('/tablero/Paquetes/Qantu/Procesar/Cotizaciones/Agregar/Pasajero',['as'=>'manageCotizacionPaquete-agrega-cliente-A','uses'=>'Pagina\ProcesarCotizacionPaqueteController@agregarCliente']);
    Route::get('/tablero/Procesar/Cotizacion/Qantu/Finalizar/Proceso/Store',['as'=>'manageCotizacionPaquete-Proceso-final-qantu-store','uses'=>'Pagina\PaginaPaqueteBoletoController@storeBoletoQantu']);

    Route::post('/tablero/Procesar/Cotizacion/Proveedor/Finalizar/Proceso/Store',
               'Pagina\PaginaPaqueteBoletoController@storeBoletoProveedor');
   // VENTA BOLETOS PAQUETE
   Route::get('/tablero/Venta/Boletos/Paquete/Inicio',['as'=>'manageBoletoPaquete-index','uses'=>'Pagina\PaginaPaqueteBoletoController@index']);
    Route::get('/tablero/Venta/Boletos/Paquete/Modal/{boleto}',['as'=>'manageBoletoPaquete-modal','uses'=>'Pagina\PaginaPaqueteBoletoController@verBoleto']);
   // procesar cotizacion Paquetes otro proveedor

     Route::get('/tablero/Paquetes/Proveedor/Procesar/Cotizaciones',['as'=>'manageCotizacionPaquete-proveedor-A','uses'=>'Pagina\ProcesarCotizacionPaqueteController@proveedor']);


    /*-----------------------------------rutas de venta de Paquetes---------------------------------*/
    Route::get('/tablero/Paquetes/Ventas/index',['as'=>'manageVentaPaquete-A','uses'=>'Pagina\PaginaPaqueteBoletoController@index']);
    Route::get('/tablero/Paquetes/Ventas/Imprimir/boleto/{boleto}',['as'=>'manageVentaPaquete-boleto-pdf','uses'=>'Pagina\PaginaPaqueteBoletoController@pdfBoleto']);
    Route::post('/tablero/Paquetes/Ventas/Editar/Fecha',['as'=>'manageVentaPaquete-fecha','uses'=>'Pagina\PaginaPaqueteBoletoController@fechaBoleto']);
    Route::post('/tablero/Paquetes/Ventas/Editar/Filtro',['as'=>'manageVentaPaquete-filtro','uses'=>'Pagina\PaginaPaqueteBoletoController@filtro']);
    /*-------------------------------------rutas de solcitudes de agencia----------------------------*/
    Route::get('/solicitudes/agencias','Pagina\AgencyController@index');
    Route::get('/solicitudes/agencias/estodo','Pagina\AgencyController@update');
    /* Route::resource('solicitudes/agencias', 'Pagina\AgencyController',['except' => ['show','create','store','edit'] ]);
     */Route::get("/joseangel/{agencia}","Pagina\AgencyController@update");

    // rutas para las solicitudes de reserva
    Route::get('/reservations/solicitudes', function(){
        return view('adminweb.reservations.solicitudes.index');
    })->name('reservations.solicitudes');

    Route::get('find/reservations/solicitudes','Pagina\ReservationsController@solicitudes');
    Route::put('/reservations/aprobar', 'Pagina\ReservationsController@aprobar');
    Route::put('/reservations/rechazar', 'Pagina\ReservationsController@rechazar');
    Route::delete('/reservations/eliminar/{reservation}', 'Pagina\ReservationsController@eliminar');

    /* rutas para usuarios de la pagina web */
    Route::get('/usuarios/paginaweb', function(){
        $users=App\Pagina\User::where('role','client')->get();
        return view('adminweb.usuarios_web.index',compact('users'));
    })->name('usuarios_web.index');
    

    /* RUTAS PAQUETES INDEX */
    Route::get("/tablero/boletos/paquetes/index",function(){
        return view("adminweb.paquetes.ventas.index");
    })->name("boletos.paquete.index");
    Route::get("/tablero/get/boletos/paquetes","Pagina\BoletoPaquetesController@getBoletos")->name("boletos.paquete.get");
    Route::put("/tablero/edit/boletos/paquetes","Pagina\BoletoPaquetesController@editBoletos")->name("boletos.paquete.edit");
    Route::put("/tablero/anular/boletos/paquetes/{boleto}","Pagina\BoletoPaquetesController@anularBoletos")->name("boletos.paquete.null");
    Route::get("/tablero/print/boletos/paquetes/{boleto}","Pagina\BoletoPaquetesController@imprimirBoletos")->name("boletos.agencia.print");
    Route::get("/tablero/get/consolidadores/paquetes","Pagina\BoletoPaquetesController@getConsolidadores")->name("boletos.agencia.get");
    Route::get("/tablero/get/agencias/paquetes","Pagina\BoletoPaquetesController@getAgencias")->name("boletos.consolidador.get");
    Route::get("/tablero/get/vendedores/paquetes","Pagina\BoletoPaquetesController@getVendedores")->name("boletos.vendedores.get");
    Route::get("/tablero/get/tipo/pago/paquetes","Pagina\BoletoPaquetesController@getTipoPagos")->name("boletos.tipo.pago.get");
    // RUTAS DE VENTA PAQUETE OTRO PROVEEDOR
    Route::get("/tablero/paquete/otro-proveedor/","Pagina\VentaOtroProveedorController@index")->name("venta.proveedor.index");
    Route::get("/tablero/paquete/otro-proveedor/comision/{consolidador}","Pagina\VentaOtroProveedorController@comision")->name("venta.proveedor.comision");
    Route::post("/tablero/paquete/otro-proveedor/procesar/","Pagina\VentaOtroProveedorController@procesar")->name("venta.proveedor.procesar"); 

    //rutas de documento de cobranza
    Route::get("/tablero/validar/ventas-boletos",function(){
        return view("vboletos.validar.index");
    });
    Route::get("/get/boletos/sin-validar","DocumentoCobranzasController@getBoletosPorValidar");
    Route::post("/boletos/{accion}/","DocumentoCobranzasController@cambiarEstadoBoletos");
    Route::get("/get/count/boletos/sin-validar","DocumentoCobranzasController@getCountBoletosPorValidar");//#cantidad_boletos_por_validar
    Route::any("/documento/cobranza/{codigo}/{tipo}","DocumentoCobranzasController@buscarCodigo");
});

Route::group(['middleware'=>['authen','roles'],'roles'=>['2']],function(){

    /*--------------------------------------------------------------E-shop---------------------------------------------*/
    Route::get('/tablero/e-shop/categorias/admin',['as'=>'manageCategory-A','uses'=>'Eshop\CategoriesController@index']);
    Route::post('/tablero/e-shop/categorias/admin/store',['as'=>'manageCategory-store-A','uses'=>'Eshop\CategoriesController@store']);
    Route::post('/tablero/e-shop/categorias/admin/update/{id}',['as'=>'manageCategory-update-A','uses'=>'Eshop\CategoriesController@update']);
    Route::get('/tablero/e-shop/categorias/admin/status/{id}',['as'=>'manageCategory-status-A','uses'=>'Eshop\CategoriesController@status']);
    Route::get('/tablero/e-shop/categorias/admin/edit/{id}',['as'=>'manageCategory-edit-A','uses'=>'Eshop\CategoriesController@edit']);
    Route::get('/tablero/e-shop/categorias/admin/create',['as'=>'manageCategory-create-A','uses'=>'Eshop\CategoriesController@create']);
    Route::get('/tablero/e-shop/categorias/admin/destroy/{id}',['as'=>'manageCategory-destroy-A','uses'=>'Eshop\CategoriesController@destroy']);

    Route::post('/tablero/e-shop/servicios/admin/store',['as'=>'manageTypeService-store-A','uses'=>'Eshop\TypeServiceController@store']);
    Route::post('/tablero/e-shop/servicios/admin/update/{id}',['as'=>'manageTypeService-update-A','uses'=>'Eshop\TypeServiceController@update']);
    Route::get('/tablero/e-shop/servicios/admin/destroy/{id}',['as'=>'manageTypeService-destroy-A','uses'=>'Eshop\TypeServiceController@destroy']);

    Route::get('/tablero/e-shop/ordenes/admin',['as'=>'manageOrders-A','uses'=>'Eshop\OrderController@index']);
    Route::get('/tablero/e-shop/ordenes/admin/getItems',['as'=>'manageOrders-getItems-A','uses'=>'Eshop\OrderController@getItems']);
    Route::get('/tablero/e-shop/ordenes/admin/destroy/{id}',['as'=>'manageOrders-destroy-A','uses'=>'Eshop\OrderController@destroy']);

    



    Route::get('/',['as'=>'managePaginaExterna-index','uses'=>'PaginaExternaController@getManageExternalPage']);

    Route::get('/myacount',['as'=>'myacount','uses'=>'PaginaWebController@MyAcount']);
    Route::get('/logout-web',['as'=>'logout2','uses'=>'LoginController@getLogout2']);
    Route::post('/actializar/store',['as'=>'actualizar-store','uses'=>'PaginaExternaController@actualizarstore']);



});

Route::group(['middleware'=>['authen','roles'],'roles'=>['3']],function(){



});

Route::group(['middleware'=>['authen','roles'],'roles'=>['4']],function(){



});


Route::get('/',['as'=>'/', 'uses'=>'LoginController@getLogin']);
//Route::get('/admin',['as'=>'/', 'uses'=>'LoginController@getLogin']);
Route::post('/login',['as'=>'login','uses'=>'LoginController@postLogin']);
Route::post('/login3',['as'=>'login3','uses'=>'LoginController@postLogin3']);
Route::get('/login2',['as'=>'login2','uses'=>'LoginController@postLogin2']);
Route::post('/login-web',['as'=>'loginweb','uses'=>'WebLoginController@postLogin']);
Route::get('/registrar',['as'=>'registrar','uses'=>'RegistrarController@create']);
Route::post('/registrar/store',['as'=>'registrar-store','uses'=>'PaginaWebController@store']);
Route::get('/detalle/paquete/{id}',['as'=>'detalle_paquete','uses'=>'PaginaWebController@detallepaquete']);
Route::get('/general/paquete',['as'=>'general_packages','uses'=>'PaginaWebController@general_packages']);
//-----------------filtros de paquetes por categorias--------------------
Route::get('/general/paquete/nacionales',['as'=>'paquetes_nacionales','uses'=>'PaginaWebController@paquetes_nacionales']);
Route::get('/general/paquete/nacionales/norte',['as'=>'paquetes_nacionales_norte','uses'=>'PaginaWebController@paquetes_nacionales_norte']);
Route::get('/general/paquete/nacionales/sur',['as'=>'paquetes_nacionales_sur','uses'=>'PaginaWebController@paquetes_nacionales_sur']);
Route::get('/general/paquete/nacionales/centro',['as'=>'paquetes_nacionales_centro','uses'=>'PaginaWebController@paquetes_nacionales_centro']);
Route::get('/general/paquete/internacionales',['as'=>'paquetes_internacionales','uses'=>'PaginaWebController@paquetes_internacionales']);
Route::get('/general/paquete/luna_miel',['as'=>'paquetes_luna_miel','uses'=>'PaginaWebController@paquetes_luna_miel']);
//----------------final de filtros---------------------------------------
Route::post('/detalle/paquete_pasajero',['as'=>'detalle_paquete_pasajero','uses'=>'PaginaWebController@detallepaquete_reserva']);
Route::post('/detalle/paquete_pasajero/reserva',['as'=>'detalle_paquete_pasajero2','uses'=>'PaginaWebController@store2']);



Route::get('/restarpasword',['as'=>'restaurar','uses'=>'GeneradorController@restar']);
Route::post('/restarpasword/store',['as'=>'generador-store','uses'=>'GeneradorController@update2']);

Route::get('/noPermission', function(){
    return view('permission.noPermission');
});

Route::get('/indexweb',['as'=>'indexweb','uses'=>'PaginaWebController@getManageExternalPage']);
Route::get('/indexweb/terminos',['as'=>'terminos','uses'=>'PaginaExternaController@terminos']);
Route::get('/indexweb/nosotros',['as'=>'nosotros','uses'=>'PaginaExternaController@nosotros']);
Route::get('/indexweb/contactanos',['as'=>'contactanos','uses'=>'PaginaExternaController@contactanos']);

Route::get('/micuenta',['as'=>'micuenta','uses'=>'PaginaExternaController@Micuenta']);

/*-------------------------------------------links del navbar---------------------------------------*/
Route::get('/paquetes/nacionales/norte',['as'=>'norte','uses'=>'PaginaExternaController@norte']);
Route::get('/paquetes/nacionales/centro',['as'=>'centro','uses'=>'PaginaExternaController@centro']);
Route::get('/paquetes/nacionales/sur',['as'=>'sur','uses'=>'PaginaExternaController@sur']);
Route::get('/paquetes/internacionales',['as'=>'internacionales','uses'=>'PaginaExternaController@internacionales']);
Route::get('/paquetes/lunademiel',['as'=>'lunademiel','uses'=>'PaginaExternaController@lunademiel']);
Route::get('/fullday',['as'=>'fullday','uses'=>'PaginaExternaController@fullday']);
Route::get('/salidasconfirmadas',['as'=>'salidasconfirmadas','uses'=>'PaginaExternaController@salidasconfirmadas']);
Route::get('/alojamiento',['as'=>'alojamiento','uses'=>'PaginaExternaController@alojamiento']);
Route::get('/traslados/vehiculos',['as'=>'vehiculos','uses'=>'PaginaExternaController@vehiculos']);
Route::get('/traslados/trenes',['as'=>'trenes','uses'=>'PaginaExternaController@trenes']);
Route::get('/traslados/buses',['as'=>'buses','uses'=>'PaginaExternaController@buses']);
Route::get('/traslados/cruceros',['as'=>'cruceros','uses'=>'PaginaExternaController@cruceros']);
Route::get('/vuelos',['as'=>'vuelos','uses'=>'PaginaExternaController@vuelos']);
Route::get('/promociones',['as'=>'promociones','uses'=>'PaginaExternaController@promociones']);
Route::get('/seguros',['as'=>'seguros','uses'=>'PaginaExternaController@seguros']);
Route::get('/autos',['as'=>'autos','uses'=>'PaginaExternaController@autos']);
Route::get('/promocionesescolares',['as'=>'promocionesescolares','uses'=>'PaginaExternaController@promocionesescolares']);
/*-------------------------------------------links del navbar---------------------------------------*/

Route::get('/regsitar/us-ac',['as'=>'managePaginaExterna-register','uses'=>'PaginaExternaController@getManageRegister']);
Route::get('contacto','WebController@contacto');
Route::get('reviews','WebController@reviews');

// rutas de modulo de suscripciones

Route::get('/suscripciones', function(){
    return view('suscriptores.index');
});

Route::get('/creatsuscrip', function(){
    return view('suscriptores.create');
});
