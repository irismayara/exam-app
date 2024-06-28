<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test it_can_create_a_question */
    public function it_can_create_a_question()
    {
        $questionData = [
            'title' => 'Sample Question',
            'question' => 'What is 2 + 2?',
            'course' => 'Math',
            'topic' => 'Arithmetic',
            'tags' => 'math, addition',
            'difficulty' => 1,
            'type' => 1,
            'created_by' => $this->user->id,
        ];

        $response = $this->post('/questions', $questionData);

        $this->assertDatabaseHas('questions', ['title' => 'Sample Question']);
    }

    /** @test it_can_update_a_question */
    public function it_can_update_a_question_as_a_creator()
    {
        $question = Question::factory()->withCreator($this->user->id)->create();

        $updatedData = [
            'title' => 'Updated Question Title',
            'question' => 'Updated question content',
            'course' => 'Updated Course',
            'topic' => 'Updated Topic',
            'tags' => 'updated, tags',
            'difficulty' => 3,
            'type' => 1,
        ];

        $response = $this->put("/questions/{$question->id}", $updatedData);

        $this->assertEquals('Updated Question Title', $question->fresh()->title);
    }

    /** @test it_can_delete_a_question */
    public function it_can_delete_a_question_as_a_creator()
    {
        $question = Question::factory()->withCreator($this->user->id)->create();

        $response = $this->delete("/questions/{$question->id}");

        $this->assertNull(Question::find($question->id));
    }

}
