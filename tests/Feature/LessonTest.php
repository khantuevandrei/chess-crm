<?php

namespace Tests\Feature;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LessonTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_lessons_index(): void
    {
        $user = User::factory()->create();
        Lesson::factory()->create(['title' => 'Tactics Lesson']);

        $response = $this->actingAs($user)->get('/lessons');

        $response->assertStatus(200);
        $response->assertSee('Tactics Lesson');
    }

    public function test_lesson_creation_requires_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/lessons', [
            'title' => '',
            'trainer_id' => '',
            'branch_id' => '',
            'start_time' => '',
            'end_time' => '',
        ]);

        $response->assertSessionHasErrors(['title', 'trainer_id', 'branch_id', 'start_time', 'end_time']);
    }
}
