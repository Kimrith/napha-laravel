<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that all primary dashboard routes return successful status codes.
     */
    public function test_all_portal_routes_render_successfully(): void
    {
        $routes = [
            '/',
            '/dashboard',
            '/students',
            '/courses',
            '/attendance',
            '/grades',
            '/departments',
            '/settings',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

    /**
     * Test student CRUD operations.
     */
    public function test_student_crud_lifecycle(): void
    {
        // 1. Create student (POST)
        $postData = [
            'name' => 'Maya Lin',
            'email' => 'maya.lin@test.edu',
            'major' => 'Digital Architecture',
            'degree' => 'B.Arch. Sustainable Structures',
            'gender' => 'Female',
            'status' => 'Active',
        ];

        $createResponse = $this->postJson('/students', $postData);
        $createResponse->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.name', 'Maya Lin');

        $student = Student::where('email', 'maya.lin@test.edu')->first();
        $this->assertNotNull($student);

        // 2. Read student (GET)
        $showResponse = $this->getJson("/students/{$student->id}");
        $showResponse->assertStatus(200)
            ->assertJsonPath('data.name', 'Maya Lin');

        // 3. Update student (PUT)
        $updateResponse = $this->putJson("/students/{$student->id}", [
            'name' => 'Maya Lin Updated',
            'email' => 'maya.lin@test.edu',
            'major' => 'Digital Architecture',
            'gpa' => 3.95,
            'status' => 'Active',
        ]);
        $updateResponse->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.name', 'Maya Lin Updated');

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'Maya Lin Updated',
        ]);

        // 4. Delete student (DELETE)
        $deleteResponse = $this->deleteJson("/students/{$student->id}");
        $deleteResponse->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->assertDatabaseMissing('students', [
            'id' => $student->id,
        ]);
    }
}
