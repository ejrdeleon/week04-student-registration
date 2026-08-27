<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display the dashboard with statistics.
     */
    public function dashboard()
    {
        $totalStudents    = Student::notArchived()->count();
        $activeStudents   = Student::active()->count();
        $newThisMonth     = Student::notArchived()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $recentStudents   = Student::notArchived()->latest()->take(5)->get();
        $byProgram        = Student::notArchived()
            ->selectRaw('program, COUNT(*) as total')
            ->groupBy('program')
            ->orderByDesc('total')
            ->get();
        $byYearLevel      = Student::notArchived()
            ->selectRaw('year_level, COUNT(*) as total')
            ->groupBy('year_level')
            ->orderBy('year_level')
            ->get();

        // Monthly registration counts for the last 6 months
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date          = now()->subMonths($i);
            $monthlyData[] = [
                'month' => $date->format('M Y'),
                'count' => Student::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count(),
            ];
        }

        return view('dashboard.index', compact(
            'totalStudents',
            'activeStudents',
            'newThisMonth',
            'recentStudents',
            'byProgram',
            'byYearLevel',
            'monthlyData'
        ));
    }

    /**
     * List all registered students with search, filter, and pagination.
     */
    public function index(Request $request)
    {
        $search    = $request->input('search');
        $program   = $request->input('program');
        $yearLevel = $request->input('year_level');
        $status    = $request->input('status');

        $students = Student::query()
            ->search($search)
            ->byProgram($program)
            ->byYearLevel($yearLevel)
            ->when($status, fn ($q) => $q->where('status', $status), fn ($q) => $q->notArchived())
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $programs   = Student::PROGRAMS;
        $yearLevels = Student::YEAR_LEVELS;

        return view('students.index', compact('students', 'programs', 'yearLevels', 'search', 'program', 'yearLevel', 'status'));
    }

    /**
     * Show the registration form.
     */
    public function create()
    {
        $programs   = Student::PROGRAMS;
        $yearLevels = Student::YEAR_LEVELS;
        $genders    = Student::GENDERS;

        return view('students.create', compact('programs', 'yearLevels', 'genders'));
    }

    /**
     * Validate, store, and upload the registration.
     */
    public function store(StoreStudentRequest $request)
    {
        $validated = $request->validated();

        // Store file in storage/app/public/profile_pictures — only path saved in DB
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        $validated['profile_picture'] = $path;

        $student = Student::create($validated);

        return redirect()
            ->route('students.show', $student->id)
            ->with('success', "Student {$student->fullName()} has been registered successfully!");
    }

    /**
     * Show a single student's profile.
     */
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    /**
     * Show the edit form for an existing student.
     */
    public function edit(Student $student)
    {
        $programs   = Student::PROGRAMS;
        $yearLevels = Student::YEAR_LEVELS;
        $genders    = Student::GENDERS;

        return view('students.edit', compact('student', 'programs', 'yearLevels', 'genders'));
    }

    /**
     * Update the student's information.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $validated = $request->validated();

        // If a new profile picture was uploaded, replace the old one
        if ($request->hasFile('profile_picture')) {
            // Delete old file if it's not the placeholder
            if ($student->profile_picture && $student->profile_picture !== 'profile_pictures/placeholder.png') {
                Storage::disk('public')->delete($student->profile_picture);
            }
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        } else {
            // Keep the existing profile picture
            unset($validated['profile_picture']);
        }

        $student->update($validated);

        return redirect()
            ->route('students.show', $student->id)
            ->with('success', "Student information has been updated successfully!");
    }

    /**
     * Archive (soft-delete) a student record.
     */
    public function destroy(Student $student)
    {
        $student->update(['status' => 'archived']);

        return redirect()
            ->route('students.index')
            ->with('success', "Student {$student->fullName()} has been archived.");
    }
}
