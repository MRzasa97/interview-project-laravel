<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::post('/create', [EmployeeController::class, 'create'])->name('employee.create');