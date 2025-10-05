<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Employee;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test tạo nhân viên với thông tin hợp lệ
     * 
     * @test
     */
    public function it_can_create_employee_with_valid_data()
    {
        // Arrange
        $employeeData = [
            'name' => 'Nguyễn Văn A',
            'email' => 'employee@example.com',
            'password' => 'password123',
            'birthday' => '1990-01-01',
            'address' => 'Hà Nội',
            'role' => 'Nhân viên',
            'is_active' => true
        ];

        // Act
        $employee = Employee::create(array_merge($employeeData, [
            'password' => bcrypt($employeeData['password'])
        ]));

        // Assert
        $this->assertDatabaseHas('employees', [
            'name' => 'Nguyễn Văn A',
            'email' => 'employee@example.com',
            'role' => 'Nhân viên',
            'is_active' => true
        ]);
    }

    /**
     * Test validation email unique
     * 
     * @test
     */
    public function it_validates_email_uniqueness()
    {
        // Arrange
        Employee::factory()->create(['email' => 'test@example.com']);

        // Act & Assert
        $this->expectException(\Illuminate\Database\QueryException::class);
        Employee::factory()->create(['email' => 'test@example.com']);
    }

    /**
     * Test employee factory
     * 
     * @test
     */
    public function it_can_create_employee_using_factory()
    {
        // Arrange & Act
        $employee = Employee::factory()->create();

        // Assert
        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'email' => $employee->email
        ]);
        $this->assertNotNull($employee->name);
        $this->assertNotNull($employee->email);
        $this->assertTrue($employee->is_active);
    }
}
