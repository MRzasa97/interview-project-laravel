<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\WorkTime;
use App\Services\Interfaces\WorkTimeServiceInterface;
use App\Services\WorkTimeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class WorkTimeServiceTest extends TestCase
{
    use RefreshDatabase;

    protected WorkTimeServiceInterface $workTimeService;

    protected function setUp(): void
    {
        parent::setUp();

        Config::set('worktime.monthly_work_hours', 40);
        Config::set('worktime.standard_rate', 20);
        Config::set('worktime.overtime_multiplier', 2);

        $this->workTimeService = new WorkTimeService;
    }

    public function testRegisterWorkTimeSuccessfully()
    {
        $employee = Employee::create(
            [
                'first_name' => 'test_name',
                'surname' => 'test_surname',
            ]
        );

        $data = [
            'employee_id' => $employee->id,
            'start_time' => '1970-01-01 08:00',
            'end_time' => '1970-01-01 14:00'
        ];

        $response = $this->workTimeService->registerWorkTime($data);

        $this->assertEquals('Work time registered!', $response);
        $this->assertDatabaseHas('work_times', [
            'employee_id' => $employee->id,
            'start_time' => '1970-01-01 08:00:00',
            'end_time' => '1970-01-01 14:00:00'
        ]);
    }

    public function testRegisterWorkTimeExceedTwelveHours()
    {
        $employee = Employee::create([
            'first_name' => 'Joe',
            'surname' => 'Doe'
        ]);

        $data = [
            'employee_id' => $employee->id,
            'start_time' => '1970-01-01 08:00',
            'end_time' => '1970-01-02 08:00'
        ];

        $this->expectException(ValidationException::class);
        $this->workTimeService->registerWorkTime($data);
    }

    public function testRegisterWorkTimeForSameDay()
    {
        $employee = Employee::create([
            'first_name' => 'Joe',
            'surname' => 'Doe'
        ]);

        WorkTime::create([
            'employee_id' => $employee->id,
            'start_time' => '1970-01-01 08:00',
            'end_time' => '1970-01-01 14:00',
            'start_day' => '1970-01-01'
        ]);

        $data = [
            'employee_id' => $employee->id,
            'start_time' => '1970-01-01 08:00',
            'end_time' => '1970-01-01 14:00'
        ];

        $this->expectException(ValidationException::class);
        $this->workTimeService->registerWorkTime($data);

    }

    public function testGetWorkSummary()
    {
        $employee = Employee::create([
            'first_name' => 'Joe',
            'surname' => 'Doe'
        ]);

        WorkTime::create([
            'employee_id' => $employee->id,
            'start_time' => '1970-01-01 08:00',
            'end_time' => '1970-01-01 14:00',
            'start_day' => '1970-01-01'
        ]);

        $summary = $this->workTimeService->getWorkTimeSummary($employee->id, '1970-01');

        $this->assertEquals(6, $summary['hours_worked']);
        $this->assertEquals(120, $summary['total_payment']);
        $this->assertEquals(6, $summary['standard_hours']);
        $this->assertEquals(0, $summary['overtime_hours']);
    }

    public function testGetWorkTimeSummaryWithOverTime()
    {
        $employee = Employee::create(
            [
                'first_name' => 'test_name',
                'surname' => 'test_surname',
            ]
        );
        for($i = 1; $i < 11; $i++)
        {
            WorkTime::create([
                'employee_id' => $employee->id,
                'start_time' => "1970-01-{$i} 08:00:00",
                'end_time' => "1970-01-{$i} 14:00:00",
                'start_day' => '1970-01-01'
            ]);
        }


        $summary = $this->workTimeService->getWorkTimeSummary($employee->id, '1970-01');

        $this->assertEquals(60, $summary['hours_worked']);
        $this->assertEquals(1600, $summary['total_payment']);
        $this->assertEquals(40, $summary['standard_hours']);
        $this->assertEquals(20, $summary['overtime_hours']);
    }
}
