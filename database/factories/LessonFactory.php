<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\Branch;
use App\Models\Trainer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'trainer_id' => Trainer::factory(),
            'branch_id' => Branch::factory(),
            'type' => 'individual',
            'title' => fake()->sentence(3),
            'start_time' => now()->addHour(),
            'end_time' => now()->addHours(2),
            'status' => 'scheduled',
        ];
    }
}
