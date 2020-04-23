<?php

use App\Http\Controllers\ProjectController;
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

    // Projects
    Route::resource('project', 'ProjectController');
    Route::delete('/project/{project}/delete', 'ProjectDeleteController')->name('project.delete');

});
