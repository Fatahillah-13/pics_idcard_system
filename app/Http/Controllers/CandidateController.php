<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Candidate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\CandidatePict;
use App\Models\IdCardTemplate;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class CandidateController extends Controller
{
    public function getCandidate()
    {
        // Logic to retrieve candidate data
        $candidates = Candidate::whereHas('candidatepict', function ($query) {
            $query->whereNotNull('pict_name');
        })->with('candidatepict')->get();
        return response()->json($candidates);
    }

    public function getNewCandidateDatatable()
    {
        // Logic to retrieve candidate data
        $candidates = Candidate::whereHas('candidatepict', function ($query) {
            $query->whereNull('pict_name');
        })->with('candidatepict')->get();
        return DataTables::of($candidates)->make(true);
    }

    public function getCandidateDatatable()
    {
        // Logic to retrieve candidate data
        $candidates = Candidate::whereHas('candidatepict', function ($query) {
            $query->whereNotNull('pict_name');
        })->where('isPrinted', 0)->with('candidatepict')->get();
        return DataTables::of($candidates)->make(true);
    }

    public function storecandidate(Request $request)
    {
        // Logic to store candidate data

        // Validate the request data
        $request->validate([
            'inputName' => 'required|string|max:255',
            'inputBirthPlace' => 'required|string|max:255',
            'inputJobLevel' => 'required|string|max:255',
            'inputDepartment' => 'required|string|max:255',
            'inputBirthDate' => 'required|date',
            'inputFirstWorkDay' => 'required|date',
            'inputPictNumber' => 'nullable|numeric',
            // Add other validation rules as needed
        ]);
        // Store the candidate data in the database
        $candidate = new Candidate();
        $candidate->name = $request->inputName;
        $candidate->birthplace = $request->inputBirthPlace;
        $candidate->job_level = $request->inputJobLevel;
        $candidate->department = $request->inputDepartment;
        $candidate->birthdate = $request->inputBirthDate;
        $candidate->first_working_day = $request->inputFirstWorkDay;
        $candidate->save();

        // If pict number is provided, store it in the database
        if ($request->has('inputPictNumber')) {
            $candidatePict = new CandidatePict();
            $candidatePict->candidate_id = $candidate->id; // Assuming 'employee_id' is the foreign key
            $candidatePict->pict_number = $request->inputPictNumber;
            $candidatePict->save();
        }

        // Redirect back to the candidate page with a success message
        return redirect('/candidate/store')->with('success', 'Candidate added successfully.');
    }

    // import excel file
    public function importExcel(Request $request)
    {
        // Validate the request
        $request->validate([
            'importFile' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        try {
            // Handle the uploaded file
            $file = $request->file('importFile');
            $filePath = $file->storeAs('uploads', $file->getClientOriginalName(), 'public');

            // Get the full storage path
            $realPath = storage_path('app/public/' . $filePath);

            // Load Excel data
            $data = Excel::toArray([], $realPath);
            $rows = $data[0]; // First sheet

            $insertedCount = 0;

            foreach ($rows as $index => $row) {
                // Skip empty or header rows
                if (!isset($row[1]) || strtolower(trim($row[1])) === 'nama lengkap') {
                    continue;
                }

                // Parse birthdate
                try {
                    if (isset($row[5]) && !empty($row[5])) {
                        $birthdate = is_numeric($row[5])
                            ? \Carbon\Carbon::createFromDate(1900, 1, 1)->addDays($row[5] - 2)
                            : \Carbon\Carbon::parse($row[5]);
                    } else {
                        $birthdate = null;
                    }
                } catch (\Exception $e) {
                    $birthdate = null;
                }

                // Parse first working day
                try {
                    if (isset($row[6]) && !empty($row[6])) {
                        $firstWorkingDay = is_numeric($row[6])
                            ? \Carbon\Carbon::createFromDate(1900, 1, 1)->addDays($row[6] - 2)
                            : \Carbon\Carbon::parse($row[6]);
                    } else {
                        $firstWorkingDay = null;
                    }
                } catch (\Exception $e) {
                    $firstWorkingDay = null;
                }

                // Check for duplicates
                $existingCandidate = Candidate::where('name', $row[1])
                    ->where('birthdate', $birthdate)
                    ->where('first_working_day', $firstWorkingDay)
                    ->first();

                if ($existingCandidate) {
                    continue;
                }

                // Create and populate candidate
                $candidate = new Candidate();
                $candidate->name = $row[1] ?? null;
                $candidate->job_level = $row[2] ?? null;
                $candidate->department = $row[3] ?? null;
                $candidate->birthplace = $row[4] ?? null;
                $candidate->birthdate = $birthdate;
                $candidate->first_working_day = $firstWorkingDay;
                $candidate->save();

                // Optional: Save pict number if provided
                if (isset($row[7]) && is_numeric($row[7])) {
                    $candidatePict = new CandidatePict();
                    $candidatePict->pict_number = $row[7];
                    $candidatePict->candidate_id = $candidate->id;
                    $candidate->candidatepict()->save($candidatePict);
                } else {
                    // If no pict number is provided, pict_number is null
                    $candidatePict = new CandidatePict();
                    $candidatePict->pict_number = null;
                    $candidatePict->candidate_id = $candidate->id;
                    $candidate->candidatepict()->save($candidatePict);
                }

                $insertedCount++;
            }

            return redirect()->back()->with('success', "$insertedCount candidates imported successfully.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while processing the file: ' . $e->getMessage());
        }
    }

    // Export to excel
    public function exportExcel(Request $request)
    {
        $candidateIds = $request->input('candidate_ids', []);

        if (empty($candidateIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada kandidat yang dipilih.'
            ], 400);
        }

        // get candidates sesuai request (hanya yang dipilih, punya foto, dan belum dicetak)
        $candidates = Candidate::whereIn('id', $candidateIds)
            ->whereHas('candidatepict', function ($query) {
                $query->whereNotNull('pict_name');
            })
            ->where('isPrinted', 0)
            ->with('candidatepict')
            ->get();

        if ($candidates->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data kandidat tidak ditemukan atau tidak memenuhi syarat export.'
            ], 404);
        }

        $exportData = [];
        // add header
        $exportData[] = [
            'NIK',
            'Nama Lengkap',
            'Jabatan',
            'Departemen',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Tanggal Masuk',
            'Nomor Foto',
        ];

        foreach ($candidates as $candidate) {
            $exportData[] = [
                $candidate->employee_id,
                $candidate->name,
                $candidate->job_level,
                $candidate->department,
                $candidate->birthplace,
                $candidate->birthdate,
                $candidate->first_working_day,
                $candidate->candidatepict->pict_number ?? '',
            ];
        }

        $fileName = 'candidates_export_' . date('Ymd_His') . '.xlsx';
        $filePath = 'exports/' . $fileName;

        // Define a simple export class on the fly
        $export = new class($exportData) implements \Maatwebsite\Excel\Concerns\FromArray {
            protected $data;
            public function __construct(array $data)
            {
                $this->data = $data;
            }
            public function array(): array
            {
                return $this->data;
            }
        };

        // simpan ke storage/public/exports
        Excel::store(
            $export,
            $filePath,
            'public'
        );

        return response()->json([
            'success' => true,
            'file_url' => Storage::url($filePath),
            'message' => 'Export berhasil.'
        ]);
    }


    public function editcandidate($id)
    {
        $candidate = Candidate::findOrFail($id);
        return response()->json([
            'name' => $candidate->name,
            'employee_id' => $candidate->employee_id,
            'birthplace' => $candidate->birthplace,
            'job_level' => $candidate->job_level,
            'department' => $candidate->department,
            'birthdate' => $candidate->birthdate,
            'first_working_day' => $candidate->first_working_day,
            'candidatepict' => [
                'pict_number' => $candidate->candidatepict->pict_number ?? null,
                'image_url' => $candidate->candidatepict && $candidate->candidatepict->pict_name
                    ? Storage::url($candidate->candidatepict->pict_name)
                    : 'tidak ada gambar',
            ],
        ]);
    }

    public function updatecandidate(Request $request, $id)
    {

        // Logic to update candidate data
        $request->validate([
            'employee_id' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'birthPlace' => 'nullable|string|max:255',
            'birthDate' => 'nullable|date',
            'jobLevel' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'firstWorkDay' => 'nullable|date',
            // Add other validation rules as needed
        ]);
        // Find the candidate by ID and update the data
        $candidate = Candidate::findOrFail($id);
        $candidate->update([
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'birthplace' => $request->birthPlace,
            'birthdate' => $request->birthDate,
            'job_level' => $request->jobLevel,
            'department' => $request->department,
            'first_working_day' => $request->firstWorkDay,
        ]);

        // If pict number is provided, update it in the database
        $pictNumber = $request->pictNumber;
        if ($pictNumber) {
            CandidatePict::where('candidate_id', $id)
                ->update(['pict_number' => $pictNumber]);
        }


        // If pict is provided, update it in database
        $dataUri = $request->imagePath;
        if ($dataUri) {
            // pass the request to updatecandidatepict function
            if (preg_match('/^data:image\/(\w+);base64,/', $dataUri, $type)) {
                $dataUri = substr($dataUri, strpos($dataUri, ',') + 1);
                $type = strtolower($type[1]); // Mengambil tipe gambar (jpeg, png, dll)                
                // Decode base64
                $data = base64_decode($dataUri, true);
                if ($data === false) {
                    return response()->json(['message' => 'Gagal mendekode gambar.'], 400);
                } else {
                    // Membuat nama file yang unik
                    $filename = $candidate->employee_id
                        ? $candidate->employee_id . '.' . $type
                        : 'pic_' . time() . '.' . $type;
                    $filePath = public_path('storage/' . $filename); // Path untuk menyimpan file
                    // Menyimpan gambar ke public/storage
                    if (file_put_contents($filePath, $data) === false) {
                        return response()->json(['message' => 'Gagal menyimpan gambar.'], 500);
                    }
                    $get_foto = CandidatePict::where('candidate_id', $id);
                    if ($get_foto->count() > 0) {
                        CandidatePict::where('pict_number', $pictNumber)->update([
                            'pict_name' => $filename, // Simpan path file relatif
                        ]);
                    } else {
                        CandidatePict::create([
                            'candidate_id' => $id, // ID karyawan yang diupload
                            'pict_number' => $pictNumber, // Ambil nomor foto dari input
                            'pict_name' => $filename, // Simpan path file relatif
                        ]);
                    }
                }
                $new_candidates = CandidatePict::get();
                return response()->json($new_candidates);
            } else {
                $new_candidates = CandidatePict::get();
                return response()->json($new_candidates);
            }
        }
        // Redirect back to the candidate page with a success message
        return response()->json(['success' => true, 'message' => 'Candidate updated successfully.']);
    }

    public function getMaxEmployeeID(Request $request)
    {
        // Validasi input tahun dan bulan
        $request->validate([
            'year' => 'required|digits:4',
            'month' => 'required|digits_between:1,2'
        ]);

        $year = $request->year;
        $month = str_pad($request->month, 2, '0', STR_PAD_LEFT); // Pastikan dua digit

        // Query untuk mengambil employee_id tertinggi berdasarkan bulan dan tahun
        $maxID = Candidate::whereYear('first_working_day', $year)
            ->whereMonth('first_working_day', $month)
            ->max('employee_id');

        return response()->json([
            'max_employee_id' => $maxID ?? 0
        ]);
    }

    public function updatecandidateNIK(Request $request)
    {
        $candidates = $request->input('candidates');

        if (!$candidates || !is_array($candidates)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid candidate data.'
            ]);
        }

        try {
            // 1. Cek duplikasi employee_id di data input
            $employeeIds = array_column($candidates, 'employee_id');
            if (count($employeeIds) !== count(array_unique($employeeIds))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Duplicate employee_id found in request data.'
                ], 422);
            }

            // 2. Ambil semua employee_id dari database yang sudah ada (kecuali milik kandidat itu sendiri)
            $inputIds = array_column($candidates, 'id');
            $inputEmployeeIds = array_column($candidates, 'employee_id');

            $existing = Candidate::whereIn('employee_id', $inputEmployeeIds)
                ->whereNotIn('id', $inputIds)
                ->pluck('employee_id')
                ->toArray();

            if (!empty($existing)) {
                return response()->json([
                    'success' => false,
                    'message' => 'One or more employee_id already exist in the database.',
                    'duplicates' => $existing
                ], 422);
            }

            // 3. Lakukan update
            foreach ($candidates as $data) {
                if (isset($data['id'], $data['employee_id'])) {
                    Candidate::where('id', $data['id'])->update([
                        'employee_id' => $data['employee_id']
                    ]);
                }
            }

            // 4. Ubah Filename gambar menjadi employee_id
            // Ambil semua kandidat dengan pict (id + employee_id sudah ada di $candidates)
            $ids = collect($candidates)->pluck('id');

            // Load semua kandidat + relasinya sekali saja
            $candidateModels = Candidate::with('candidatepict')
                ->whereIn('id', $ids)
                ->get()
                ->keyBy('id'); // supaya bisa akses cepat by id

            /*
            foreach ($candidates as $data) {
                if (!isset($data['id'], $data['employee_id'])) {
                    continue;
                }

                $candidate = $candidateModels->get($data['id']);
                if (!$candidate || !$candidate->candidatepict || !$candidate->candidatepict->pict_name) {
                    continue;
                }

                $oldPict = $candidate->candidatepict;
                $extension = pathinfo($oldPict->pict_name, PATHINFO_EXTENSION);
                $oldPath = $oldPict->pict_name;
                $newPath = $data['employee_id'] . '.' . $extension;

                if (Storage::disk('public')->exists($oldPath)) {
                    // Hindari overwrite
                    if (Storage::disk('public')->exists($newPath)) {
                        $newPath = $data['employee_id'] . '_' . uniqid() . '.' . $extension;
                    }

                    DB::transaction(function () use ($oldPict, $oldPath, $newPath) {
                        Storage::disk('public')->move($oldPath, $newPath);
                        $oldPict->pict_name = basename($newPath);
                        $oldPict->save();
                    });
                }
            }
            */

            //Update Foto Idcard
            foreach ($candidates as $data) {

                // Check JOIN dulu ke candidatepict
                $check_join = DB::table('candidates')
                    ->join('candidatespict', 'candidates.id', '=', 'candidatespict.candidate_id')
                    ->select('candidatespict.pict_name')
                    ->where('candidates.id', $data['id']);
                    

                if ($check_join->count() > 0) {

                    $oldPict = $check_join->first();                  
                    // get file and rename file     
                    $oldPath = $oldPict->pict_name;
                    $file = Storage::get($oldPath);
                    $extension = pathinfo($oldPict->pict_name, PATHINFO_EXTENSION);
                    $oldPath = $oldPict->pict_name;
                    $newPath = $data['employee_id'] . '.' . $extension;
                    // rename file
                    // Storage::disk('public')->move($oldPath, $newPath);
                    rename(public_path('storage/' . $oldPath), public_path('storage/' . $newPath));



                    //Update Database
                    CandidatePict::where('candidate_id', $data['id'])->update([
                        'pict_name' => $data['employee_id']. '.' . $extension
                    ]);
                } else {
                    continue;
                }
            }

            // 5. Kembalikan response sukses
            return response()->json([
                'success' => true,
                'message' => 'Employee IDs updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deletecandidate($ids)
    {
        $idArray = explode(',', $ids);

        foreach ($idArray as $id) {
            $candidate = Candidate::find($id);
            if ($candidate) {
                // Delete candidate picture if it exists
                if ($candidate->candidatepict && $candidate->candidatepict->pict_name) {
                    // Storage::delete($candidate->candidatepict->pict_name);
                    $candidate->candidatepict->delete();
                }
                $candidate->delete();
            }
        }

        return response()->json(['success' => true]);
    }

    public function printIDCard(Request $request)
    {
        // Validasi input array kandidat
        $request->validate([
            'candidates' => 'required|array|min:1',
            'candidates.*.employee_id' => 'required|string|max:255',
            'candidates.*.name' => 'required|string|max:255',
            'candidates.*.ctpat' => 'required|integer|min:0|max:1',
        ]);

        $validCandidates = [];
        $skipped = [];
        $card_template = '';

        foreach ($request->candidates as $candidateData) {
            $employee = Candidate::with('candidatepict')
                ->where('employee_id', $candidateData['employee_id'])
                ->first();

            if (!$employee || !$employee->candidatepict) {
                $skipped[] = [
                    'employee_id' => $candidateData['employee_id'],
                    'status' => 'failed',
                    'reason' => 'Employee or photo not found'
                ];
                continue;
            }

            // check card template based on department, job level, and ctpat
            $card_template = IdCardTemplate::whereJsonContains('department', $employee->department)
                ->whereJsonContains('joblevel', $employee->job_level)
                ->where('ctpat', $candidateData['ctpat'])
                ->first();

            $card_template_path = $card_template ? $card_template->image_path : null;

            $validCandidates[] = [
                'name' => $candidateData['name'],
                'job_level' => $employee->job_level,
                'department' => $employee->department,
                'employee_id' => $employee->employee_id,
                'photo_filename' => $employee->candidatepict->pict_name,
                'card_template' => $card_template_path,
                'ctpat' => $candidateData['ctpat'],
            ];
        }

        if (empty($validCandidates)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada kandidat valid.',
                'skipped' => $skipped
            ], 400);
        }

        try {
            Log::info('Mengirim batch kandidat ke Flask:', $validCandidates);

            // Kirim semua kandidat dalam satu request
            $response = Http::post('http://10.10.100.193:5000/print', $validCandidates);

            $responseData = $response->json();

            Log::info('Respons dari Flask:', [
                'http_status' => $response->status(),
                'body' => $responseData
            ]);

            //Update hanya kandidat yang berhasil dicetak
            foreach ($responseData as $result) {
                if (isset($result['employee_id']) && $result['status'] === 'success') {
                    Candidate::where('employee_id', $result['employee_id'])
                        ->update(['isPrinted' => 1]);
                }
            }

            return response()->json([
                'success' => true,
                'generated_pdf' => $responseData[0]['combined_output'] ?? null,
                'total_printed' => $responseData[0]['total_idcards'] ?? count($validCandidates),
                'details' => $responseData,
                'skipped' => $skipped
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal mengirim ke Flask:', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghubungi server cetak.',
                'error' => $e->getMessage(),
                'skipped' => $skipped
            ], 500);
        }
    }
}
