<?php

use Illuminate\Support\Facades\Auth;
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
    if(Auth::check()) {
        return view('home');
    }
    else{
        return view('welcome');
    }
});

Auth::routes();
Route::middleware(['auth'])->group(function() {
    Route::resource('home','HomeController');
    Route::resource('painel','PainelController');
    Route::resource('projetos','ProjetosController');
    Route::resource('ajuda','AjudaController');
    Route::get('/projetos/editar/{pagina}','ProjetosController@editPagina')->name('projetos.editPagina');
    Route::put('/projetos/editar/{pagina}','ProjetosController@updatePagina')->name('projetos.updatePagina');
    Route::post('/projetos/nova/{pagina}','ProjetosController@novaPagina')->name('projetos.novaPagina');
    Route::delete('/projetos/apagar/{pagina}','ProjetosController@apagarPagina')->name('projetos.apagarPagina');
    Route::get('/projetos/visualizar/{roteiro}','ProjetosController@visualizarRoteiro')->name('projetos.visualizarRoteiro');
    Route::get('/projetos/genero/{roteiro}','PainelController@visualizarGenero')->name('visualizarGenero');
});
