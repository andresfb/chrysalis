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

Auth::routes();

Route::group(['middleware' => ['auth']], function() {

    // Home
    Route::get('/', 'HomeController@index')->name('home');

    // Projects.Read
    Route::group(['middleware' => ['can:project.read']], function() {
        Route::get('/project', 'ProjectController@index')->name('project.index');
        Route::get('/project/{project}', 'ProjectController@show')->name('project.show');
    });

    // Projects.Create
    Route::group(['middleware' => ['can:project.create']], function() {
        Route::post('/project', 'ProjectController@store')->name('project.store');
        Route::get('/project/create', 'ProjectController@create')->name('project.create');
    });

    // Projects.Update
    Route::group(['middleware' => ['can:project.update']], function() {
        Route::patch('/project', 'ProjectController@update')->name('project.update');
        Route::get('/project/{project}/edit', 'ProjectController@edit')->name('project.edit');
    });

    // Projects.Delete
    Route::group(['middleware' => ['can:project.delete']], function() {
        Route::delete('/project/{project}', 'ProjectController@destroy')->name('project.destroy');
    });

});
