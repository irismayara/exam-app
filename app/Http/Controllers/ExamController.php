<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamRequest;
use App\Models\Answer;
use App\Models\ClassModel;
use App\Models\Exam;
use App\Models\ExamAttempt;
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

        //$exams = Exam::where('datetime_start', '>', now())->get();
        $exams = Exam::all();

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

    public function start(int $examId)
    {
        $exam = Exam::findOrFail($examId);

        $this->authorize('start', $exam);

        $user_id = Auth::user()->id;

        $attempt = ExamAttempt::where('user_id', $user_id)
        ->where('exam_id', $exam->id) // Verifica o ID da prova
        ->first();

        if(!$attempt){
            $attempt = ExamAttempt::create([
                'exam_id' => $exam->id,
                'user_id' => $user_id,
                'started_at' => now(),
            ]);
        }

        return view('exams.start', compact('exam', 'attempt'));
    }
    public function send(int $examId, Request $request)
    {
        $exam = Exam::findOrFail($examId);

        $this->authorize('start', $exam);

        $user_id = Auth::user()->id;

        $attemptId = $request->attempt_id;

        $attempt = ExamAttempt::findOrFail($attemptId);

        if ($attempt->is_submitted) {
            return redirect()->route('exam.show', ['id' => $exam->id])->with('error', 'You have already submitted the exam.');
        }

        $attempt->finished_at = now();
        $attempt->is_submitted = true;
        $attempt->save();        

        if ($request->has('answer')) {
            foreach ($request->answer as $key => $a) {
                $answer = Answer::create([
                    'exam_id' => $exam->id,
                    'user_id' => $user_id,
                    'question_id' => $key,
                ]);
        
                $question = Question::findOrFail($key);
        
                if ($question->isAberta()) {
                    $answer->answer_text = $a;
                } elseif ($question->isVerdadeiroOuFalso()) {
                    $answer->is_true = $a;
                } else {
                    $answer->options()->attach($a);

                    $correctOptions = $question->correctOptions();
                    $isCorrect = true;

                    if (is_array($a)) {
                        foreach ($a as $optionSelected) {
                            if (!$correctOptions->contains('id', $optionSelected)) {
                                $isCorrect = false;
                                break;
                            }
                        }
                    } else {
                        if (!$correctOptions->contains('id', $a)) {
                            $isCorrect = false;
                        }
                    }

                    $answer->is_correct = $isCorrect;

                }

                $answer->save();
            }
        }
        return redirect()->route('exam.show', ['id' => $exam->id])->with('success', 'Exam answers registered successfully!');
    }

    public function listAnswersByClass(int $examId, int $classId)
    {
        $exam = Exam::findOrFail($examId);
        $class = ClassModel::findOrFail($classId);

        $this->authorize('listAnswersByClass', $class);

        $users = $exam->usersWhoAnsweredInClass($class);

        return view('exams.answers.index', compact('exam', 'class', 'users'));
    }

    public function editGrading(int $examId, int $userId)
    {
        $exam = Exam::findOrFail($examId);
        $user = User::findOrFail($userId);

        $this->authorize('editGrading', $exam);

        $answers = $exam->answers()
               ->where('user_id', $user->id)
               ->get();

        return view('exams.answers.show', compact('exam', 'answers'));
    }

    public function updateGrading(Request $request, Exam $exam)
    {
        $validatedData = $request->validate([
            'is_correct.*' => 'required|boolean',
        ]);

        foreach ($validatedData['is_correct'] as $answerId => $isCorrect) {
            $answer = Answer::findOrFail($answerId);

            $answer->is_correct = $isCorrect;
            $answer->save();
        }

        return redirect()->back()->with('success', 'Correção da prova salva com sucesso!');
    }

}
