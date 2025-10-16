<?php

namespace App\Http\Controllers;

use App\Models\IdCardTemplate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Candidate;
use App\Models\Department;
use App\Models\JobLevel;
use Yajra\DataTables\Facades\DataTables;

class SettingsController extends Controller
{
    // Method to Show ID Card Template Gallery
    public function showGallery()
    {
        $templates = IdCardTemplate::latest()->get(); // Get all uploaded templates
        return view('settings.CardTemplates', compact('templates'));
    }

    public function showPrintHistory()
    {
        //show the view
        return view('settings.printHistory');
    }

    // method to show employee
    public function printHistory()
    {
        // Logic to retrieve candidate data
        $candidates = Candidate::whereHas('candidatepict', function ($query) {
            $query->whereNotNull('pict_name');
        })->where('isPrinted', 1)->with('candidatepict')->get();
        return DataTables::of($candidates)->make(true);
    }

    // Method to Upload ID Card Template
    public function uploadIdCardTemplate(Request $request)
    {
        $request->validate([
            'job_level' => 'required|array',
            'job_level.*' => 'string|max:255',
            'department' => 'required|array',
            'department.*' => 'string|max:255',
            'ctpat' => 'required|in:0,1',
            'image_path' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('image_path');
        $filename = $file->getClientOriginalName();
        $file->storeAs('idCardTemplate', $filename, 'public');
        $filePath = 'storage/idCardTemplate/' . $filename;

        $cardTemplate = new IdCardTemplate();
        $cardTemplate->joblevel = json_encode($request->job_level);
        $cardTemplate->department = json_encode($request->department);
        $cardTemplate->ctpat = $request->ctpat;
        $cardTemplate->image_path = $filePath;
        $cardTemplate->save();

        return response()->json(['success' => true]);
    }

    // Method to Show Add ID Card Template Form
    public function addIdCardTemplate()
    {
        $departments = \App\Models\Department::all();
        $joblevels = \App\Models\JobLevel::all();
        return view('settings.AddTemplate', compact('departments', 'joblevels'));
    }

    // Method to Show Edit ID Card Template Form
    public function editIdCardTemplate($id)
    {
        $cardTemplate = IdCardTemplate::findOrFail($id);
        $selectedDepartments = json_decode($cardTemplate->department, true) ?: [];
        $selectedJoblevels = json_decode($cardTemplate->joblevel, true) ?: [];

        // Ambil semua data referensi dari tabel departemen & job level
        $allDepartments = Department::all();
        $allJoblevels = JobLevel::all();

        return view('settings.EditTemplate', [
            'cardTemplate' => $cardTemplate,
            'departments' => $allDepartments,
            'joblevels' => $allJoblevels,
            'selectedDepartments' => $selectedDepartments,
            'selectedJoblevels' => $selectedJoblevels,
        ]);
    }

    // Method to Update ID Card Template
    public function updateIdCardTemplate(Request $request, $id)
    {
        $request->validate([
            'job_level' => 'nullable|array',
            'job_level.*' => 'string|max:255',
            'department' => 'nullable|array',
            'department.*' => 'string|max:255',
            'ctpat' => 'nullable|in:0,1',
            'image_path' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $cardTemplate = IdCardTemplate::findOrFail($id);

        $cardTemplate->joblevel = $request->job_level ? json_encode($request->job_level) : null;
        $cardTemplate->department = $request->department ? json_encode($request->department) : null;
        $cardTemplate->ctpat = $request->ctpat;

        if ($request->hasFile('image_path')) {
            // Delete old image if exists
            if ($cardTemplate->image_path && file_exists(public_path($cardTemplate->image_path))) {
                unlink(public_path($cardTemplate->image_path));
            }

            $file = $request->file('image_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('idCardTemplate', $filename, 'public');
            $cardTemplate->image_path = 'storage/idCardTemplate/' . $filename;
        }

        $cardTemplate->save();

        return response()->json(['success' => true,]);
    }

    // Method to Delete ID Card Template
    public function deleteIdCardTemplate($id)
    {
        $cardTemplate = IdCardTemplate::findOrFail($id);
        $filePath = public_path($cardTemplate->image_path);
        if (file_exists($filePath)) {
            unlink($filePath); // Delete the file from storage
        }
        $cardTemplate->delete(); // Delete the record from the database
        return response()->json(['success' => true]);
    }

    // Method to Display Users
    public function users()
    {
        return view('settings.Users');
    }

    // Method to Get Users Data
    public function getUsers()
    {
        $users = User::latest()->get();
        return datatables()->of($users)
            ->addColumn('action', function ($user) {
                return view('settings.users', compact('user'));
            })
            ->make(true);
    }

    // Method to store Users Data
    public function storeUsers(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|integer',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->save();

        return response()->json(['success' => true]);
    }

    // Method to Edit User
    public function editUsers($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Method to Update User
    public function updateUsers(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|integer',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->role = $request->role;
        $user->save();

        return response()->json(['success' => true]);
    }

    // Method to Delete User
    public function deleteUsers($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['success' => true]);
    }
}
