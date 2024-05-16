<?php

namespace App\Services\Interfaces;

use App\Models\Employee;

interface EmployeeServiceInterface
{
    public function createEmployee(array $data): Employee;
}