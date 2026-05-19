<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PacienteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('pacientes/{paciente}/exportar-pdf', [PacienteController::class, 'exportPdf'])->name('pacientes.exportPdf');
    Route::resource('pacientes', PacienteController::class);
    Route::resource('pacientes.consultas', \App\Http\Controllers\ConsultaController::class)->shallow();
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
