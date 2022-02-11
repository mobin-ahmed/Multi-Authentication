<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\UserIterfaceController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// backend routes...
Route::get('/admin', [AdminController::class, 'adminLogin']);
Route::post('/admin-login', [AdminController::class, 'doLogin']);
Route::get('/logout', [AdminController::class, 'logout']);
Route::get('/', [UserIterfaceController::class, 'homepage']);
Route::get('/add-product-page', [UserIterfaceController::class, 'addProductPage']);
Route::post('/add-product', [UserIterfaceController::class, 'addProduct']);


//middleware routes
Route::group(['middleware' => 'admin'], function(){
    Route::get('/dashboard', [DashboardController::class, 'dashboard']);

});