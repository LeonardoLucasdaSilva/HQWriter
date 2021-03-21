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
        return redirect()->route('projetos.index');
    }
    else{
        return view('welcome');
    }
});

Auth::routes();
Route::middleware(['auth','ativo'])->group(function() {
    Route::resource('home','HomeController');
    Route::resource('painel','PainelController');
    Route::resource('projetos','ProjetosController');
    Route::resource('ajuda','AjudaController');
    Route::get('/projetos/editar/{pagina}','ProjetosController@editPagina')->name('projetos.editPagina');
    Route::put('/projetos/editar/{pagina}','ProjetosController@updatePagina')->name('projetos.updatePagina');
    Route::get('/projetos/nova/{pagina}','ProjetosController@novaPagina')->name('projetos.novaPagina');
    Route::post('/projetos/primeira/{pagina}','ProjetosController@primeiraPagina')->name('projetos.primeiraPagina');
    Route::delete('/projetos/apagar/{pagina}','ProjetosController@apagarPagina')->name('projetos.apagarPagina');
    Route::get('/projetos/visualizar/{roteiro}','ProjetosController@visualizarRoteiro')->name('projetos.visualizarRoteiro');
    Route::get('/projetos/personagem/{roteiro}','ProjetosController@criarPersonagem')->name('projetos.criarPersonagem');
    Route::get('/projetos/genero/{roteiro}','PainelController@visualizarGenero')->name('visualizarGenero');
    Route::post('/projetos/personagem/novo/{personagem}','ProjetosController@novoPersonagem')->name('projetos.novoPersonagem');
    Route::get('/projetos/fala/{personagem}/{pagina}/{tipo}','ProjetosController@lockFala')->name('projetos.lockFala');
    Route::get('/projetos/apagarpersonagem/{personagem}','ProjetosController@removerPersonagem')->name('projetos.removerPersonagem');
    Route::get('/projetos/apagarfala/{fala}','ProjetosController@removerFala')->name('projetos.removerFala');
    Route::post('/projetos/formato/novo/{formato}','ProjetosController@novoFormato')->name('projetos.novoFormato');
    Route::get('/projetos/concluir/{roteiro}','ProjetosController@concluir')->name('projetos.concluir');
    Route::get('/projetos/baixar/{roteiro}','ProjetosController@baixar')->name('projetos.baixar');
    Route::get('/projetos/baixareco/{roteiro}','ProjetosController@baixarEco')->name('projetos.baixarEco');
    Route::get('/formatos/editar/{roteiro}','ProjetosController@editFormatos')->name('projetos.editFormatos');
    Route::get('/formatos/select/{roteiro}','ProjetosController@selectFormato')->name('projetos.selectformato');
    Route::post('/projetos/update/{formato}','ProjetosController@updateFormato')->name('projetos.updateFormato');
    Route::get('/formatos/excluir/{formato}','ProjetosController@excluirFormato')->name('projetos.excluirformato');
});

Route::middleware(['auth', 'admin','ativo'])->group(function() {
    Route::resource('admin','AdminController');
    Route::get('/usuarios/editar/{usuario}','AdminController@editar')->name('editarusuario');
    Route::post('/usuarios/update/{usuario}','AdminController@updateUsuario')->name('updateusuario');
    Route::post('/usuarios/inativar/{usuario}','AdminController@inativarUsuario')->name('inativarusuario');
    Route::get('/usuarios/ativar/{usuario}','AdminController@ativarUsuario')->name('ativarusuario');
});
