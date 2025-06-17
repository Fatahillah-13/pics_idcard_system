<?php

namespace App\Http\Controllers;

use App\Models\IdCardTemplate;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    // Method to Show ID Card Template Gallery
    public function showGallery()
    {
        $templates = IdCardTemplate::latest()->get(); // Get all uploaded templates
        return view('settings.CardTemplates', compact('templates'));
    }

    // Method to Upload ID Card Template
    public function uploadIdCardTemplate(Request $request)
    {
        $request->validate([
            'job_level' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'ctpat' => 'required|in:0,1',
            'image_path' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('image_path');
        $filename = $file->getClientOriginalName();
        $file->storeAs('idCardTemplate', $filename, 'public');
        $filePath = 'storage/idCardTemplate/' . $filename;

        $cardTemplate = new IdCardTemplate();
        $cardTemplate->joblevel = $request->job_level;
        $cardTemplate->department = $request->department;
        $cardTemplate->ctpat = $request->ctpat;
        $cardTemplate->image_path = $filePath;
        $cardTemplate->save();

        return response()->json(['success' => true]);
    }
}
