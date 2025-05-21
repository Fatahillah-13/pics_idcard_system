<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\CandidatePict;

class CandidateController extends Controller
{
    public function candidate(){
        // Get latest pict_number from the database
        $latestPict = CandidatePict::orderBy('pict_number', 'desc')->first();

        // Pass to the view
        return view('pics.AddCandidate', [
            'latestPict' => $latestPict,
        ]);
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
        return redirect('/pics/AddCandidate')->with('success', 'Candidate added successfully.');
    }

    public function editcandidate($id)
    {
        // Logic to edit candidate data
        return view('edit-candidate', compact('id'));
    }

    public function updatecandidate(Request $request, $id)
    {
        // Logic to update candidate data
        return redirect()->route('candidate')->with('success', 'Candidate updated successfully.');
    }

    public function deletecandidate($id)
    {
        // Logic to delete candidate data
        return redirect()->route('candidate')->with('success', 'Candidate deleted successfully.');
    }
}
