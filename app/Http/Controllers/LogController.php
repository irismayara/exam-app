<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamLog;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    protected function registrarLog(Request $request)
    {
        dd("teste");
        $exam = $request->input('exam');
        $action = $request->input('action');
        $question = $request->input('question');
        $details = $request->input('details');

        ExamLog::create([
            'timestamp' => now(),
            'user' => Auth::user()->name,
            'exam_id' => $exam,
            'action' => $action,
            'question_id' => $question,
            'details' => $details,
        ]);

        return response()->json(['message' => 'Log registrado com sucesso']);
    }
}
