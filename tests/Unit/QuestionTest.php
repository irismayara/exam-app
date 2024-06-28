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
    protected $nonCreator;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['type' => 'docente']);
        $this->nonCreator = User::factory()->create(['type' => 'discente']);
    }

    /** @test */
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

        $response =  $this->actingAs($this->user)->post('/questions', $questionData);

        $this->assertDatabaseHas('questions', ['title' => 'Sample Question']);
    }

    /** @test */
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

        $response = $this->actingAs($this->user)->put("/questions/{$question->id}", $updatedData);

        $this->assertEquals('Updated Question Title', $question->fresh()->title);
    }

    /** @test */
    public function it_can_delete_a_question_as_a_creator()
    {
        $question = Question::factory()->withCreator($this->user->id)->create();

        $response = $this->actingAs($this->user)->delete("/questions/{$question->id}");

        $this->assertNull(Question::find($question->id));
    }

    /** @test */
    public function it_cannot_update_a_question_as_non_creator()
    {
        $question = Question::factory()->create();

        $updatedData = [
            'title' => 'Cannot Updated Question Title',
            'question' => 'Updated question content',
            'course' => 'Updated Course',
            'topic' => 'Updated Topic',
            'tags' => 'updated, tags',
            'difficulty' => 3,
            'type' => 1,
        ];

        $response = $this->actingAs($this->nonCreator)->put("/questions/{$question->id}", $updatedData);

        $response->assertStatus(403);
        $this->assertNotEquals('Cannot Updated Question Title', $question->fresh()->title);
    }

    /** @test */
    public function it_cannot_delete_a_question_as_non_creator()
    {
        $question = Question::factory()->create();

        $response = $this->actingAs($this->nonCreator)->delete("/questions/{$question->id}");

        $response->assertStatus(403);
        $this->assertNotNull(Question::find($question->id));
    }

    /** @test */
    public function it_can_view_question_index_page()
    {
        $response = $this->actingAs($this->user)->get('/questions');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_view_question_edit_page()
    {
        $question = Question::factory()->withCreator($this->user->id)->create();

        $response = $this->actingAs($this->user)->get("/questions/{$question->id}/edit");

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_view_question_show_page()
    {
        $question = Question::factory()->withCreator($this->user->id)->create();

        $response = $this->actingAs($this->user)->get("/questions/{$question->id}");

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_view_question_create_page()
    {
        $question = Question::factory()->withCreator($this->user->id)->create();

        $response = $this->actingAs($this->user)->get("/questions/create");

        $response->assertStatus(200);
    }
}
