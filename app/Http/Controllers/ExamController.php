<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ExamController extends Controller
{
    /**
     * TAMPILKAN UJIAN
     * - Soal diacak per mulai tes
     * - Urutan soal tidak berubah saat refresh
     * - Opsi jawaban TIDAK diacak
     */
    public function index($subtest_id)
    {
        // ===============================
        // 1. ACAK SOAL (SEKALI PER TES)
        // ===============================
        $sessionKey = "exam_questions_$subtest_id";

        if (!Session::has($sessionKey)) {
            $questionIds = DB::table('questions')
                ->where('subtest_id', $subtest_id)
                ->pluck('question_id')
                ->toArray();

            shuffle($questionIds); // acak soal
            Session::put($sessionKey, $questionIds);
        }

        $orderedIds = Session::get($sessionKey);

        // ===============================
        // 2. AMBIL SOAL SESUAI URUTAN ACAK
        // ===============================
        $questions = Soal::with(['choices', 'image'])
            ->whereIn('question_id', $orderedIds)
            ->get()
            ->sortBy(fn ($q) => array_search($q->question_id, $orderedIds))
            ->values();

        // ===============================
        // 3. DATA SUBTEST & DURASI
        // ===============================
        $subtest = DB::table('subtests')
            ->where('subtest_id', $subtest_id)
            ->first();

        $duration_seconds = $subtest->duration_seconds ?? 1800;
        $score_id = 1; // sementara (PBL)

        return view('Admin.pengerjaan', compact(
            'questions',
            'subtest_id',
            'score_id',
            'duration_seconds'
        ));
    }

    /**
     * SIMPAN JAWABAN
     */
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

    /**
     * SELESAI UJIAN
     */
    public function finish($subtest_id)
    {
        // hapus urutan soal setelah selesai
        Session::forget("exam_questions_$subtest_id");

        return redirect('/dashboard')
            ->with('success', 'Ujian selesai');
    }
}
