<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Services\Interfaces\EmployeeServiceInterface;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct(
        public readonly EmployeeServiceInterface $employeeService
    )
    {
        
    }
    public function create(EmployeeRequest $request)
    {
        $employee = $this->employeeService->createEmployee($request->all());

        return response()->json(['id' => $employee->id], 201);
    }
}
