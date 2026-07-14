<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Trainer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrainerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_trainers_index(): void
    {
        $user = User::factory()->create();
        $trainer = Trainer::factory()->create(['first_name' => 'John']);

        $response = $this->actingAs($user)->get('/trainers');

        $response->assertStatus(200);
        $response->assertSee('John');
    }

    public function test_user_can_create_trainer(): void
    {
        $user = User::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->actingAs($user)->post('/trainers', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '555-1234',
            'specialization' => 'Tactics',
            'branch_id' => $branch->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('trainers', ['first_name' => 'John']);
    }

    public function test_trainer_creation_requires_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/trainers', [
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'phone' => '',
            'specialization' => '',
            'branch_id' => '',
        ]);

        $response->assertSessionHasErrors(['first_name', 'last_name', 'email', 'phone', 'specialization', 'branch_id']);
    }
}
