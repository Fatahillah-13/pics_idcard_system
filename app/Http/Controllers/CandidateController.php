<?php

namespace App\Http\Controllers;

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
        })->with('candidatepict')->get();
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
                    $birthdate = isset($row[5]) && !empty($row[5])
                        ? \Carbon\Carbon::parse($row[5])
                        : null;
                } catch (\Exception $e) {
                    $birthdate = null;
                }

                // Parse first working day
                try {
                    $firstWorkingDay = isset($row[6]) && !empty($row[6])
                        ? \Carbon\Carbon::parse($row[6])
                        : null;
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
                    // Get the highest pict_number in the database and increment by 1
                    $maxPictNumber = CandidatePict::max('pict_number');
                    $nextPictNumber = $maxPictNumber ? $maxPictNumber + 1 : 1;

                    $candidatePict = new CandidatePict();
                    $candidatePict->pict_number = $nextPictNumber;
                    $candidatePict->candidate_id = $candidate->id;
                    $candidate->candidatepict()->save($candidatePict);
                }

                $insertedCount++;
            }

            return response()->json([
                'success' => true,
                'message' => "$insertedCount candidates imported successfully.",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the file: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function editcandidate($id)
    {
        $candidate = Candidate::findOrFail($id);
        return response()->json([
            'name' => $candidate->name,
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
                    $filename = 'pic_' . time() . '.' . $type; // Menggunakan timestamp sebagai nama file
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
                    Storage::delete($candidate->candidatepict->pict_name);
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
            $response = Http::post('http://localhost:5000/print', $validCandidates);

            Log::info('Respons dari Flask:', [
                'http_status' => $response->status(),
                'body' => $response->json()
            ]);

            return response()->json([
                'success' => true,
                'generated_pdf' => $response->json()[0]['combined_output'] ?? null,
                'total_printed' => $response->json()[0]['total_idcards'] ?? count($validCandidates),
                'details' => $response->json(),
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
