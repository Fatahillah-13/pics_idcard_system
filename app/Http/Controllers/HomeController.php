<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\CandidatePict;
use App\Models\Department;
use App\Models\JobLevel;

class HomeController extends Controller
{
    public function pageView($routeName, $page = null, $data = [])
    {
        // Construct the view name based on the provided routeName and optional page parameter
        $viewName = ($page) ? $routeName . '.' . $page : $routeName;

        // Inject special logic for a AddCandidate view
        if ($viewName === 'pics.AddCandidate') {
            $latestPict = CandidatePict::orderBy('pict_number', 'desc')->first();
            $nextPictNumber = $latestPict ? $latestPict->pict_number + 1 : 1;

            $data['latestPict'] = $latestPict;
            $data['nextPictNumber'] = $nextPictNumber;
        }

        // Check if the constructed view exists
        if (View::exists($viewName)) {
            // If the view exists, return the view
            return view($viewName, $data);
        } else {
            // If the view doesn't exist, return a 404 error
            abort(404);
        }
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
                    'pict_number' => $candidates->candidatepict ? $candidates->candidatepict->pict_number : null,
                ]
            ];
        }));
    }

    public function departmentChoices(Request $request){
        // Logic to handle department choices
        $departments = Department::all();

        return response()->json($departments->map(function ($department){
            return [
                'label' => $department->department_name,
                'value' => $department->department_name,
            ];
        }));
    }

    public function jobLevelChoices(Request $request){
        // Logic to handle department choices
        $joblevels = JobLevel::all();

        return response()->json($joblevels->map(function ($joblevel){
            return [
                'label' => $joblevel->level_name,
                'value' => $joblevel->level_name,
            ];
        }));
    }
}
