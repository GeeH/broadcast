<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::view('/dashboard', 'dashboard')
    ->middleware(['auth'])->name('dashboard');

Route::get('/dashboard/state', \App\Http\Controllers\StateController::class)
    ->middleware(['auth']);

Route::get('/dashboard/state/{id}/mark-as-read', \App\Http\Controllers\MarkAsReadController::class)
    ->middleware(['auth']);

require __DIR__.'/auth.php';

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
