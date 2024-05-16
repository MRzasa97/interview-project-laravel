<?php

namespace App\Services;

use App\Models\Employee;
use App\Services\Interfaces\EmployeeServiceInterface;

class EmployeeService implements EmployeeServiceInterface
{
    public function createEmployee(array $data): Employee
    {
        return Employee::create($data);
    }
}