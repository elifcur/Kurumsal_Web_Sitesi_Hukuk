<?php

use Illuminate\Support\Facades\Route;
use Templates\Law\Http\Controllers\Admin\ConsultationController as AdminConsultationController;
use Templates\Law\Http\Controllers\Admin\PublicationController as AdminPublicationController;
use Templates\Law\Http\Controllers\Public\ConsultationController;
use Templates\Law\Http\Controllers\Public\PublicationController;

Route::get('/on-gorusme', [ConsultationController::class, 'create'])->name('consultations.create');
Route::post('/on-gorusme', [ConsultationController::class, 'store'])->middleware('throttle:contact')->name('consultations.store');
Route::get('/kaynaklar', [PublicationController::class, 'index'])->name('publications.index');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin', 'can:manage-sector'])->group(function (): void {
    Route::get('consultations', [AdminConsultationController::class, 'index'])->name('consultations.index');
    Route::get('consultations/{consultation}', [AdminConsultationController::class, 'show'])->name('consultations.show');
    Route::put('consultations/{consultation}', [AdminConsultationController::class, 'update'])->name('consultations.update');
    Route::delete('consultations/{consultation}', [AdminConsultationController::class, 'destroy'])->name('consultations.destroy');

    Route::resource('publications', AdminPublicationController::class)->except('show');
});
