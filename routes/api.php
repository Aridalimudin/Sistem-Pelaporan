<?php

use App\Http\Controllers\ClassRoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CrimeController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\StudentController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// In routes/api.php
Route::prefix('laporan')->group(function () {
    Route::post('/store', [App\Http\Controllers\LaporanController::class, 'store']);
    Route::post('/upload-bukti', [App\Http\Controllers\LaporanController::class, 'uploadBukti']);
    Route::get('/unverified', [App\Http\Controllers\LaporanController::class, 'getUnverified']);
    Route::get('/detail/{id}', [App\Http\Controllers\LaporanController::class, 'getDetail']);
    Route::post('/verify', [App\Http\Controllers\LaporanController::class, 'verifyReport']);
    Route::post('/laporan/verify', [LaporanController::class, 'verify']);
    Route::get('/laporan/proses', [LaporanController::class, 'getLaporanDiproses']);
    Route::post('/laporan/kembalikan', [LaporanController::class, 'kembalikanLaporan']);
    Route::get('/history', [LaporanController::class, 'getHistory']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'fetchData'])->name('users.fetchData');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'fetchData'])->name('role.fetchData');
    Route::post('/', [RoleController::class, 'store']);
    Route::put('/{id}', [RoleController::class, 'update']);
    Route::delete('/{id}', [RoleController::class, 'destroy']);
});

Route::prefix('permissions')->group(function () {
    Route::get('/', [PermissionController::class, 'index']);
    Route::post('/', [PermissionController::class, 'store']);
    Route::put('/{id}', [PermissionController::class, 'update']);
    Route::delete('/{id}', [PermissionController::class, 'destroy']);
});

Route::prefix('crimes')->group(function () {
    Route::get('/data', [CrimeController::class, 'index']);
    Route::post('/data', [CrimeController::class, 'store']);
    Route::put('/data/{id}', [CrimeController::class, 'update']);
    Route::delete('/data/{id}', [CrimeController::class, 'destroy']);
});

Route::prefix('students')->group(function () {
    Route::get('/', [StudentController::class, 'fetchData']); // Menggunakan fetchData
    Route::post('/', [StudentController::class, 'store']);
    Route::get('/{student}', [StudentController::class, 'show']); // Parameter {student}
    Route::put('/{student}', [StudentController::class, 'update']); // Parameter {student}
    Route::delete('/{student}', [StudentController::class, 'destroy']); // Parameter {student}
});

Route::prefix('class-room')->group(function () {
    Route::get('/', [ClassRoomController::class, 'fetchData']); // Menggunakan fetchData
    Route::post('/', [ClassRoomController::class, 'store']);
    Route::get('/{classRoom}', [ClassRoomController::class, 'show']); // Parameter {student}
    Route::put('/{classRoom}', [ClassRoomController::class, 'update']); // Parameter {student}
    Route::delete('/{classRoom}', [ClassRoomController::class, 'destroy']); // Parameter {student}
});


Route::prefix('tindakan')->group(function () {
    Route::get('/', [OperationController::class, 'fetchData']); // Menggunakan fetchData
    Route::post('/', [OperationController::class, 'store']);
    Route::get('/{operation}', [OperationController::class, 'show']); // Parameter {student}
    Route::put('/{operation}', [OperationController::class, 'update']); // Parameter {student}
    Route::delete('/{operation}', [OperationController::class, 'destroy']); // Parameter {student}
});


