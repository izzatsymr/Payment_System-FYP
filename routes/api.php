<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\ScannerController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UserScannersController;
use App\Http\Controllers\Api\UserStudentsController;
use App\Http\Controllers\Api\CardScannersController;
use App\Http\Controllers\Api\ScannerCardsController;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('users', UserController::class);

        // User Scanners
        Route::get('/users/{user}/scanners', [
            UserScannersController::class,
            'index',
        ])->name('users.scanners.index');
        Route::post('/users/{user}/scanners', [
            UserScannersController::class,
            'store',
        ])->name('users.scanners.store');

        // User Students
        Route::get('/users/{user}/students', [
            UserStudentsController::class,
            'index',
        ])->name('users.students.index');
        Route::post('/users/{user}/students', [
            UserStudentsController::class,
            'store',
        ])->name('users.students.store');

        Route::apiResource('cards', CardController::class);

        // Card Scanners
        Route::get('/cards/{card}/scanners', [
            CardScannersController::class,
            'index',
        ])->name('cards.scanners.index');
        Route::post('/cards/{card}/scanners/{scanner}', [
            CardScannersController::class,
            'store',
        ])->name('cards.scanners.store');
        Route::delete('/cards/{card}/scanners/{scanner}', [
            CardScannersController::class,
            'destroy',
        ])->name('cards.scanners.destroy');

        Route::apiResource('students', StudentController::class);

        Route::apiResource('scanners', ScannerController::class);

        // Scanner Cards
        Route::get('/scanners/{scanner}/cards', [
            ScannerCardsController::class,
            'index',
        ])->name('scanners.cards.index');
        Route::post('/scanners/{scanner}/cards/{card}', [
            ScannerCardsController::class,
            'store',
        ])->name('scanners.cards.store');
        Route::delete('/scanners/{scanner}/cards/{card}', [
            ScannerCardsController::class,
            'destroy',
        ])->name('scanners.cards.destroy');
    });
