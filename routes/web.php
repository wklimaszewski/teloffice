<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('welcome');
});

Route::get('/map', function () {
    return view('map');
});

//Route::get('logout', function ()
//{
//    Auth::logout();
//});

Route::get('/list', function () {
    return view('list');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('invoices', App\Http\Controllers\InvoicesController::class);
Route::resource('companies', App\Http\Controllers\CompaniesController::class);
Route::resource('services', App\Http\Controllers\ServicesController::class);
Route::resource('customers', App\Http\Controllers\CustomerController::class);
Route::resource('agreements', App\Http\Controllers\AgreementsController::class);
Route::resource('notifications', App\Http\Controllers\NotificationsController::class);

Route::get('faktura_add', 'App\Http\Controllers\InvoicesController@create_pdf');
require __DIR__.'/auth.php';
