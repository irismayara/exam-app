<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\cv;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', ClassModel::class);

        $classes = ClassModel::all();

        return view('classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', ClassModel::class);

        return view('classes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', ClassModel::class);

        $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:public,private',
        ]);

        if ($request->type === 'private') {
            $class = ClassModel::create([
                'name'  => $request->name,
                'type' => $request->type,
                'code' => Str::random(6),
                'created_by' => Auth::user()->id,
            ]);
        } else {
            $class = ClassModel::create([
                'name'  => $request->name,
                'type' => $request->type,
                'created_by' => Auth::user()->id,
            ]);
        }

        return redirect()->route('classes.show', $class->id)->with('success', 'Class created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $class = ClassModel::findOrFail($id);
        $user = Auth::user();

        $this->authorize('view', $class);

        if ($class->participants->contains($user) || $class->created_by === $user->id) {
            return view('classes.show', compact('class'));
        }

        return view('classes.join', compact('class'));
    }

    public function join(Request $request, $id)
{
    $this->authorize('join', ClassModel::class);
    
    $request->validate([
        'code' => 'size:6',
    ]);

    $aluno = Auth::user();

    $class = ClassModel::findOrFail($id);

    if ($class->isPrivate() && $request->input('code') !== $class->code) {
        return redirect()->back()->withErrors(['code' => 'Código inválido.']);
    } 

        $class->participants()->attach($aluno);

        return redirect()->route('classes.show', $class->id);
}

    public function showAssignExamForm(ClassModel $class)
    {
        $this->authorize('update', $class);

        $exams = Exam::all();

        return view('classes.assignExam', compact('class', 'exams'));
    }

    public function assignExam(Request $request, ClassModel $class)
    {
        $this->authorize('update', $class);

        $request->validate([
            'exam' => 'required|exists:exams,id',
        ]);

        $examId = $request->input('exam');
        $exam = Exam::findOrFail($examId);

        if ($class->exams->contains($exam)) {
            return redirect()->back()->withErrors(['exam' => 'A prova já está atribuída à turma.']);
        }

        $class->exams()->attach($examId);

        return redirect()->route('classes.show', $class->id);
    }

}