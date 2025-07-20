<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReporterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\ReporterUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentWebController;
use App\Models\ClassRoom;

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
Route::get('/track-pdf', [TrackingController::class, 'trackPdf'])->name('track.pdf');
Route::resource('lapor', ReporterController::class);
Route::post('lapor-upload', [ReporterController::class, 'uploadFile'])->name('lapor.upload');
Route::post('lapor-detail', [ReporterController::class, 'laporDetailPost'])->name('lapor.detail.post');
Route::post('submit-user-feedback', [TrackingController::class, 'submitFeedback'])->name('track.submitFeedback');
Route::post('reminder-bk', [TrackingController::class, 'reminderBk'])->name('track.reminderBk');
Route::get('/api/crimes', [LaporanController::class, 'getCrimes']);
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name("logout");

Route::prefix("admin")->middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name("dashboard");
    Route::get('/profile-page/profile', function () { 
        return view('Profile_page.profile');
    })->name('Profile_page.profile');

    Route::prefix('management-user')->group(function () {
        Route::get('user', [UserController::class, 'index'])->name("user.index");
        Route::get('role', [RoleController::class, 'index'])->name("role.index");
        Route::get('permission', function () {
            return view('dashboard_Admin.Data_permission.permission');
        })->name('data.permission');
    });

    Route::prefix('master-data')->group(function () {
        Route::get('siswa', function () {
            $classRooms = ClassRoom::get(['name']);
            return view('dashboard_Admin.Data_siswa.siswa', compact('classRooms'));
        })->name('dashboard.siswa');

        Route::get('kategori', function () {
            return view('dashboard_Admin.Kategori_kasus.kategori');
        })->name('kategori.kategori');
        Route::get('kelas', function () {
            return view('dashboard_Admin.Data_siswa.kelas'); 
        })->name('dashboard.kelas');

        
        Route::get('tindakan', function () {
            return view('dashboard_Admin.Data_siswa.tindakan'); 
        })->name('dashboard.tindakan');
        Route::get('kasus', function () {
            return view('dashboard_Admin.Kategori_kasus.kategori'); 
        })->name('dashboard.kasus');
    });
    Route::prefix('laporan')->group(function () {
        Route::get('laporan-masuk', [ReporterUserController::class, 'index'])->name("laporan-masuk.index");
        Route::get('laporan-masuk-excel', [ReporterUserController::class, 'exportExcel'])->name("laporan-masuk.exportExcel");
        Route::post('laporan-masuk-approve', [ReporterUserController::class, 'approve'])->name("laporan-masuk.approve");
        Route::post('laporan-masuk-reject', [ReporterUserController::class, 'reject'])->name("laporan-masuk.reject");
        Route::post('send-reminder/{report}', [ReporterUserController::class, 'sendReminder'])->name("laporan.sendReminder");
    
        Route::get('verifikasi', [ReporterUserController::class, 'verifikasi'])->name("verifikasi.index");
        Route::post('verifikasi-approve', [ReporterUserController::class, 'approve'])->name("verifikasi.approve");
        Route::post('verifikasi-reject', [ReporterUserController::class, 'reject'])->name("verifikasi.reject");

        Route::get('proses', [ReporterUserController::class, 'proses'])->name("proses.index");
        Route::post('proses/{reporter}', [ReporterUserController::class, 'prosesAccept'])->name("proses.prosesAccept");
        Route::post('proses-reject', [ReporterUserController::class, 'reject'])->name("proses.reject");

        Route::get('selesai', [ReporterUserController::class, 'selesai'])->name("selesai.index");
    });

    Route::get('history', [ReporterUserController::class, 'history'])->name("history.index");
    Route::post('history-approve', [ReporterUserController::class, 'history'])->name("history.approve");
    Route::post('history-reject', [ReporterUserController::class, 'reject'])->name("history.reject");
});