<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'datetime_start' => $this->faker->dateTimeBetween('+1 day', '+1 week'),
            'datetime_end' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'time' => $this->faker->numberBetween(30, 120), // Time in minutes
            'created_by' => function () {
                return \App\Models\User::factory()->create()->id;
            },
        ];
    }

    public function withCreator($userId)
    {
        return $this->state(function (array $attributes) use ($userId) {
            return [
                'created_by' => $userId,
            ];
        });
    }
}
