<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use App\Models\Branch;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_students_index(): void
    {
        $user = User::factory()->create();
        $student = Student::factory()->create(['first_name' => 'Alice']);

        $response = $this->actingAs($user)->get('/students');

        $response->assertStatus(200);
        $response->assertSee('Alice');
    }

    public function test_user_can_create_student(): void
    {
        $user = User::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->actingAs($user)->post('/students', [
            'first_name' => 'Alice',
            'last_name' => 'Smith',
            'birth_date' => '2015-01-01',
            'parent_name' => 'Mom',
            'parent_phone' => '555-1234',
            'branch_id' => $branch->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('students', ['first_name' => 'Alice']);
    }

    public function test_student_creation_requires_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/students', [
            'first_name' => '',
            'last_name' => '',
            'birth_date' => '',
            'parent_name' => '',
            'parent_phone' => '',
            'branch_id' => '',
        ]);

        $response->assertSessionHasErrors(['first_name', 'last_name', 'birth_date', 'parent_name', 'parent_phone', 'branch_id']);
    }
}
