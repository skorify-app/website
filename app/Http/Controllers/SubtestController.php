<?php

namespace App\Http\Controllers;

use App\Models\Subtest;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

class SubtestController extends Controller
{
    public function index(): Factory|View
    {
        $role = auth()->user()->role ?? '';
        $subtests = Subtest::all()->toArray();
        return view('subtest.index', ['role' => $role, 'subtests' => $subtests]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'icon_file' => 'exclude_if:icon_file,null|image|mimetypes:image/jpeg,image/png|max:1024',
            'questions_file' => 'required|file|mimes:xlsx,xltx,xlt|max:16384'
        ]);

        DB::beginTransaction();

        try {
            // =====================
            // 1. CEK DUPLIKAT
            // =====================
            if (Subtest::where('subtest_name', $data['name'])->exists()) {
                return response()->json([
                    'error' => 'Subtes ini sudah terdaftar'
                ], 400);
            }

            // =====================
            // 2. SIMPAN SUBTEST
            // =====================
            $subtestData = [
                'subtest_name' => $data['name']
            ];

            if ($request->hasFile('icon_file')) {
                $extension = $request->file('icon_file')->getClientOriginalExtension();
                $filename = Str::random(10) . '.' . $extension;
                $request->file('icon_file')->move(public_path('images/subtest'), $filename);
                $subtestData['subtest_image_name'] = $filename;
            }

            $subtest = Subtest::create($subtestData);

            // =====================
            // 3. BACA FILE EXCEL
            // =====================
            $spreadsheet = IOFactory::load($request->file('questions_file'));
            $rows = $spreadsheet->getActiveSheet()->toArray();

            foreach ($rows as $index => $row) {
                if ($index === 0) continue; // skip header

                [$questionText, $A, $B, $C, $D, $answer] = $row;

                // insert question
                $questionId = DB::table('questions')->insertGetId([
                    'subtest_id' => $subtest->subtest_id,
                    'question_text' => $questionText,
                    'answer_label' => strtoupper($answer)
                ]);

                // insert choices
                foreach (['A'=>$A, 'B'=>$B, 'C'=>$C, 'D'=>$D] as $label => $value) {
                    DB::table('choices')->insert([
                        'question_id' => $questionId,
                        'label' => $label,
                        'choice_value' => $value
                    ]);
                }
            }

            DB::commit();
            return response()->json(null, 201);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete(String $subtest_id): JsonResponse
    {
        $subtest = Subtest::where('subtest_id', $subtest_id)->first();
        if (!$subtest->exists()) return response()->json(null, 404);

        $name = $subtest->subtest_image_name;
        $path = public_path("images/subtest/$name");
        if (File::exists($path)) File::delete($path);

        DB::table('choices')->where('question_id', $subtest_id)->delete();
        DB::table('questions')->where('subtest_id', $subtest_id)->delete();
        Subtest::destroy($subtest_id);
        return response()->json(null, 204);
    }

    public function update(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'id' => 'required|string|max:5',
                'name' => 'required|string|min:3|max:32',
                'icon' => 'exclude_if:icon,null|image|mimetypes:image/jpeg,image/png|max:1024'
            ]);

            $subtest_id = intval($request->get('id'));
            $subtest = Subtest::where('subtest_id', $subtest_id)->first();
            if (!$subtest->exists()) return response()->json(null, 404);

            $subtest_name = $request->input('name');
            $other_subtest = Subtest::where('subtest_name', $subtest_name)->first();
            if ($other_subtest && $subtest['subtest_id'] !== $other_subtest['subtest_id']) {
                return response()->json(null, 403);
            }

            $subtest->subtest_name = $subtest_name;

            if ($request->hasFile('icon')) {
                $icon_file_name = $subtest->subtest_image_name;

                $extension = $request->file('icon')->getClientOriginalExtension();

                if (!$icon_file_name) {
                    $icon_file_name = Str::random(8) . '.' . $extension;
                }

                $request->file('icon')->move(public_path('images/subtest'), $icon_file_name);
                $subtest->subtest_image_name = $icon_file_name;
            }

            $subtest->save();
            return response()->json([
                'name' => $subtest_name
            ], 204);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
