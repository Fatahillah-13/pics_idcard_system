<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\CandidatePict;

class CandidateController extends Controller
{

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
        return redirect('/pics/AddCandidate')->with('success', 'Candidate added successfully.');
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
            'inputName' => 'required|string|max:255',
            'inputBirthPlace' => 'required|string|max:255',
            'inputJobLevel' => 'required|string|max:255',
            'inputDepartment' => 'required|string|max:255',
            'inputBirthDate' => 'required|date',
            'inputFirstWorkDay' => 'required|date',
            // Add other validation rules as needed
        ]);
        $id = $request->route('id');

        // Find the candidate by ID and update the data
        $candidate = Candidate::findOrFail($id);
        $candidate->name = $request->inputName;
        $candidate->birthplace = $request->inputBirthPlace;
        $candidate->job_level = $request->inputJobLevel;
        $candidate->department = $request->inputDepartment;
        $candidate->birthdate = $request->inputBirthDate;
        $candidate->first_working_day = $request->inputFirstWorkDay;
        // Add other fields to update as needed
        $candidate->save();
        // If pict number is provided, update it in the database
        if ($request->has('inputPictNumber')) {
            $candidatePict = CandidatePict::where('candidate_id', $id)->first();
            if ($candidatePict) {
                $candidatePict->pict_number = $request->inputPictNumber;
                $candidatePict->save();
            }
        }
        // If pict is provided, update it with updatecandidatepict function
        if ($request->has('inputPict')) {
            // pass the request to updatecandidatepict function
            $this->updatecandidatepict($request);
        }
        return redirect()->route('candidate')->with('success', 'Candidate updated successfully.');
    }

    public function deletecandidate($id)
    {
        // Logic to delete candidate data
        return redirect()->route('candidate')->with('success', 'Candidate deleted successfully.');
    }

    public function updatecandidatepict(Request $request)
    {
        // Logic to store candidate picture

        // Redirect back to the candidate page with a success message
        return redirect('/pics/AddCandidate')->with('success', 'Candidate picture added successfully.');
    }
}
