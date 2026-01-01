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
        $subtests = Subtest::all();
        return view('subtest.index', compact('role', 'subtests'));
    }

    /* ===============================
     * STORE SUBTEST (EXCEL + ZIP)
     * =============================== */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'questions_file' => 'required|file|mimes:xlsx,xltx,xlt|max:16384',
            'images_zip' => 'nullable|file|mimes:zip|max:51200',
            'icon_file' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'duration_hours' => 'nullable|integer|min:0',
            'duration_minutes' => 'nullable|integer|min:0|max:59',
            'duration_seconds_input' => 'nullable|integer|min:0|max:59',
        ]);

        DB::beginTransaction();

        try {
            /* ===============================
            * HITUNG DURASI
            * =============================== */
            $hours   = (int) ($request->duration_hours ?? 0);
            $minutes = (int) ($request->duration_minutes ?? 0);
            $seconds = (int) ($request->duration_seconds_input ?? 0);

            $durationSeconds = ($hours * 3600) + ($minutes * 60) + $seconds;

            if ($durationSeconds <= 0) {
                throw new Exception('Durasi subtes tidak boleh 0');
            }

            /* ===============================
            * CEK DUPLIKAT
            * =============================== */
            if (Subtest::where('subtest_name', $request->name)->exists()) {
                throw new Exception('Subtest sudah terdaftar');
            }

            /* ===============================
            * SIMPAN SUBTEST
            * =============================== */
            $subtest = Subtest::create([
                'subtest_name' => $request->name,
                'duration_seconds' => $durationSeconds,
            ]);

            /* ===============================
            * SIMPAN IKON
            * =============================== */
            if ($request->hasFile('icon_file')) {
                $iconName = Str::random(10) . '.' . $request->icon_file->extension();
                $request->icon_file->move(public_path('images/subtest'), $iconName);

                $subtest->update([
                    'subtest_image_name' => $iconName
                ]);
            }

            /* ===============================
            * EXTRACT ZIP GAMBAR
            * =============================== */
            $extractPath = storage_path("app/public/questions/{$subtest->subtest_id}");
            File::ensureDirectoryExists($extractPath);

            if ($request->hasFile('images_zip')) {
                $zip = new \ZipArchive;
                if ($zip->open($request->images_zip->getRealPath()) !== true) {
                    throw new Exception('Gagal membuka ZIP gambar');
                }

                $zip->extractTo($extractPath);
                $zip->close();

                foreach (File::allFiles($extractPath) as $file) {
                    $ext = strtolower($file->getExtension());
                    if (!in_array($ext, ['png', 'jpg', 'jpeg'])) continue;

                    $target = $extractPath . '/' . strtolower($file->getFilename());
                    if ($file->getPathname() !== $target) {
                        File::move($file->getPathname(), $target);
                    }
                }

                foreach (File::directories($extractPath) as $dir) {
                    File::deleteDirectory($dir);
                }
            }

            /* ===============================
            * BACA EXCEL
            * =============================== */
            $rows = IOFactory::load($request->questions_file)
                ->getActiveSheet()
                ->toArray();

            foreach ($rows as $i => $row) {
                if ($i === 0) continue;

                [$question, $image, $A, $B, $C, $D, $answer] = $row;

                if (!trim($question)) continue;

                $map = ['1'=>'A','2'=>'B','3'=>'C','4'=>'D'];
                $answer = $map[strtoupper(trim($answer))] ?? strtoupper(trim($answer));

                if (!in_array($answer, ['A','B','C','D'])) {
                    throw new Exception("Jawaban tidak valid di baris " . ($i + 1));
                }

                $questionId = DB::table('questions')->insertGetId([
                    'subtest_id' => $subtest->subtest_id,
                    'question_text' => $question,
                    'answer_label' => $answer
                ]);

                if ($image) {
                    $imageKey = preg_replace('/[^a-z0-9]/', '', strtolower($image));
                    $foundFile = null;

                    foreach (File::allFiles($extractPath) as $file) {
                        $nameOnly = preg_replace(
                            '/[^a-z0-9]/',
                            '',
                            strtolower(pathinfo($file->getFilename(), PATHINFO_FILENAME))
                        );

                        if ($nameOnly === $imageKey) {
                            $foundFile = strtolower($file->getFilename());
                            break;
                        }
                    }

                    if (!$foundFile) {
                        throw new Exception("Gambar '{$image}' tidak ditemukan (baris " . ($i + 1) . ")");
                    }

                    DB::table('question_images')->insert([
                        'question_id' => $questionId,
                        'image_name' => $foundFile
                    ]);
                }

                foreach (['A'=>$A,'B'=>$B,'C'=>$C,'D'=>$D] as $label => $value) {
                    if (!trim($value)) {
                        throw new Exception("Pilihan {$label} kosong di baris " . ($i + 1));
                    }

                    DB::table('choices')->insert([
                        'question_id' => $questionId,
                        'label' => $label,
                        'choice_value' => $value
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('subtest.index')
                ->with('success', 'Subtest berhasil ditambahkan');

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
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
                'icon' => 'exclude_if:icon,null|image|mimetypes:image/jpeg,image/png|max:1024',
                'duration_hours'   => 'nullable|integer|min:0',
                'duration_minutes' => 'nullable|integer|min:0|max:59',
                'duration_seconds_input' => 'nullable|integer|min:0|max:59',
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
            $hours   = (int) ($request->input('duration_hours') ?? 0);
            $minutes = (int) ($request->input('duration_minutes') ?? 0);
            $seconds = (int) ($request->input('duration_seconds_input') ?? 0);

            $subtest->duration_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;
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
