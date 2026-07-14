<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BranchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_user_can_view_branches_index(): void
    {
        $user = User::factory()->create();
        $branch = Branch::factory()->create(['name' => 'Test Branch']);

        $response = $this->actingAs($user)->get('/branches');

        $response->assertStatus(200);
        $response->assertSee('Test Branch'); // проверяет, что данные отображаются
    }

    public function test_branch_creation_requires_name(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/branches', [
            'name' => '',
            'address' => '123 Main St',
            'phone' => '555-1234',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_user_can_see_create_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/branches/create');

        $response->assertStatus(200);
    }

    public function test_user_can_see_edit_page(): void
    {
        $user = User::factory()->create();
        $branch = Branch::factory()->create();

        $response = $this->actingAs($user)->get("/branches/{$branch->id}/edit");

        $response->assertStatus(200);
        $response->assertSee($branch->name);
    }

    public function test_branch_creation_requires_valid_data(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/branches', [
            'name' => '',
            'address' => '',
            'phone' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'address', 'phone']);
    }

    public function test_user_cannot_delete_nonexistent_branch(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete('/branches/999');

        $response->assertStatus(404);
    }
}
