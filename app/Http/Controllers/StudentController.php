<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * List all registered students.
     */
    public function index()
    {
        $students = Student::latest()->get();
        return view('students.index', compact('students'));
    }

    /**
     * Show the registration form.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Validate, store, and upload the registration.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'      => 'required|string|max:20|unique:students,student_id',
            'first_name'      => 'required|string|max:100',
            'middle_name'     => 'nullable|string|max:100',
            'last_name'       => 'required|string|max:100',
            'email'           => 'required|email|unique:students,email',
            'mobile_number'   => 'required|numeric|digits_between:10,15',
            'gender'          => 'required|in:Male,Female,Other',
            'date_of_birth'   => 'required|date|before:today',
            'program'         => 'required|string|max:100',
            'year_level'      => 'required|string|max:20',
            'address'         => 'required|string|max:255',
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Store file in storage/app/public/profile_pictures, keep only the path in DB
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $validated['profile_picture'] = $path;

        $student = Student::create($validated);

        return redirect()
            ->route('students.show', $student->id)
            ->with('success', 'Student registered successfully!');
    }

    /**
     * Show a single student's profile.
     */
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }
}
