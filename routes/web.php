<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [\App\Http\Controllers\FormController::class, 'index']);
Route::post('store-form', [\App\Http\Controllers\FormController::class, 'store']);
Route::get('historical-listing/{symbol}', [\App\Http\Controllers\FormController::class, 'get'])->name('historical-listing');


