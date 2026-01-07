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
use App\Models\Account;
use App\Notifications\SubtestChangedNotification;
use Illuminate\Support\Facades\Notification;

class SubtestController extends Controller
{
    public function index(Request $request): Factory|View
    {
        $role = auth()->user()->role ?? '';
        $search = $request->query('q');

        $query = Subtest::query();
        if (!empty($search)) {
            $query->where('subtest_name', 'like', '%' . $search . '%');
        }

        // Use primary key ordering because timestamps are disabled on the model
        $subtests = $query->orderBy('subtest_id', 'desc')->get();

        return view('subtest.index', ['role' => $role, 'subtests' => $subtests, 'q' => $search]);
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

            // kirim notifikasi ke semua Admin dan Staff
            try {
                $actor = auth()->user()->full_name ?? auth()->user()->email ?? 'System';
                $actorId = auth()->user()->account_id ?? null;
                $recipients = Account::whereIn('role', ['ADMIN', 'STAFF'])->get();
                Notification::send($recipients, new SubtestChangedNotification($actor, $actorId, 'menambahkan', $subtest->subtest_name));
            } catch (\Exception $e) {
                // jangan gagal proses utama jika notifikasi gagal
            }

            return response()->json(null, 201);
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
        $subtestName = $subtest->subtest_name ?? '';
        $path = public_path("images/subtest/$name");
        if (File::exists($path)) File::delete($path);

        DB::table('choices')->where('question_id', $subtest_id)->delete();
        DB::table('questions')->where('subtest_id', $subtest_id)->delete();
        Subtest::destroy($subtest_id);

        // kirim notifikasi penghapusan
        try {
            $actor = auth()->user()->full_name ?? auth()->user()->email ?? 'System';
            $actorId = auth()->user()->account_id ?? null;
            $recipients = Account::whereIn('role', ['ADMIN', 'STAFF'])->get();
            Notification::send($recipients, new SubtestChangedNotification($actor, $actorId, 'menghapus', $subtestName));
        } catch (\Exception $e) {
        }

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
                'questions_file' => 'nullable|file|mimes:xlsx,xltx,xlt|max:16384',
                'images_zip' => 'nullable|file|mimes:zip|max:51200',
            ]);

            $subtest_id = intval($request->get('id'));
            $subtest = Subtest::where('subtest_id', $subtest_id)->first();
            if (!$subtest->exists()) return response()->json(null, 404);

            // Track changes for notification
            $changes = [];
            
            // Check name change
            $subtest_name = $request->input('name');
            if ($subtest->subtest_name !== $subtest_name) {
                $changes[] = [
                    'field' => 'nama',
                    'old' => $subtest->subtest_name,
                    'new' => $subtest_name
                ];
            }
            
            $other_subtest = Subtest::where('subtest_name', $subtest_name)->first();
            if ($other_subtest && $subtest['subtest_id'] !== $other_subtest['subtest_id']) {
                return response()->json(null, 403);
            }

            // Check duration change
            $hours   = (int) ($request->input('duration_hours') ?? 0);
            $minutes = (int) ($request->input('duration_minutes') ?? 0);
            $seconds = (int) ($request->input('duration_seconds_input') ?? 0);
            $newDurationSeconds = ($hours * 3600) + ($minutes * 60) + $seconds;
            
            if ($subtest->duration_seconds !== $newDurationSeconds) {
                // Format duration for display
                $oldH = floor($subtest->duration_seconds / 3600);
                $oldM = floor(($subtest->duration_seconds % 3600) / 60);
                $oldS = $subtest->duration_seconds % 60;
                
                $oldDuration = '';
                if ($oldH > 0) $oldDuration .= $oldH . ' jam ';
                if ($oldM > 0) $oldDuration .= $oldM . ' menit ';
                if ($oldS > 0) $oldDuration .= $oldS . ' detik';
                $oldDuration = trim($oldDuration) ?: '0 detik';
                
                $newDuration = '';
                if ($hours > 0) $newDuration .= $hours . ' jam ';
                if ($minutes > 0) $newDuration .= $minutes . ' menit ';
                if ($seconds > 0) $newDuration .= $seconds . ' detik';
                $newDuration = trim($newDuration) ?: '0 detik';
                
                $changes[] = [
                    'field' => 'durasi',
                    'old' => $oldDuration,
                    'new' => $newDuration
                ];
            }

            $subtest->subtest_name = $subtest_name;
            $subtest->duration_seconds = $newDurationSeconds;
            
            // Check icon change
            if ($request->hasFile('icon')) {
                $changes[] = [
                    'field' => 'icon',
                    'old' => null,
                    'new' => 'updated'
                ];
                
                $icon_file_name = $subtest->subtest_image_name;

                $extension = $request->file('icon')->getClientOriginalExtension();

                if (!$icon_file_name) {
                    $icon_file_name = Str::random(8) . '.' . $extension;
                }

                $request->file('icon')->move(public_path('images/subtest'), $icon_file_name);
                $subtest->subtest_image_name = $icon_file_name;
            }

            $subtest->save();

            /* ===============================
             * PROSES FILE SOAL & GAMBAR (JIKA ADA)
             * =============================== */
            if ($request->hasFile('questions_file') || $request->hasFile('images_zip')) {
                // Track file changes
                if ($request->hasFile('questions_file')) {
                    $changes[] = [
                        'field' => 'soal',
                        'old' => null,
                        'new' => 'updated'
                    ];
                }
                
                if ($request->hasFile('images_zip')) {
                    $changes[] = [
                        'field' => 'gambar',
                        'old' => null,
                        'new' => 'updated'
                    ];
                }
                
                DB::beginTransaction();
                
                try {
                    // Hapus semua soal lama jika ada file soal baru
                    if ($request->hasFile('questions_file')) {
                        DB::table('choices')->whereIn('question_id', function($query) use ($subtest_id) {
                            $query->select('question_id')
                                  ->from('questions')
                                  ->where('subtest_id', $subtest_id);
                        })->delete();
                        
                        DB::table('question_images')->whereIn('question_id', function($query) use ($subtest_id) {
                            $query->select('question_id')
                                  ->from('questions')
                                  ->where('subtest_id', $subtest_id);
                        })->delete();
                        
                        DB::table('questions')->where('subtest_id', $subtest_id)->delete();
                    }

                    /* ===============================
                     * EXTRACT ZIP GAMBAR
                     * =============================== */
                    $extractPath = storage_path("app/public/questions/{$subtest_id}");
                    
                    if ($request->hasFile('images_zip')) {
                        // Hapus folder gambar lama
                        if (File::exists($extractPath)) {
                            File::deleteDirectory($extractPath);
                        }
                        
                        File::ensureDirectoryExists($extractPath);
                        
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
                     * BACA EXCEL & IMPORT SOAL
                     * =============================== */
                    if ($request->hasFile('questions_file')) {
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
                                'subtest_id' => $subtest_id,
                                'question_text' => $question,
                                'answer_label' => $answer
                            ]);

                            if ($image && File::exists($extractPath)) {
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
                    }
                    
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
            }

            // kirim notifikasi ke Admin dan Staff bahwa subtest diedit
            try {
                $actor = auth()->user()->full_name ?? auth()->user()->email ?? 'System';
                $actorId = auth()->user()->account_id ?? null;
                $recipients = Account::whereIn('role', ['ADMIN', 'STAFF'])->get();
                Notification::send($recipients, new SubtestChangedNotification($actor, $actorId, 'mengedit', $subtest_name, $changes));
            } catch (\Exception $e) {
            }

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
