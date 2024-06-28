<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Question;
use App\Models\Exam;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExamTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $nonCreator;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['type' => 'docente']);
        $this->nonCreator = User::factory()->create(['type' => 'docente']);
        $this->actingAs($this->user);
        $this->question1 = Question::factory()->create();
        $this->question2 = Question::factory()->create();
    }

    /** @test */
    public function it_can_create_a_exam()
    {
        $examData = [
            'title' => 'Sample Exam',
            'datetime_start' => now()->addHour(),
            'datetime_end' => now()->addHour()->addHour(),
            'time' => 60,
            'questions' => [$this->question1->id, $this->question2->id],
            'created_by' => $this->user->id,
        ];

        $response = $this->post('/exams', $examData);

        $this->assertDatabaseHas('exams', ['title' => 'Sample Exam']);
    }

    /** @test */
    public function it_can_update_a_exam_as_a_creator()
    {
        $exam = Exam::factory()->withCreator($this->user->id)->create();

        $updatedData = [
            'title' => 'Updated Exam Title',
            'datetime_start' => now()->addHour(),
            'datetime_end' => now()->addHour()->addHour(),
            'time' => 60,
            'questions' => [$this->question1->id, $this->question2->id],
            'created_by' => $this->user->id,
        ];

        $response = $this->put("/exams/{$exam->id}", $updatedData);

        $this->assertEquals('Updated Exam Title', $exam->fresh()->title);
    }

    /** @test */
    public function it_cannot_update_a_exam_as_non_creator()
    {
        $exam = Exam::factory()->create();

        $updatedData = [
            'title' => 'Cannot Updated Exam Title',
            'datetime_start' => now()->addHour(),
            'datetime_end' => now()->addHour()->addHour(),
            'time' => 60,
            'questions' => [$this->question1->id, $this->question2->id],
            'created_by' => $this->user->id,
        ];

        $response = $this->put("/exams/{$exam->id}", $updatedData);

        $response->assertStatus(403);
        $this->assertNull(Exam::find($updatedData['title']));
    }

    /** @test */
    public function it_can_delete_a_exam_as_creator()
    {
        $exam = Exam::factory()->withCreator($this->user->id)->create();

        $response = $this->delete("/exams/{$exam->id}");

        $this->assertNull(Exam::find($exam->id));
    }

    /** @test */
    public function it_cannot_delete_a_exam_as_non_creator()
    {
        $exam = Exam::factory()->create();

        $this->actingAs($this->nonCreator);
        $response = $this->delete("/exams/{$exam->id}");

        $response->assertStatus(403);
        $this->assertNotNull(Exam::find($exam->id));
    }

    /** @test */
    public function it_can_view_exam_index_page()
    {
        $response = $this->get('/exams');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_view_exam_show_page()
    {
        $exam = Exam::factory()->withCreator($this->user->id)->create();

        $response = $this->get("/exams/{$exam->id}");

        $response->assertStatus(200);
    }
}
