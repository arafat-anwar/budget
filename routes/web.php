<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\DashboardController;
use \App\Http\Controllers\SectorController;
use \App\Http\Controllers\BudgetController;
use \App\Http\Controllers\EntryController;
use \App\Http\Controllers\PlanController;
use \App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('sectors', SectorController::class);
Route::resource('budget', BudgetController::class);
Route::resource('entries', EntryController::class);
Route::resource('plans', PlanController::class);
Route::resource('reports', ReportController::class);

require __DIR__.'/auth.php';
