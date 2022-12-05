<?php

use Illuminate\Support\Facades\Route;

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

/*****************************************************************
*Facades
*****************************************************************/
use Facades\App\Classes\Miscellany;
use Facades\App\Classes\Crypto;
use Facades\App\Classes\Cerbero;
use Facades\App\Classes\SupportImages;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', 'HomeController@index')->name('dashboard');

require __DIR__.'/auth.php';

//Route::middleware(['auth', 'AuthIPOrigen'])->group(function () {
Route::middleware(['auth'])->group(function () {

    /*****************************************************************
    *Rutas generales de Sistema
    *****************************************************************/
    //Ruta de actuializar mi cuenta a auth.edit-self

    Route::get('/ayuda', function () {
        return view('ayuda.index');
    })->name('ayuda');


    /*****************************************************************
    *Rutas de administradores de Sistema
    *****************************************************************/
    Route::resource('gestion-roles', 'Admin\GestionRolesController');
    Route::resource('gestion-permisos', 'Admin\GestionPermisosController');
    Route::resource('gestion-usuarios', 'Auth\RegisteredUserController');
    Route::resource('gestion-parametros', 'Admin\GestionParametrosController');
    Route::resource('gestion-logs', 'Admin\GestionLogController');
    Route::resource('gestion-lista-blanca', 'Auth\AuthenticatedIPController');
    Route::resource('gestion-tokens', 'Auth\TokenController');

    /*****************************************************************
    *Rutas de Modulo Inventario
    *****************************************************************/
    Route::get('inventario-home', 'Inventario\HomeController@index')->name('inventario.home');
    Route::resource('inventario-lineas', 'Inventario\LineaController');
    Route::resource('inventario-sublineas', 'Inventario\SubLineaController');
    Route::resource('inventario-bodegas', 'Inventario\BodegaController');
    Route::resource('inventario-servicios', 'Inventario\ServicioController');
    Route::resource('inventario-productos', 'Inventario\ProductoController');
    Route::resource('inventario-movimiento', 'Inventario\BodegaRproductoController');
    Route::get('inventario-transferencia-createwid/{id}', 'Inventario\TransferenciaController@createWithId')->name('inventario-transferencia.createwid');
    Route::resource('inventario-transferencia', 'Inventario\TransferenciaController');
    Route::get('inventario-ajuste-createwid/{id}', 'Inventario\AjusteController@createWithId')->name('inventario-ajuste.createwid');
    Route::resource('inventario-ajuste', 'Inventario\AjusteController');
    Route::get('inventario-insumos-createwid/{id_servicio}', 'Inventario\InsumoController@createWithId')->name('inventario-insumos.createwid');
    Route::resource('inventario-insumos', 'Inventario\InsumoController');

    /*****************************************************************
    *Rutas Clientes
    *****************************************************************/
    Route::get('patios/{id}', 'Cliente\ClienteController@getPatios');
    Route::resource('clientes', 'Cliente\ClienteController');
    Route::get('gestion-operativa-calidad/{id}', 'Cliente\DashboardController@showCalidad')->name('gestion-operativa.calidad');
    Route::resource('gestion-operativa', 'Cliente\DashboardController');
    Route::post('firma-calidad', 'Auth\FirmaController@storeRecepcion')->name('firma.calidad');
    Route::resource('firma-proceso', 'Auth\FirmaController');
    Route::get('ubicaciones-lista/{id}', 'Cliente\UbicacionesController@listUbicaciones')->name('ubicaciones.lista');
    Route::resource('ubicaciones', 'Cliente\UbicacionesController');

    /*****************************************************************
    *Rutas Servicio
    *****************************************************************/
    Route::post('servicio-delete', 'Servicios\ServicioController@deleteOT')->name('servicio.delete');
    Route::get('/delete-filter', function () {
        return view('servicio.delete');
    })->name('delete-filter');
    Route::post('servicio-estado.update', 'Servicios\ServicioController@updateState')->name('servicio-estado.update');
    Route::resource('servicio', 'Servicios\ServicioController');
    Route::get('servicio-imagen-delete/{id_image}/{id_servicio}', 'Servicios\ServicioItemController@destroyImage')->name('servicio-imagen.delete');
    Route::get('servicio-item-creatediscount/{id}', 'Servicios\ServicioItemController@createDiscountWithId')->name('servicio-item-creatediscount.create'); 
    Route::post('servicio-item.discount', 'Servicios\ServicioItemController@storeDiscount')->name('servicio-item.discount');
    Route::get('servicio-item-createwid/{id}', 'Servicios\ServicioItemController@createWithId')->name('servicio-item.createwid');    
    Route::resource('servicio-item', 'Servicios\ServicioItemController');
    Route::resource('servicio-cerrar', 'Servicios\ServicioCierreController');

    /*****************************************************************
    *Rutas Operaciones
    *****************************************************************/
    Route::get('calidad-imagen-delete/{id_image}/{id_servicio}', 'Operacion\RevisionServicioController@destroyImage')->name('calidad-imagen.delete');
    Route::post('operacion-estado-update', 'Operacion\RevisionServicioController@updateState')->name('operacion-estado.update');
    Route::get('operacion-revision-createwid/{id}', 'Operacion\RevisionServicioController@createWithId')->name('operacion-revision.createwid');
    Route::resource('operacion-revision', 'Operacion\RevisionServicioController');
    Route::get('operacion-state-update/{id}', 'Operacion\AsignarServicioController@updateServicio')->name('operacion-state.update');
    Route::get('operacion-asigna/{id}', 'Operacion\AsignarServicioController@createAsignacion')->name('operacion.asigna');
    Route::get('operacion-asignacion-createwid/{id}', 'Operacion\AsignarServicioController@createWithId')->name('operacion-asignacion.createwid');
    Route::resource('operacion', 'Operacion\AsignarServicioController');
    Route::get('dashboard-operaciones-state/{token}', 'Operacion\DashboardOperacionController@updateStateOP')->name('dashboard-operaciones.state');
    Route::resource('dashboard-operaciones', 'Operacion\DashboardOperacionController');

    /*****************************************************************
    *Rutas Financiera
    *****************************************************************/
    Route::get('cobros-cierre', 'Financiero\GestionCobroController@closePeriod')->name('cobros.cierre');
    Route::get('cobros-showinfo', 'Financiero\GestionCobroController@showInfo')->name('cobros.showinfo');    
    Route::resource('cobros', 'Financiero\GestionCobroController');

    /*****************************************************************
    *Rutas Reportes
    *****************************************************************/
    //PDF
    //Ruta especial *****************************************************************************************************
    Route::get('reportes-lote', 'Reporte\ReportesPDFController@getValorizacionBatch')->name('reportes.lote');
    //***************************************************************************************************************** */
    Route::post('reportes-valorizacion', 'Reporte\ReportesPDFController@getValorizacion')->name('reportes.valorizacion');
    Route::post('reportes-rcalidad', 'Reporte\ReportesPDFController@getRevisionCalidad')->name('reportes.rcalidad');
    Route::get('documentos-ordentrabajo-filters', 'Reporte\ReportesPDFController@filtroOrdentrabajo')->name('documentos-ordentrabajo.filters');
    Route::post('documetos-ordentrabajo', 'Reporte\ReportesPDFController@getOrdenTrabajo')->name('documentos.ordentrabajo');
    Route::get('documentos-recepcion-filters', 'Reporte\ReportesPDFController@filtroRecepcion')->name('documentos-recepcion.filters');
    Route::post('documetos-recepcioncalidad', 'Reporte\ReportesPDFController@getRecepcion')->name('documentos.recepcioncalidad');
    Route::get('documentos-inventario', 'Reporte\ReportesPDFController@getInventario')->name('documentos.inventario');
    Route::get('documentos-kardex-filters', 'Reporte\ReportesPDFController@filtroKardex')->name('documentos-kardex.filters');
    Route::post('documentos-kardex', 'Reporte\ReportesPDFController@getKardex')->name('documentos-kardex');

    //EXCEL
    Route::get('reportes-servicios-base-filters', 'Reporte\ReportesXLSXController@filtroServiciosBase')->name('reportes-servicios-base.filters');
    Route::post('reportes-servicios-base', 'Reporte\ReportesXLSXController@getServiciosBase')->name('reportes.servicios-base');
    Route::get('reportes-servicios-filters', 'Reporte\ReportesXLSXController@filtroServicios')->name('reportes-servicios.filters');
    Route::post('reportes-servicios', 'Reporte\ReportesXLSXController@getServicios')->name('reportes.servicios');

    //VISTAS
    Route::get('buscar-servicios-filters', 'Reporte\BusquedaContoller@filtroBuscar')->name('buscar-servicios.filters');
    Route::post('buscar-servicios', 'Reporte\BusquedaContoller@buscarServicios')->name('buscar.servicios');
    Route::get('buscar-servicios-show/{id}', 'Reporte\BusquedaContoller@showServicio')->name('buscar-servicios.show');

    /*****************************************************************
    *Rutas Empleados
    *****************************************************************/
    Route::resource('empleado', 'Empleado\EmpleadoController');
    Route::get('empleado-pago-cierre', 'Empleado\PagoComisionController@closePeriod')->name('empleado-pago.cierre');
    Route::get('empleado-pago-showinfo', 'Empleado\PagoComisionController@showInfo')->name('empleado-pago.showinfo');
    Route::resource('empleado-pago', 'Empleado\PagoComisionController');

    /*****************************************************************
    *Rutas Flotas
    *****************************************************************/
    Route::get('flota-imagen-delete/{id_image}/{id_vehiculo}', 'Flota\VehiculoController@destroyImage')->name('flota-imagen.delete');
    Route::resource('flota', 'Flota\VehiculoController');

    
});