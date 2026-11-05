<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\SignalRouteController;
use App\Http\Controllers\PtzController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\TroubleshootingController;
use App\Http\Controllers\TrainingController;

// Halaman Utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman Konten
Route::get('/langkah', [StepController::class, 'index'])->name('steps.index');
Route::get('/alat', [EquipmentController::class, 'index'])->name('equipment.index');
Route::get('/alur-sinyal', [SignalRouteController::class, 'index'])->name('signal-routes.index');
Route::get('/ptz', [PtzController::class, 'index'])->name('ptz.index');
Route::get('/hari-h', [ChecklistController::class, 'index'])->name('checklist.index');
Route::get('/bantuan', [TroubleshootingController::class, 'index'])->name('troubleshooting.index');
Route::get('/latihan', [TrainingController::class, 'index'])->name('training.index');
