<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['middleware'=> 'auth']);

//Usuarios
Route::resource('usuarios','UsuarioController');
Route::get('usuarios/{id}/edit', 'UsuarioController@edit');

//Usuario Contacto
Route::resource('usuarios-contacto','UsuarioContactoController');

//Ciudades
Route::resource('ciudades','CiudadController');

//File Manager
Route::resource('filemanager','FileManagerController');
Route::get('filemanager/equipos/{id}','FileManagerController@getEquipos');
Route::post('eliminardocumento','FileManagerController@destroydocument');
Route::post('filemanagers','FileManagerController@saveFile');

//Instituciones
Route::resource('instituciones','InstitucionController');
Route::get('instituciones/{id}/edit', 'InstitucionController@edit');
Route::get('instituciones/procesos/{id}', 'InstitucionController@getProcesos');

//Equipos Medicos
Route::resource('equipos','EquipoMedicoController');
Route::get('equipos/{id}/edit', 'EquipoMedicoController@edit');
Route::post('busquedaarchivos', 'EquipoMedicoController@busquedaArchivos');

//Inicio de Sesion
Route::get('/iniciar-sesion', 'LogController@index');
Route::resource('log','LogController');

//Cerrar sesion
Route::get('/logout', 'LogController@logout');

//Admin
Route::get('/admin', 'FrontController@admin');