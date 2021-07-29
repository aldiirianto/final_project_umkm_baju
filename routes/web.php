<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HistoryController;

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

Route::get('/', [HomepageController::class, 'index']);
Route::get('pesan/{id}', [PesanController::class, 'index']);
Route::post('pesan/{id}', [PesanController::class, 'pesan']);
Route::get('check_out', [PesanController::class, 'check_out']);
Route::delete('check_out/{id}', [PesanController::class, 'delete']);
Route::get('konfirmasi_check_out', [PesanController::class, 'konfirmasi']);
Route::get('profile', [ProfileController::class, 'index']);
Route::post('profile', [ProfileController::class, 'update']);
Route::get('history', [HistoryController::class, 'index']);
Route::get('history/{id}', [HistoryController::class, 'detail']);




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
