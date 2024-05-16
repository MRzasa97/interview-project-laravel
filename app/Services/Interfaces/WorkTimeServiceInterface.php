<?php

namespace App\Services\Interfaces;

interface WorkTimeServiceInterface
{
    public function registerWorkTime(array $data): string;
}