<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\CandidatePict;
use Yajra\DataTables\DataTables;

class CandidateController extends Controller
{
    public function getCandidate()
    {
        // Logic to retrieve candidate data
        $candidates = Candidate::with('candidatepict')->get();
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

    public function editcandidate($id)
    {
        return Candidate::with('candidatepict')->findOrFail($id);
        return response()->json($candidates);
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


        // If pict is provided, update it with updatecandidatepict function
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
        return redirect('/candidate/takephoto')->with('success', 'Candidate updated successfully.');
    }

    public function deletecandidate($id)
    {
        // Logic to delete candidate data
        return redirect()->route('candidate')->with('success', 'Candidate deleted successfully.');
    }
}
