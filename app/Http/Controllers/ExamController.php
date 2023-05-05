<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamRequest;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Exam::class, 'exam');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exams = Exam::all();

        return view('exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $questions = Question::all();
        
        return view('exams.create', compact('questions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExamRequest $request)
    {   
        $exam = Exam::create([
            'title'  => $request->title,
            'datetime_start' => $request->datetime_start,
            'datetime_end' => $request->datetime_end,
            'time' => $request->time,
        ]);

        $exam->questions()->attach($request->input('questions'));

        return redirect('/exams')->with('success', 'Exam created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $exam)
    {
        $exam = Exam::find($exam);

        return view('exams.show', compact('exam'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $exam)
    {
        $exam = Exam::find($exam);
        $questions = Question::all();

        return view('exams.edit', compact('exam', 'questions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExamRequest $request, int $exam)
    {
        $exam = Exam::find($exam);
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
        $exam = Exam::find($exam);

        $exam->questions()->detach(); // O método detach() remove todas as perguntas relacionadas com o exame antes de excluir o próprio exame.
        $exam->delete();

        return redirect('/exams')->with('success', 'Exam deleted successfully!');
    }
}
