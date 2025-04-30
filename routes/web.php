<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
})->name('wellcome');

Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');

Route::get('login', [AuthController::class,'login'])->name('login');

Route::get('user', [UserController::class,'index'])->name('user');

Route::get('tugas', [TugasController::class,'index'])->name('tugas');