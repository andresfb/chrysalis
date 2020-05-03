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

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'verified']], function() {

    // Home
    Route::get('/', 'HomeController@index')->name('home');

    // Users
    Route::post('/user/promote', 'UserPromoteController')->name('user.promote');

    // Projects
    Route::resource('project', 'ProjectController');
    Route::delete('/project/{project}/delete', 'ProjectDeleteController')->name('project.delete');

    // Issues
    Route::resource('issue', 'IssueController')->except(['index', 'create']);
    Route::get('/issue/{project}', 'IssueController@index')->name('issue.index');
    Route::get('/issue/{project}/create', 'IssueController@create')->name('issue.create');
    Route::delete('/issue/{issue}/delete', 'IssueDeleteController')->name('issue.delete');
});
