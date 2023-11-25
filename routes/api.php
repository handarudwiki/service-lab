<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LabController;
use App\Http\Controllers\ResultLabController;

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

Route::controller(LabController::class)
    ->prefix('labs')
    ->group(
        function () {
            Route::post('', 'store');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
            Route::get('/{id}', 'show');
            Route::get('', 'index');
        }
    );

Route::controller(ResultLabController::class)
    ->prefix('result-labs')
    ->group(
        function () {
            Route::get('', 'index');
            Route::get('/{id}', 'show');
            Route::post('', 'store');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        }
    );
