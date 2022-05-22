<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [SessionController::class, 'login'])->name('login.api');
Route::post('/register', [AdminController::class, 'register_user'])->name('register.admin');
Route::post('/register_driver', [DriverController::class, 'store'])->name('register.driver');
Route::get('/driver', [DriverController::class, 'index'])->name('index.driver');
Route::post('/create_user', [UserController::class, 'create_user'])->name('create_user');
// Route::middleware('auth:api')->group(function (){

        Route::get('/logout', [SessionController::class, 'logout'])->name('logout.api');
        Route::get('/registers', [ManagerController::class, 'index'])->name('index.manager');
        Route::post('/register_manager', [ManagerController::class, 'store'])->name('register.manager');
        Route::get('/car', [CarController::class, 'index'])->name('index.car');
        Route::get('/car/{id}/delete', [CarController::class, 'destroy'])->name('destroy.car');
        Route::post('/car_store', [CarController::class, 'store'])->name('register.car');
        Route::post('/entry', [EntryController::class, 'store'])->name('register.entry');
        Route::get('/entry', [EntryController::class, 'index'])->name('index.entry');
        Route::post('/sleepy', [EntryController::class, 'sleepalert'])->name('sleep.alert');
        Route::post('/drowsy', [EntryController::class, 'drowsy'])->name('drowsy.notification');
        
        Route::group(['middleware' => ['UserTypeCheck:Manager']], function (){
    });
    // Route::group(['middleware' => ['UserTypeCheck:Manager']], function (){

    // });

// });