<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\CandidatePict;

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
        $candidates = Candidate::all(); // Fetch all candidates from the database

        return response()->json($candidates->map(function ($candidates) {
            return [
                'label' => $candidates->name,
                'value' => $candidates->name,
                'customProperties' => [
                    'candidateID' => $candidates->id
                ]
            ];
        }));
    }
}
