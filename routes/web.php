<?php

use App\Http\Controllers\ActivoPdfController;
use App\Http\Controllers\AuditoriaPdfController;
use App\Http\Controllers\PublicAssetController;
use App\Http\Controllers\ReporteGeneralPdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/auditoria/pdf', [AuditoriaPdfController::class, 'export'])->name('auditoria.pdf');
Route::get('/a/{token}', [PublicAssetController::class, 'show'])->name('public.asset');
Route::get('/admin/activos/{activo}/pdf', [ActivoPdfController::class, 'qrPdf'])->name('activos.pdf');
Route::get('/admin/reportes/general/pdf', [ReporteGeneralPdfController::class, 'export'])
    ->name('reportes.general.pdf');
