<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReporterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\UserController;

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
})->name('home');

Route::get('/track', [TrackingController::class, 'index'])->name('track');
Route::resource('lapor', ReporterController::class);
Route::post('lapor-upload', [ReporterController::class, 'uploadFile'])->name('lapor.upload');
Route::get('/api/crimes', [LaporanController::class, 'getCrimes']);
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name("logout");

Route::prefix("admin")->middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name("dashboard");
    Route::prefix('management-user')->group(function () {
        Route::get('user', [UserController::class, 'index'])->name("user.index");
        Route::get('role', [RoleController::class, 'index'])->name("role.index");
    });
});

Route::get('/dashboard_Admin/Data_permission/permission', function () {
    return view('dashboard_Admin.Data_permission.permission');
})->name('data.permission');

Route::get('/dashboard_Admin/Kategori_kasus/kategori', function () {
    return view('dashboard_Admin.Kategori_kasus.kategori');
})->name('kategori.kategori');