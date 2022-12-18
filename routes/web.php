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

Route::get('/', function () {
    return Redirect::route('login');
});

Auth::routes();



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/usuarios_lista', [App\Http\Controllers\HomeController::class, 'usuarios_lista'])->name('usuarios_lista');

Route::get('/crud_tareas', [App\Http\Controllers\Tareas_Controller::class, 'tareas_crud'])->name('crud_tareas');
Route::post('/registrar_tarea', [App\Http\Controllers\Tareas_Controller::class, 'registrar_tarea'])->name('registrar_tarea');
Route::get('/borrar_tarea', [App\Http\Controllers\Tareas_Controller::class, 'borrar_tarea'])->name('borrar_tarea');
Route::get('/edit_tarea', [App\Http\Controllers\Tareas_Controller::class, 'edit_tarea']);
Route::get('/rechazar_tarea', [App\Http\Controllers\Tareas_Controller::class, 'rechazar_tarea'])->name('rechazar_tarea');
Route::get('/finalizado_tarea', [App\Http\Controllers\Tareas_Controller::class, 'finalizado_tarea'])->name('finalizado_tarea');


