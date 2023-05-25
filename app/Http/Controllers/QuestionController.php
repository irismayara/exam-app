<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Models\Option;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class QuestionController extends Controller
{    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Question::class);

        $questions = Cache::get('questions');
        
        if(!$questions)
        {
            $questions = Question::all();
            Cache::put('questions', $questions);
        }
        
        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Question::class);

        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionRequest $request)
    {
        $this->authorize('create', Question::class);

        $question = Question::create([
            'title' => $request->title,
            'question' => $request->question,
            'course' => $request->course,
            'topic' => $request->topic,
            'tags' => $request->tags,
            'difficulty' => $request->difficulty,
            'type' => $request->type,
            'is_true' => $request->is_true,
            'created_by' => Auth::user()->id,
        ]);

        if($question->isMultiplaEscolha() || 
        $question->isMultiplasRespostas()) // se tem opções
        {
            foreach ($request->options as $key => $option) 
            {
                Option::create([
                    'option' => $option,
                    'question_id' => $question->id,
                    'is_correct' => in_array($key, $request->is_correct ?? []),
                ]);
            }
        }

        Cache::forget('questions');

        return redirect('/questions')->with('success', 'Question created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $question)
    {
        $question = Question::findOrFail($question);

        $this->authorize('view', $question);
        
        $user = User::findOrFail($question->created_by);

        return view('questions.show', compact('question', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $question)
    {
        $question = Question::findOrFail($question);

        $this->authorize('update', $question);

        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionRequest $request, int $question)
    {
        $question = Question::findOrFail($question);

        $this->authorize('update', $question);
        
        foreach ($question->options as $option) {
            $option->delete();
        }

        $question->update([
            'title' => $request->title,
            'question' => $request->question,
            'course' => $request->course,
            'topic' => $request->topic,
            'tags' => $request->tags,
            'difficulty' => $request->difficulty,
            'type' => $request->type,
            'is_true' => $request->is_true,
        ]);
    
        if($question->isMultiplaEscolha() || 
        $question->isMultiplasRespostas()) // se tem opções
        {
            foreach ($request->options as $key => $option) 
            {
                Option::create([
                    'option' => $option,
                    'question_id' => $question->id,
                    'is_correct' => in_array($key, $request->is_correct ?? []),
                ]);
            }
        }

        Cache::forget('questions');

        return redirect('/questions')->with('success', 'Question updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $question)
    {
        $question = Question::findOrFail($question);

        $this->authorize('delete', $question);

        foreach ($question->options as $option) {
            $option->delete();
        }

        $question->delete();
        
        Cache::forget('questions');

        return redirect('/questions')->with('success', 'Question deleted successfully!');
    }

    public function search(Request $request)
    {
        $termo = $request->input('search');
        $tipoQuestao = $request->input('searchType');

        if($tipoQuestao){
            $questions = Question::where('type', 'like', '%' . $tipoQuestao . '%')
            ->get();
        } else {
            $questions = Question::where('title', 'like', '%' . $termo . '%')
                ->orWhere('course', 'like', '%' . $termo . '%')
                ->orWhere('tags', 'like', '%' . $termo . '%')
                ->get();
        }

        return view('questions.index', compact('questions'))->render();
    }
}
