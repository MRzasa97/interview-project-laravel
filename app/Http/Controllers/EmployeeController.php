<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'surname' => 'required|string'
        ]);

        $employee = Employee::create($request->all());

        return response()->json(['id' => $employee->id], 201);
    }
}
