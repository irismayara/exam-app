<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
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
            'question' => $this->faker->paragraph,
            'course' => $this->faker->randomElement(['Math', 'Science', 'History']),
            'topic' => $this->faker->word,
            'tags' => $this->faker->words(3, true),
            'difficulty' => $this->faker->numberBetween(1, 5),
            'type' => $this->faker->randomElement([1, 2, 3, 4]), //
            'is_true' => $this->faker->boolean,
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
