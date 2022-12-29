<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\APIController;
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


Route::post('registration', [APIController::class, 'registration']);

Route::post('sectors', [APIController::class, 'sectors']);
Route::post('create-sector', [APIController::class, 'createSector']);
Route::post('update-sector', [APIController::class, 'updateSector']);
Route::post('delete-sector', [APIController::class, 'deleteSector']);

Route::post('budgets', [APIController::class, 'budgets']);
Route::post('create-budget', [APIController::class, 'createBudget']);
Route::post('update-budget', [APIController::class, 'updateBudget']);
Route::post('delete-budget', [APIController::class, 'deleteBudget']);

Route::post('entries', [APIController::class, 'entries']);
Route::post('create-entry', [APIController::class, 'createEntry']);
Route::post('update-entry', [APIController::class, 'updateEntry']);
Route::post('delete-entry', [APIController::class, 'deleteEntry']);
