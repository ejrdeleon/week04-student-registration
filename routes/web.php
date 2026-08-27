<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// Dashboard — landing page
Route::get('/', [StudentController::class, 'dashboard'])->name('dashboard');

// Student Registration System — full resource routes
Route::resource('students', StudentController::class);
