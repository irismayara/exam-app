<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Models\Option;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Question::class, 'question');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::all();

        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionRequest $request)
    {
        //dd($request->all());
        $question = Question::create([
            'title' => $request->title,
            'question' => $request->question,
            'course' => $request->course,
            'topic' => $request->topic,
            'tags' => $request->tags,
            'difficulty' => $request->difficulty,
            'type' => $request->type,
            'created_by' => Auth::user()->id,
        ]);

        if($question->type != 1) // se não for questão aberta
        {
            foreach ($request->option as $key => $option) 
            {
                Option::create([
                    'option' => $option,
                    'question_id' => $question->id,
                    'is_correct' => isset($request->is_correct[$key])
                ]);
            }
        }

        return redirect('/questions')->with('success', 'Question created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $question)
    {
        $question = Question::find($question);
        $user = User::find($question->created_by);

        return view('questions.show', compact('question', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $question)
    {
        $question = Question::find($question);

        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionRequest $request, int $question)
    {
        $question = Question::find($question);
        
        foreach ($question->options as $option) {
            $option->delete();
        }

        $question->update([
            'title' => $request->title,
            'question' => $request->question,
            'course' => $request->course,
            'topic' => $request->topic,
            'tags' => $request->tags,
            'level' => $request->level,
            'type' => $request->type,
        ]);

        if($question->type != 1) // se não for questão aberta
        {
            foreach ($request->option as $key => $option) 
            {
                Option::create([
                    'option' => $option,
                    'question_id' => $question->id,
                    'is_correct' => isset($request->is_correct[$key])
                ]);
            }
        }

        return redirect('/questions')->with('success', 'Question updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $question)
    {
        $question = Question::find($question);

        foreach ($question->options as $option) {
            $option->delete();
        }

        $question->delete();

        return redirect('/questions')->with('success', 'Question deleted successfully!');
    }
}
