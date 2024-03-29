<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\AppController;

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
Route::get('/login', [AppController::class, 'login'])->name('web.login');

Route::permanentRedirect('/', '/dashboard');

Route::get('/dashboard', [AppController::class, 'index'])->name('web.dashboard');
Route::get('/user', [AppController::class, 'user'])->name('web.user');
Route::get('/matapelajaran', [AppController::class, 'matapelajaran'])->name('web.matapelajaran');
Route::get('/kriteria', [AppController::class, 'kriteria'])->name('web.kriteria');
Route::get('/alternatif', [AppController::class, 'alternatif'])->name('web.alternatif');
Route::get('/evaluation', [AppController::class, 'evaluation'])->name('web.evaluation');
Route::get('/user/matapelajaran', [AppController::class, 'userMatapelajaran'])->name('web.user.matapelajaran');
Route::get('/user/evaluation', [AppController::class, 'userEvaluation'])->name('web.user.evaluation');
Route::get('/user/dashboard', [AppController::class, 'userDashboard'])->name('web.user.dashboard');
