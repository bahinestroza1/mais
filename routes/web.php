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

use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\DescargasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\ServiciosController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect(route('home'));
    }else{
        return redirect(route('login'));
    }
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

/**
 * RUTAS DE PLANTILLAS
 */

Route::get('/plantillas/carga_masiva_usuarios', [DescargasController::class, 'plantilla_carga_masiva_usuarios'])->name('plantilla_carga_masiva_usuarios');


/**
 * RUTAS DEL ADMINISTRADOR
 */

 /**MODULO ADMINISTRACION */

 //Gestion de municipios
Route::get('/admon/gestion_municipios', [AdministradorController::class, 'gestion_municipios'])->name('gestion_municipios');
Route::post('/admon/gestion_municipios', [AdministradorController::class, 'ver_municipios'])->name('ver_municipios');
Route::post('/admon/gestion_municipios/editar', [AdministradorController::class, 'editar_municipios'])->name('editar_municipios');

//Gestion de usuarios
Route::get('/admon/gestion_usuarios', [AdministradorController::class, 'gestion_usuarios'])->name('gestion_usuarios');
Route::post('/admon/gestion_usuarios', [AdministradorController::class, 'ver_usuarios'])->name('ver_usuarios');
Route::get('/admon/gestion_usuarios/crear', [AdministradorController::class, 'crear_usuarios'])->name('crear_usuarios');
Route::post('/admon/gestion_usuarios/crear', [AdministradorController::class, 'crear_usuarios'])->name('crear_usuarios');
Route::post('/admon/gestion_usuarios/editar', [AdministradorController::class, 'editar_usuario'])->name('editar_usuario');
Route::post('/admon/gestion_usuarios/delete', [AdministradorController::class, 'eliminar_usuario'])->name('eliminar_usuario');
Route::get('/admon/gestion_usuarios/carga_masiva', [AdministradorController::class, 'carga_masiva'])->name('carga_masiva_usuarios');
Route::post('/admon/gestion_usuarios/carga_masiva', [AdministradorController::class, 'carga_masiva'])->name('carga_masiva_usuarios');

//Gestion de funcionarios
Route::get('/admon/gestion_funcionarios', [AdministradorController::class, 'gestion_funcionarios'])->name('gestion_funcionarios');
Route::post('/admon/gestion_funcionarios', [AdministradorController::class, 'ver_funcionarios'])->name('ver_funcionarios');
Route::get('/admon/gestion_funcionarios/crear', [AdministradorController::class, 'crear_funcionarios'])->name('crear_funcionarios');
Route::post('/admon/gestion_funcionarios/crear', [AdministradorController::class, 'crear_funcionarios'])->name('crear_funcionarios');
Route::post('/admon/gestion_funcionarios/editar', [AdministradorController::class, 'editar_funcionario'])->name('editar_funcionario');
Route::post('/admon/gestion_funcionarios/delete', [AdministradorController::class, 'eliminar_funcionario'])->name('eliminar_funcionario');

//Gestion de servicios
Route::get('/admon/gestion_servicios', [AdministradorController::class, 'gestion_servicios'])->name('gestion_servicios');

//Gestion de oferta
Route::get('/admon/gestion_ofertas', [AdministradorController::class, 'gestion_ofertas'])->name('gestion_ofertas');
Route::post('/admon/gestion_ofertas', [AdministradorController::class, 'ver_ofertas'])->name('ver_ofertas');
Route::get('/admon/gestion_ofertas/crear', [AdministradorController::class, 'crear_ofertas'])->name('crear_ofertas');
Route::post('/admon/gestion_ofertas/crear', [AdministradorController::class, 'crear_ofertas'])->name('crear_ofertas');
Route::get('/admon/gestion_ofertas/buscar', [AdministradorController::class, 'buscar_ofertas'])->name('buscar_ofertas');
Route::post('/admon/gestion_ofertas/editar', [AdministradorController::class, 'editar_ofertas'])->name('editar_ofertas');
Route::get('/admon/gestion_ofertas/carga_masiva', [AdministradorController::class, 'carga_masiva_oferta_programas'])->name('carga_masiva_oferta_programas');
Route::post('/admon/gestion_ofertas/carga_masiva', [AdministradorController::class, 'carga_masiva_oferta_programas'])->name('carga_masiva_oferta_programas');
//oferta de competencia
Route::get('/admon/gestion_ofertas/crearCompetencia', [AdministradorController::class, 'crear_ofertas_competencia'])->name('crear_ofertas_competencia');
Route::post('/admon/gestion_ofertas/crearCompetencia', [AdministradorController::class, 'crear_ofertas_competencia'])->name('crear_ofertas_competencia');
Route::get('/admon/gestion_ofertas/buscarCompetencia', [AdministradorController::class, 'buscar_ofertas_competencia'])->name('buscar_ofertas_competencia');
Route::post('/admon/gestion_ofertas/competencia', [AdministradorController::class, 'ver_ofertas_competencia'])->name('ver_ofertas_competencia');
Route::post('/admon/gestion_ofertas/editarCompetencia', [AdministradorController::class, 'editar_ofertas_competencia'])->name('editar_ofertas_competencia');

//Gestion de programas
Route::get('/admon/gestion_programas', [AdministradorController::class, 'gestion_programas'])->name('gestion_programas');
Route::post('/admon/gestion_programas', [AdministradorController::class, 'ver_programa'])->name('ver_programa');
Route::get('/admon/gestion_programas/crear', [AdministradorController::class, 'crear_programas'])->name('crear_programas');
Route::post('/admon/gestion_programas/crear', [AdministradorController::class, 'crear_programas'])->name('crear_programas');
Route::post('/admon/gestion_programas/editar', [AdministradorController::class, 'editar_programa'])->name('editar_programa');





/**
 * RUTAS REFERENTES AL SERVICIO
 */

 // Oferta
Route::get('/servicios/ofertas', [ServiciosController::class, 'ver_ofertas'])->name('ver_ofertas');
Route::post('/servicios/ofertas', [ServiciosController::class, 'ver_oferta'])->name('ver_oferta');
Route::get('/servicios/ofertasCompetencia', [ServiciosController::class, 'ver_ofertas_competencias'])->name('ver_ofertas_competencias');
Route::post('/servicios/ofertasCompetencia', [ServiciosController::class, 'ver_oferta_competencia'])->name('ver_oferta_competencia');

// Solicitud
Route::get('/servicios/solicitudes', [ServiciosController::class, 'ver_solicitudes'])->name('ver_solicitudes');
Route::post('/servicios/solicitudes', [ServiciosController::class, 'ver_solicitud'])->name('ver_solicitud');
Route::get('/servicios/solicitudes/tomar', [ServiciosController::class, 'tomar_solicitud'])->name('tomar_solicitud');
Route::post('/servicios/solicitudes/tomar', [ServiciosController::class, 'asignar_solicitud'])->name('asignar_solicitud');
Route::get('/servicios/solicitudes/crear', [ServiciosController::class, 'crear_solicitudes'])->name('crear_solicitudes');
Route::post('/servicios/solicitudes/crear', [ServiciosController::class, 'crear_solicitudes'])->name('crear_solicitudes');


/**
 * RUTAS REFERENTES A LOS REPORTES
 */
Route::get('/reportes/usuarios', [ReportesController::class, 'reporte_usuarios'])->name('reporte_usuarios');
Route::get('/reportes/usuarios/municipio', [ReportesController::class, 'reporte_usuarios_municipio'])->name('reporte_usuarios_municipio');
Route::post('/reportes/usuarios/municipio', [ReportesController::class, 'descargar_reporte_usuarios_municipio'])->name('descargar_reporte_usuarios_municipio');

Route::get('/reportes/ofertas', [ReportesController::class, 'reporte_ofertas'])->name('reporte_ofertas');
Route::get('/reportes/ofertas/municipio', [ReportesController::class, 'reporte_ofertas_municipio'])->name('reporte_ofertas_municipio');
Route::post('/reportes/ofertas/municipio', [ReportesController::class, 'descargar_reporte_ofertas_municipio'])->name('descargar_reporte_ofertas_municipio');