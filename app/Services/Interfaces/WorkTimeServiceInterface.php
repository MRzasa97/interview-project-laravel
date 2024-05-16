<?php

namespace App\Services\Interfaces;

interface WorkTimeServiceInterface
{
    public function registerWorkTime(array $data): string;
    public function getWorkTimeSummary(string $employeeId, string $date): array;
}