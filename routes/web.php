<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('register', AuthController::class . '@getRegister');
Route::post('register', AuthController::class . '@postRegister')->name('register');
Route::get('login', AuthController::class . '@getLogin')->name('login');
Route::post('login', AuthController::class . '@postLogin')->name('login');
Route::get('logout', AuthController::class . '@logout')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('admin/dashboard', UserController::class . '@adminDashboard')->name('admin.dashboard');
    Route::get('admin/add', UserController::class . '@adminAdd')->name('admin.add');
    Route::post('admin/add', UserController::class . '@adminStore')->name('admin.add');
    Route::get('admin/edit/{id}', UserController::class . '@adminEdit')->name('admin.edit');
    Route::post('admin/update', UserController::class . '@adminUpdate')->name('admin.update');
    Route::get('admin/delete/{id}', UserController::class . '@adminDelete')->name('admin.delete');
    Route::get('user/dashboard', UserController::class . '@userDashboard')->name('user.dashboard');
    Route::post('user/update', UserController::class . '@userUpdate')->name('user.update');



});
