<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamRequest;
use App\Models\Answer;
use App\Models\Exam;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Exam::class);

        $exams = Exam::where('datetime_start', '>', now())->get();
        //$exams = Exam::all();

        return view('exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Exam::class);

        $questions = Question::all();
        
        return view('exams.create', compact('questions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExamRequest $request)
    {   
        $this->authorize('create', Exam::class);

        $exam = Exam::create([
            'title'  => $request->title,
            'datetime_start' => $request->datetime_start,
            'datetime_end' => $request->datetime_end,
            'time' => $request->time,
            'created_by' => Auth::user()->id,
        ]);

        $exam->questions()->attach($request->input('questions'));

        return redirect('/exams')->with('success', 'Exam created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $exam = Exam::findOrFail($id);

        $this->authorize('view', $exam);

        $user = User::find($exam->created_by);

        return view('exams.show', compact('exam', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $exam)
    {
        $exam = Exam::findOrFail($exam);

        $this->authorize('update', $exam);

        $questions = Question::all();

        return view('exams.edit', compact('exam', 'questions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExamRequest $request, int $exam)
    {
        $exam = Exam::findOrFail($exam);

        $this->authorize('update', $exam);

        $exam->update([
            'title'  => $request->title,
            'datetime_start' => $request->datetime_start,
            'datetime_end' => $request->datetime_end,
            'time' => $request->time,
        ]);

        $exam->questions()->sync($request->input('questions')); //O método sync() sincroniza as perguntas relacionadas com o exame, removendo as perguntas que não são mais necessárias e adicionando novas perguntas que foram selecionadas.

        return redirect('/exams')->with('success', 'Exam updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $exam)
    {
        $exam = Exam::findOrFail($exam);

        $this->authorize('delete', $exam);

        $exam->questions()->detach(); // O método detach() remove todas as perguntas relacionadas com o exame antes de excluir o próprio exame.
        $exam->delete();

        return redirect('/exams')->with('success', 'Exam deleted successfully!');
    }

    public function start(int $id)
    {
        $exam = Exam::findOrFail($id);

        $this->authorize('start', $exam);

        return view('exams.start', compact('exam'));
    }
    public function send(int $id, Request $request)
    {
        $exam = Exam::findOrFail($id);

        $this->authorize('start', $exam);

        $user_id = Auth::user()->id;

        foreach($request->answer as $key => $a)
        {
            $answer = Answer::create([
                'exam_id'  => $exam->id,
                'user_id' => $user_id,
                'question_id' => $key,
            ]);
            
            $question = Question::findOrFail($key);
                
            if($question->isAberta())
            {
                $answer->answer_text = $a;
                $answer->save();
            }
            elseif($question->isVerdadeiroOuFalso()) 
            {
                $answer->is_true = $a;
                $answer->save();
            }
            else 
            {
                $answer->options()->attach($a);
            }
        }
    }
}
