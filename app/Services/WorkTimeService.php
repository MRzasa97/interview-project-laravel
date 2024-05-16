<?php

namespace App\Services;

use App\Models\WorkTime;
use App\Services\Interfaces\WorkTimeServiceInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;

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
        $startTime = \DateTime::createFromFormat('Y-m-d H:i', $data['start_time']);
        $endTime = \DateTime::createFromFormat('Y-m-d H:i', $data['end_time']);
        $startDay = $startTime->format('Y-m-d');

        if(WorkTime::where('employee_id', $data['employee_id'])->where('start_day', $startDay)->exists())
        {
            throw ValidationException::withMessages(['start_time' => 'Work time for this employee already registered for this date!']);
        }

        $interval = $startTime->diff($endTime);
        $hoursWorked = $interval->h + ($interval->days * 24) + ($interval->i / 60);

        if($hoursWorked > 12)
        {
            throw ValidationException::withMessages(['message' => 'Work time connot exced 12 hours!']);
        }

        WorkTime::create([
            'employee_id' => $data['employee_id'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'start_day' => $startDay
        ]);
        
        return 'Work time registered!';
    }
}
