<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function create(EmployeeRequest $request)
    {
        $employee = Employee::create($request->all());

        return response()->json(['id' => $employee->id], 201);
    }
}
