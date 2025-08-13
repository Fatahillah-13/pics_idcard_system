<?php

namespace App\Http\Controllers;

use App\Models\IdCardTemplate;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Candidate;
use Yajra\DataTables\Facades\DataTables;

class SettingsController extends Controller
{
    // Method to Show ID Card Template Gallery
    public function showGallery()
    {
        $templates = IdCardTemplate::latest()->get(); // Get all uploaded templates
        return view('settings.CardTemplates', compact('templates'));
    }

    public function showPrintHistory(){
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
