<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\PermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('scanners/new', [ScannerController::class, 'addRecord'])->name('scanners.addRecord');
Route::post('scanners/storeCardScanner', [ScannerController::class, 'storeCardScanner'])->name('scanners.storeCardScanner');


Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('users', UserController::class);
        Route::resource('cards', CardController::class);
        Route::resource('students', StudentController::class);
        Route::resource('scanners', ScannerController::class);
        
        // Define the custom route for storeRecord
        Route::post('scanners/storeRecord', [ScannerController::class, 'storeRecord'])->name('scanners.storeRecord');
    });