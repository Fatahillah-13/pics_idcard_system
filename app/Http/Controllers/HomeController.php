<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\CandidatePict;
use App\Models\Department;
use App\Models\JobLevel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HomeController extends Controller
{
    public function pictNumber()
    {
        // Logic to get the latest pict number
        $latestPict = CandidatePict::orderBy('pict_number', 'desc')->first();
        $nextPictNumber = $latestPict ? $latestPict->pict_number + 1 : 1;

        return view('pics.AddCandidate', [
            'nextPictNumber' => $nextPictNumber,
            'latestPict' => $latestPict,
        ]);
    }

    public function candidatechoices(Request $request)
    {
        // Logic to handle candidate choices
        $candidates = Candidate::with('candidatepict')->get(); // Fetch all candidates from the database

        return response()->json($candidates->map(function ($candidates) {
            return [
                'label' => $candidates->name,
                'value' => $candidates->name,
                'customProperties' => [
                    'candidateID' => $candidates->id,
                    'birthplace' => $candidates->birthplace,
                    'birthdate' => $candidates->birthdate,
                    'first_working_day' => $candidates->first_working_day,
                    'job_level' => $candidates->job_level,
                    'department' => $candidates->department,
                    'pict_number' => $candidates->candidatepict ? $candidates->candidatepict->pict_number : null,
                ],
            ];
        }));
    }

    public function candidateNoPictChoices(Request $request)
    {
        // Logic to handle candidates without pictures
        $candidates = Candidate::whereDoesntHave('candidatepict', function ($query) {
            $query->whereNotNull('pict_name');
        })->get();

        return response()->json($candidates->map(function ($candidates) {
            return [
                'label' => $candidates->name,
                'value' => $candidates->name,
                'customProperties' => [
                    'candidateID' => $candidates->id,
                    'birthplace' => $candidates->birthplace,
                    'birthdate' => $candidates->birthdate,
                    'first_working_day' => $candidates->first_working_day,
                    'job_level' => $candidates->job_level,
                    'department' => $candidates->department,
                    'pict_number' => $candidates->candidatepict ? $candidates->candidatepict->pict_number : null,
                ],
            ];
        }));
    }

    public function departmentChoices(Request $request)
    {
        // Logic to handle department choices
        $departments = Department::all();

        return response()->json($departments->map(function ($department) {
            return [
                'label' => $department->department_name,
                'value' => $department->department_name,
            ];
        }));
    }

    public function jobLevelChoices(Request $request)
    {
        // Logic to handle department choices
        $joblevels = JobLevel::all();

        return response()->json($joblevels->map(function ($joblevel) {
            return [
                'label' => $joblevel->level_name,
                'value' => $joblevel->level_name,
            ];
        }));
    }

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
        // Logic to retrieve candidate data - use query builder for server-side pagination
        $query = Candidate::whereHas('candidatepict', function ($query) {
            $query->whereNull('pict_name');
        })->with('candidatepict');

        return DataTables::of($query)->make(true);
    }

    public function getCandidateDatatable()
    {
        // Logic to retrieve candidate data - use query builder for server-side pagination
        $query = Candidate::whereHas('candidatepict', function ($query) {
            $query->whereNotNull('pict_name');
        })->where('isPrinted', 0)->with('candidatepict');

        return DataTables::of($query)->make(true);
    }
}
