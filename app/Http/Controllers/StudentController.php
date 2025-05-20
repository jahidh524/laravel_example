<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'batch' => 'required|string|max:50',
            'roll' => 'required|numeric',
            'gpa' => 'required|numeric|between:0,4.0',
            'contact' => 'required|numeric',
            'profile_img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_img')) {
            $image = $request->file('profile_img');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
            $validated['profile_img'] = $imageName;
        }

        Student::create($validated);

        return redirect()->route('students.index')
                        ->with('success', 'Student added successfully!');
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'batch' => 'required|string|max:50',
            'roll' => 'required|numeric',
            'gpa' => 'required|numeric|between:0,4.0',
            'contact' => 'required|numeric',
        ]);

        $student->update($validated);

        return redirect()->route('students.index')
                        ->with('success', 'Student updated successfully!');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        
        // Delete profile image if exists
        if ($student->profile_img && File::exists(public_path('uploads/' . $student->profile_img))) {
            File::delete(public_path('uploads/' . $student->profile_img));
        }
        
        $student->delete();

        return redirect()->route('students.index')
                        ->with('success', 'Student deleted successfully!');
    }
}