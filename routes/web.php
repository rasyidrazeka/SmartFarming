<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonitoringSensorDHTController;
use App\Http\Controllers\MonitoringSensorNPKController;
use App\Http\Controllers\RiwayatDataDHTController;
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

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/monitoringSensorNPK', [MonitoringSensorNPKController::class, 'index'])->name('monitoringSensorNPK.index');
Route::get('/monitoringSensorDHT', [MonitoringSensorDHTController::class, 'index'])->name('monitoringSensorDHT.index');

Route::group(['prefix' => 'riwayatDataDHT'], function () {
    Route::get('/', [RiwayatDataDHTController::class, 'index'])->name('riwayatDataDHT.index');
    Route::post('/list', [RiwayatDataDHTController::class, 'list'])->name('riwayatDataDHT.list');
});
