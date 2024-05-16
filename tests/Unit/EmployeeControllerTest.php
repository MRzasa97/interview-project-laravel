<?php

namespace Tests\Unit;

use App\Models\Employee;
use App\Services\EmployeeService;
use App\Services\Interfaces\EmployeeServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase;

    protected EmployeeServiceInterface $employeeService;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateEmployeeSuccessfully()
    {
        $data = [
            'first_name' => 'Joe',
            'surname' => 'Doe'
        ];
        $mock = $this->mock(EmployeeServiceInterface::class);

        $mock->shouldReceive('createEmployee')
        ->once()
        ->with($data)
        ->andReturn(new Employee($data));

        $response = $this->postJson('api/employees/create', $data);

        $response->assertStatus(Response::HTTP_CREATED)
        ->assertJsonStructure(['id']);
    }

    public function testCreateEmployeeValidationFailure()
    {
        $data = [
            'first_name' => 'John',
        ];

        $response = $this->postJson('/api/employees/create', $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['surname']);
    }
}