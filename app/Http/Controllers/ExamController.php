<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    public function index($subtest_id)
    {
        $questions = DB::table('questions')
            ->where('subtest_id', $subtest_id)
            ->get()
            ->map(function ($q) {
                $q->choices = DB::table('choices')
                    ->where('question_id', $q->question_id)
                    ->orderBy('label')
                    ->get();
                return $q;
            });

        $score_id = 1; // sementara (nanti dari tabel scores)

        return view('Admin.pengerjaan', compact('questions', 'subtest_id', 'score_id'));
    }

    public function saveAnswer(Request $request)
    {
        DB::table('scores')->updateOrInsert(
            [
                'score_id'    => $request->score_id,
                'question_id' => $request->question_id,
            ],
            [
                'answer' => $request->answer,
            ]
        );

        return response()->json(['status' => 'ok']);
    }
}
