<?php

namespace App\Services;

use App\Services\Interfaces\WorkTimeServiceInterface;
use Illuminate\Support\Facades\Config;

class WorkTimeService implements WorkTimeServiceInterface
{
    private int $monthlyWorkHours;
    private int $standardWorkRate;
    private int $overTimeMultiplier;
    public function __construct()
    {
        $this->monthlyWorkHours = Config::get('worktime.monthly_work_hours');
        $this->standardWorkRate = Config::get('worktime.standard_rate');
        $this->overTimeMultiplier = Config::get('worktime.overtime_multiplier');
    }

    public function registerWorkTime(array $data): string
    {
        return $this->monthlyWorkHours;
    }
}
