<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Customer;
use App\Http\Middleware\Company;
use App\Http\Middleware\Admin_Company;

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

Route::middleware([Admin_Company::class])->group(function(){
	Route::resource('companies', App\Http\Controllers\CompaniesController::class);
});
//Route::middleware([Company::class])->group(function(){
	//Route::resource('companies', App\Http\Controllers\CompaniesController::class);
//});

Route::resource('services', App\Http\Controllers\ServicesController::class);
Route::resource('customers', App\Http\Controllers\CustomerController::class);
Route::resource('agreements', App\Http\Controllers\AgreementsController::class);
Route::resource('notifications', App\Http\Controllers\NotificationsController::class);

Route::get('faktura_add', 'App\Http\Controllers\InvoicesController@create_pdf');
Route::get('umowa_add', 'App\Http\Controllers\AgreementsController@create_pdf');
Route::get('firmy', 'App\Http\Controllers\ForCustomerController@show_companies')->name('oferta');
Route::get('umowy', 'App\Http\Controllers\ForCustomerController@show_agreements')->name('umowy');
Route::get('uslugi', 'App\Http\Controllers\ForCustomerController@show_services')->name('uslugi');
Route::get('faktury', 'App\Http\Controllers\ForCustomerController@show_invoices')->name('faktury');
Route::get('zgloszenia', 'App\Http\Controllers\ForCustomerController@show_notifications')->name('zgloszenia');

Route::get('potwierdzenie', 'App\Http\Controllers\ForCustomerController@confirm')->name('potwierdzenie');
Route::get('gotowe', 'App\Http\Controllers\ForCustomerController@done')->name('gotowe');
Route::get('pobierz_fakture', 'App\Http\Controllers\ForCustomerController@pobierz_fakture')->name('pobierz_fakture');
Route::get('pobierz_umowe', 'App\Http\Controllers\ForCustomerController@pobierz_umowe')->name('pobierz_umowe');

Route::get('/paypal/checkout/{order}','App\Http\Controllers\PaymentController@getExpressCheckout');
Route::get('/paypal/checkout-success/{order}','App\Http\Controllers\PaymentController@getCheckoutSuccess')->name('paypal.success');
Route::get('/paypal/checkout-cancel','App\Http\Controllers\PaymentController@cancelPage')->name('paypal.cancel');
require __DIR__.'/auth.php';
