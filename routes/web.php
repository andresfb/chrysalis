<?php

use App\Http\Controllers\Auth\RegisteredTenantController;
use App\Http\Controllers\Central\InvitationRequestController;
use App\Http\Controllers\Central\InvitationReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', static function () {
    return view('central.welcome');
});

Route::controller(InvitationReviewController::class)
    ->group(function () {
        Route::get('/invitation/{invitation}/review', 'show')->name('invitation.review');

        Route::put('/invitation/{invitation}/approve', 'update')->name('invitation.update');

        Route::delete('/invitation/{invitation}/reject', 'destroy')->name('invitation.destroy');
    });

Route::get('/invitation/review/{invitation}', )->name('invitation.review');

Route::middleware(['throttle:5,1'])
    ->controller(InvitationRequestController::class)
    ->group(function () {
        Route::get('/invitation/request', 'show')->name('invitation.show');

        Route::post('/invitation/request', 'store')->name('invitation.store');
    });

Route::middleware(['throttle:6,1', 'invitation'])
    ->controller(RegisteredTenantController::class)
    ->group(function () {
        Route::get('register', 'create')->name('register');

        Route::post('register', 'store')->name('register.store');
    });
