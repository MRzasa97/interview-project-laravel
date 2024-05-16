<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\WorkTimeController;
use App\Http\Middleware\IsJsonRequest;
use App\Http\Middleware\RemoveTrailingSlash;

Route::middleware([RemoveTrailingSlash::class, IsJsonRequest::class])
->prefix('employees')
->group(function() {
    Route::post('/create', [EmployeeController::class, 'create'])->name('employee.create');
});

Route::post('/register', [WorkTimeController::class, 'register'])->name('worktime.register');