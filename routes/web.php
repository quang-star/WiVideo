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


Route::get('/test-view', [App\Http\Controllers\TestView::class, 'test']);
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::get('/google-login-callback', [App\Http\Controllers\AuthController::class, 'googleLogin']);